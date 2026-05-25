@extends('layouts.app')

@section('title', '日本酒・ワイン在庫管理')

@section('content')

<div class="mb-6">
    <a href="{{ route('home') }}"
        class="inline-flex h-12 items-center justify-center rounded-full bg-gradient-to-r from-cyan-400 to-teal-500 px-8 font-bold text-white shadow-md transition hover:-translate-y-0.5 hover:shadow-lg">
        ← Menuへ
    </a>
</div>

<div class="mb-8 text-center">
    <div class="inline-flex rounded-full bg-white/80 px-10 py-3 shadow-md ring-1 ring-amber-100">
        <h2 class="text-3xl font-black tracking-[0.18em] text-amber-700">
            出庫登録
        </h2>
    </div>
</div>

<form action="{{ route('stock.out.store', $stock->stock_id) }}"
    method="POST"
    onsubmit="return confirm('入力内容を登録しますか？');"
    class="mx-auto max-w-2xl rounded-[28px] bg-white/85 p-8 shadow-lg ring-1 ring-amber-100">

    @csrf

    <div class="space-y-6">

        <div class="grid items-center gap-3 md:grid-cols-[180px_1fr]">
            <label class="font-bold text-slate-700 md:text-right">入庫日</label>
            <div class="w-full rounded-xl border border-amber-100 bg-gradient-to-br from-yellow-50 via-amber-50 to-orange-100 px-4 py-3 text-slate-700 shadow-sm">
                {{ $stock->arrival_date->format('Y/m/d') }}
            </div>
        </div>

        <div class="grid items-center gap-3 md:grid-cols-[180px_1fr]">
            <label class="font-bold text-slate-700 md:text-right">お酒の種類名</label>
            <div class="w-full rounded-xl border border-amber-100 bg-gradient-to-br from-yellow-50 via-amber-50 to-orange-100 px-4 py-3 text-slate-700 shadow-sm">
                {{ $stock->item->category->category_name }}
            </div>
        </div>

        <div class="grid items-center gap-3 md:grid-cols-[180px_1fr]">
            <label class="font-bold text-slate-700 md:text-right">ラベル名（商品名）</label>
            <div class="w-full rounded-xl border border-amber-100 bg-gradient-to-br from-yellow-50 via-amber-50 to-orange-100 px-4 py-3 text-slate-700 shadow-sm">
                {{ $stock->item->item_name }}
            </div>
        </div>

        <div class="grid items-center gap-3 md:grid-cols-[180px_1fr]">
            <label class="font-bold text-slate-700 md:text-right">出庫日</label>
            <input type="date"
                name="issuing_date"
                value="{{ old('issuing_date', date('Y-m-d')) }}"
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-amber-400 focus:outline-none focus:ring-4 focus:ring-amber-100">
        </div>

        <div class="grid items-center gap-3 md:grid-cols-[180px_1fr]">
            <label class="font-bold text-slate-700 md:text-right">出庫本数</label>
            <select name="issuing_count"
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-amber-400 focus:outline-none focus:ring-4 focus:ring-amber-100">
                @for ($i = 1; $i <= min(10, $stock->receiving_count); $i++)
                    <option value="{{ $i }}">
                        {{ $i }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="grid items-center gap-3 md:grid-cols-[180px_1fr]">
            <label class="font-bold text-slate-700 md:text-right">評価</label>
           @php
    $defaultEvaluation = old('evaluation', $latestIssuing->evaluation ?? '★★★☆☆');
@endphp

<select name="evaluation"
    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-amber-400 focus:outline-none focus:ring-4 focus:ring-amber-100">
    <option value="★☆☆☆☆" {{ $defaultEvaluation == '★☆☆☆☆' ? 'selected' : '' }}>★☆☆☆☆</option>
    <option value="★★☆☆☆" {{ $defaultEvaluation == '★★☆☆☆' ? 'selected' : '' }}>★★☆☆☆</option>
    <option value="★★★☆☆" {{ $defaultEvaluation == '★★★☆☆' ? 'selected' : '' }}>★★★☆☆</option>
    <option value="★★★★☆" {{ $defaultEvaluation == '★★★★☆' ? 'selected' : '' }}>★★★★☆</option>
    <option value="★★★★★" {{ $defaultEvaluation == '★★★★★' ? 'selected' : '' }}>★★★★★</option>
</select>
        </div>

        <div class="grid items-center gap-3 md:grid-cols-[180px_1fr]">
            <label class="font-bold text-slate-700 md:text-right">リピート</label>
            @php
    $defaultRepeat = old('repeat', $latestIssuing->repeat ?? config('constants.REPEAT_NO'));
@endphp

<select name="repeat"
    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-amber-400 focus:outline-none focus:ring-4 focus:ring-amber-100">
    <option value="{{ config('constants.REPEAT_YES') }}"
        {{ $defaultRepeat == config('constants.REPEAT_YES') ? 'selected' : '' }}>
        リピートしたい
    </option>

    <option value="{{ config('constants.REPEAT_NO') }}"
        {{ $defaultRepeat == config('constants.REPEAT_NO') ? 'selected' : '' }}>
        リピートしない
    </option>
</select>
        </div>

        <div class="pt-4 text-center">
            <button type="submit"
                class="inline-flex h-12 items-center justify-center rounded-full bg-gradient-to-r from-yellow-50 via-amber-50 to-orange-100 px-12 font-bold text-amber-700 shadow-md ring-1 ring-amber-100 transition hover:-translate-y-0.5 hover:shadow-lg">
                登録
            </button>
        </div>

    </div>

</form>

@endsection
