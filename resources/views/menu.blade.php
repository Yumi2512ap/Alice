@extends('layouts.app')

@section('title', 'メインメニュー')

@section('content')
<div class="menu-box">
<a class="menu-button" href="{{ route('stock.index') }}">在庫一覧</a>
<a class="menu-button" href="{{ route('stock.new') }}">在庫 新規登録</a>
</div>
@endsection
