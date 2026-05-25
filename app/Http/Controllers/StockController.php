<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Item;
use App\Models\Category;
use App\Models\Issuing;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StockController extends Controller
{

public function index(Request $request)
{
$query = Stock::with(['item.category'])
->where('stat_id', config('constants.STAT_IN_STOCK'));

if ($request->filled('keyword')) {
$keyword = $request->keyword;

$query->whereHas('item', function ($q) use ($keyword) {
$q->where('item_name', 'LIKE', "%{$keyword}%");
});
}

if ($request->filled('category_id')) {
$categoryId = $request->category_id;

$query->whereHas('item', function ($q) use ($categoryId) {
$q->where('category_id', $categoryId);
});
}

if ($request->filled('expired') && $request->expired == config('constants.EXPIRED_FLAG')) {
$query->whereDate('expiration_date', '<', Carbon::today());

if (!$query->exists()) {
return redirect()
->route('stock.index')
->with('message', '賞味期限切れは、ありません。');
}
}

if ($request->filled('sort')) {
switch ($request->sort) {
case config('constants.SORT_NEW'):
$query->orderBy('arrival_date', 'desc');
break;

case config('constants.SORT_QTY'):
$query->orderBy('receiving_count', 'desc');
break;

default:
$query->orderBy('stock_id', 'desc');
break;
}
} else {
$query->orderBy('stock_id', 'desc');
}

$stocks = $query->get();

$total = Stock::where('stat_id', config('constants.STAT_IN_STOCK'))->count();
$displayCount = $stocks->count();
$totalCount = $stocks->sum('receiving_count');

$categories = Category::all();

return view('stock.index', compact(
'stocks',
'categories',
'total',
'displayCount',
'totalCount'
));
}

// 出庫一覧
public function out(Request $request)
{
    $query = Stock::with([
        'item.category',
        'issuings' => function ($q) {
    $q->orderBy('issuing_date', 'desc')
      ->orderBy('issuing_id', 'desc');
}
    ])
    ->withMax('issuings', 'issuing_date')
    ->whereHas('issuings');

    if ($request->filled('keyword')) {
        $keyword = $request->keyword;

        $query->whereHas('item', function ($q) use ($keyword) {
            $q->where('item_name', 'LIKE', "%{$keyword}%");
        });
    }

    if ($request->filled('category_id')) {
        $categoryId = $request->category_id;

        $query->whereHas('item', function ($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        });
    }

   if ($request->filled('sort')) {
    switch ($request->sort) {
        case config('constants.SORT_NEW'):
            $query->orderBy('issuings_max_issuing_date', 'desc');
            break;

        case config('constants.SORT_QTY'):
            $query->withSum('issuings', 'issuing_count')
                ->orderBy('issuings_sum_issuing_count', 'desc');
            break;

        default:
            $query->orderBy('issuings_max_issuing_date', 'desc');
            break;
    }
} else {
    $query->orderBy('issuings_max_issuing_date', 'desc');
}

    $stocks = $query->get();

    $total = Issuing::count();
    $displayCount = $stocks->sum(function ($stock) {
        return $stock->issuings->count();
    });

    $totalCount = $stocks->sum(function ($stock) {
        return $stock->issuings->sum('issuing_count');
    });

    $categories = Category::all();

    return view('stock.out', compact(
        'stocks',
        'categories',
        'total',
        'displayCount',
        'totalCount'
    ));
}

// 新規登録画面
public function create()
{
    $categories = Category::all();

    return view('stock.new', compact('categories'));
}

// 新規登録処理
public function store(Request $request)
{
    $request->validate([
        'arrival_date' => 'required|date',
        'category_id' => 'required|exists:categories,category_id',
        'item_name' => 'required|string|max:100',
        'receiving_count' => 'required|integer|min:1|max:10',
        'expiration_date' => 'nullable|date',
    ]);

    $category = Category::findOrFail($request->category_id);

    $item = Item::create([
        'item_name' => $request->item_name,
        'category_id' => $request->category_id,
    ]);

    if ($request->filled('expiration_date')) {
        $expirationDate = $request->expiration_date;
    } else {
        $expirationDate = Carbon::parse($request->arrival_date)
            ->addDays($category->best_before_date_days);
    }

    Stock::create([
        'arrival_date' => $request->arrival_date,
        'receiving_count' => $request->receiving_count,
        'item_id' => $item->item_id,
        'stat_id' => config('constants.STAT_IN_STOCK'),
        'expiration_date' => $expirationDate,
    ]);

    return redirect()
        ->route('stock.index')
        ->with('message', '在庫を登録しました。');
}

// 編集画面
public function edit($id)
{
    $stock = Stock::with(['item.category'])->findOrFail($id);
    $categories = Category::all();

    return view('stock.edit', compact('stock', 'categories'));
}

// 更新処理
public function update(Request $request, $id)
{
    $request->validate([
        'arrival_date' => 'required|date',
        'category_id' => 'required|exists:categories,category_id',
        'item_name' => 'required|string|max:100',
        'receiving_count' => 'required|integer|min:1|max:10',
        'expiration_date' => 'nullable|date',
    ]);

    $stock = Stock::with('item')->findOrFail($id);

    $category = Category::findOrFail($request->category_id);

    if ($request->filled('expiration_date')) {
        $expirationDate = $request->expiration_date;
    } else {
        $expirationDate = Carbon::parse($request->arrival_date)
            ->addDays($category->best_before_date_days);
    }

    $stock->item->update([
        'item_name' => $request->item_name,
        'category_id' => $request->category_id,
    ]);

    $stock->update([
        'arrival_date' => $request->arrival_date,
        'receiving_count' => $request->receiving_count,
        'expiration_date' => $expirationDate,
    ]);

    return redirect()
        ->route('stock.index')
        ->with('message', '在庫を更新しました。');
}

// 削除処理
public function destroy($id)
{
$stock = Stock::findOrFail($id);
$stock->delete();

return redirect()
->route('stock.index')
->with('message', '在庫を削除しました。');
}


// 出庫登録画面
public function outCreate($id)
{
    $stock = Stock::with(['item.category'])->findOrFail($id);

    $latestIssuing = Issuing::whereHas('stock.item', function ($query) use ($stock) {
        $query->where('item_name', $stock->item->item_name)
              ->where('category_id', $stock->item->category_id);
    })
    ->latest('issuing_date')
    ->latest('issuing_id')
    ->first();

    return view('stock.out_create', compact('stock', 'latestIssuing'));
}

// 出庫登録処理
public function outStore(Request $request, $id)
{
    $stock = Stock::findOrFail($id);

    $request->validate([
        'issuing_date' => 'required|date',
        'issuing_count' => 'required|integer|min:1|max:' . $stock->receiving_count,
        'evaluation' => 'required|string',
        'repeat' => 'required',
    ]);

    Issuing::create([
        'stock_id' => $stock->stock_id,
        'issuing_date' => $request->issuing_date,
        'issuing_count' => $request->issuing_count,
        'evaluation' => $request->evaluation,
        'repeat' => $request->repeat,
    ]);

    $remainingCount = $stock->receiving_count - $request->issuing_count;

    $stock->update([
        'receiving_count' => $remainingCount,
        'stat_id' => $remainingCount === 0
            ? config('constants.STAT_OUT_STOCK')
            : config('constants.STAT_IN_STOCK'),
    ]);

    return redirect()
        ->route('stock.index')
        ->with('message', '出庫を登録しました。');
}
}
