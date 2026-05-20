<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Item;
use App\Models\Category;
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

// 在庫なし一覧
public function out(Request $request)
{
$query = Stock::with(['item.category'])
->where('stat_id', config('constants.STAT_OUT_STOCK'));

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
$query->orderBy('updated_at', 'desc');
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

$total = Stock::where('stat_id', config('constants.STAT_OUT_STOCK'))->count();
$displayCount = $stocks->count();
$totalCount = $stocks->sum('receiving_count');

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

return view('stock.edit', compact('stock'));
}

// 更新処理
public function update(Request $request, $id)
{
$request->validate([
'arrival_date' => 'required|date',
'receiving_count' => 'required|integer|min:1|max:10',
'expiration_date' => 'required|date',
]);

$stock = Stock::findOrFail($id);

$stock->update([
'arrival_date' => $request->arrival_date,
'receiving_count' => $request->receiving_count,
'expiration_date' => $request->expiration_date,
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
}
