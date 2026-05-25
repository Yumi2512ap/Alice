@extends('layouts.app')

@section('title', '日本酒・ワイン在庫管理')

@section('content')

<div class="mx-auto mt-10 max-w-3xl">

    <div class="mb-8 text-center">
    <div class="inline-flex rounded-full bg-white/80 px-10 py-3 shadow-md ring-1 ring-teal-100">
        <h2 class="text-3xl font-black tracking-[0.18em] text-teal-700">
            MAIN MENU
        </h2>
    </div>
</div>
    <div class="grid gap-5 md:grid-cols-3">

        <a href="{{ route('stock.new') }}"
            class="rounded-[32px] bg-gradient-to-br from-emerald-50 to-teal-100 px-6 py-12 text-center shadow-md ring-1 ring-emerald-100 transition duration-200 hover:-translate-y-1 hover:shadow-xl">
            <span class="text-2xl font-bold text-teal-700">
                新規登録
            </span>
        </a>

        <a href="{{ route('stock.index') }}"
            class="rounded-[32px] bg-gradient-to-br from-cyan-50 to-teal-100 px-6 py-12 text-center shadow-md ring-1 ring-cyan-100 transition duration-200 hover:-translate-y-1 hover:shadow-xl">
            <span class="text-2xl font-bold text-teal-700">
                在庫一覧
            </span>
        </a>

        <a href="{{ route('stock.out') }}"
            class="rounded-[32px] bg-gradient-to-br from-yellow-50 via-amber-50 to-orange-100 px-6 py-12 text-center shadow-md ring-1 ring-amber-100 transition duration-200 hover:-translate-y-1 hover:shadow-xl">
            <span class="text-2xl font-bold text-amber-700">
                出庫一覧
            </span>
        </a>

    </div>

</div>

@endsection
