@extends('layouts.app')

@section('title', '在庫一覧（在庫なし）')

@section('content')

<form method="GET" action="{{ route('stock.out') }}">
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

<button type="submit">検索</button>
<a href="{{ route('stock.out') }}">クリア</a>
<a href="{{ route('stock.index') }}">在庫ありへ</a>
</form>

<p>全 {{ $total }} 件中 {{ $displayCount }} 件</p>

<table>
<tr>
<th>入庫日</th>
<th>お酒の種類</th>
<th>ラベル名（商品名）</th>
<th>出庫日</th>
<th>出庫本数</th>
<th>評価</th>
<th>リピート</th>
</tr>

@foreach ($stocks as $stock)
@foreach ($stock->issuings as $issuing)
<tr>
<td>{{ $stock->arrival_date->format('Y/m/d') }}</td>
<td>{{ $stock->item->category->category_name }}</td>
<td>{{ $stock->item->item_name }}</td>
<td>{{ $issuing->issuing_date->format('Y/m/d') }}</td>
<td>{{ $issuing->issuing_count }}</td>
<td>{{ $issuing->evaluation }}</td>
<td>{{ $issuing->repeat == config('constants.REPEAT_YES') ? '○' : '×' }}</td>
</tr>
@endforeach
@endforeach

<tr>
<td colspan="4">総 本数</td>
<td colspan="3">{{ $totalCount }} 本</td>
</tr>
</table>

<p><a href="{{ route('home') }}">← Menuへ</a></p>

@endsection
