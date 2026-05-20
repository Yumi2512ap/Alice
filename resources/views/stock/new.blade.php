@extends('layouts.app')

@section('content')
<h1>在庫 新規登録</h1>

<form action="{{ route('stock.store') }}" method="POST">
@csrf

<div>
<label>在庫ID</label>
<input type="number" name="stock_id" readonly>
</div>

<div>
<label>入庫日</label>
<input type="date" name="arrival_date">
</div>

<div>
    <label>お酒の種類名</label>
    <select name="category_id">
        <option value="">選択してください</option>
        @foreach ($categories as $category)
            <option value="{{ $category->category_id }}">
                {{ $category->category_name }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label>ラベル名（商品名）</label>
    <input type="text" name="item_name">
</div>

<div>
<label>入庫本数</label>
<input type="number" name="receiving_count" min="1">
</div>

<div>
    <label for="expiration_date">賞味期限日</label>
    <input type="date" name="expiration_date" id="expiration_date">
</div>

<button type="submit">登録</button>
</form>

{{-- メインメニュー画面に遷移 --}}
<p><a href="{{ route('home') }}">← Menuへ</a></p>
@endsection
