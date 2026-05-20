@extends('layouts.app')

@section('title', '在庫一覧（在庫あり）')

@section('content')

<form method="GET" action="{{ route('stock.index') }}">
<div>
<label>ラベル名検索</label>
<input type="text" name="keyword" value="{{ request('keyword') }}">
</div>

<div>
<label>絞り込み（お酒の種類）</label>
<select name="category_id">
<option value="">すべて</option>
@foreach ($categories as $category)
<option value="{{ $category->category_id }}"
{{ request('category_id') == $category->category_id ? 'selected' : '' }}>
{{ $category->category_name }}
</option>
@endforeach
</select>
</div>

<div>
<label>並び替え</label>
<select name="sort">
<option value="">ー</option>
<option value="new" {{ request('sort') == 'new' ? 'selected' : '' }}>新着順</option>
<option value="qty" {{ request('sort') == 'qty' ? 'selected' : '' }}>本数が多い順</option>
</select>
</div>

<div>
<label>
<input type="checkbox" name="expired" value="1" {{ request('expired') == '1' ? 'checked' : '' }}>
賞味期限切れ
</label>
</div>

<button type="submit">検索</button>
<a href="{{ route('stock.index') }}">クリア</a>
<a href="{{ route('stock.out') }}">在庫なしへ</a>
</form>

<p>全 {{ $total }} 件中 {{ $displayCount }} 件</p>

<table>
<tr>
<th>入庫日</th>
<th>お酒の種類名</th>
<th>ラベル名（商品名）</th>
<th>入庫本数</th>
<th>賞味期限日</th>
<th>編集</th>
<th>削除</th>
<th>出庫</th>
</tr>

@foreach ($stocks as $stock)
<tr>
<td>{{ $stock->arrival_date->format('Y/m/d') }}</td>
<td>{{ $stock->item->category->category_name }}</td>
<td>{{ $stock->item->item_name }}</td>
<td>{{ $stock->receiving_count }}</td>
<td>{{ $stock->expiration_date->format('Y/m/d') }}</td>

<td>
<a href="{{ route('stock.edit', $stock->stock_id) }}">編集</a>
</td>

<td>
<form action="{{ route('stock.destroy', $stock->stock_id) }}" method="POST"
onsubmit="return confirm('本当に削除しますか？');">
@csrf
@method('DELETE')
<button type="submit">削除</button>
</form>
</td>

<td>
<a href="{{ route('stock.out.create', $stock->stock_id) }}">出庫</a>
</td>
</tr>
@endforeach

<tr>
<td colspan="3">総 本数</td>
<td colspan="5">{{ $totalCount }} 本</td>
</tr>
</table>

<p><a href="{{ route('home') }}">← Menuへ</a></p>

@endsection
