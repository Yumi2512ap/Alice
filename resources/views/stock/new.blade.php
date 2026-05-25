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
    <div class="inline-flex rounded-full bg-white/80 px-10 py-3 shadow-md ring-1 ring-emerald-100">
        <h2 class="text-3xl font-black tracking-[0.18em] text-emerald-700">
            新規登録
        </h2>
    </div>
</div>

<form action="{{ route('stock.store') }}"
    method="POST"
    onsubmit="return confirm('入力内容を登録しますか？');"
    class="mx-auto max-w-2xl rounded-[28px] bg-white/85 p-8 shadow-lg ring-1 ring-emerald-100">

    @csrf

    <div class="space-y-6">

        <div class="grid items-start gap-3 md:grid-cols-[180px_1fr]">
            <label class="pt-3 font-bold text-slate-700 md:text-right">
                入庫日
                <span class="ml-1 rounded-full bg-red-100 px-2 py-1 text-xs text-red-600">必須</span>
            </label>
            <div>
                <input type="date" name="arrival_date" value="{{ old('arrival_date', date('Y-m-d')) }}"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100">
                @error('arrival_date')
                    <p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid items-start gap-3 md:grid-cols-[180px_1fr]">
            <label class="pt-3 font-bold text-slate-700 md:text-right">
                お酒の種類名
                <span class="ml-1 rounded-full bg-red-100 px-2 py-1 text-xs text-red-600">必須</span>
            </label>
            <div>
                <select name="category_id"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100">
                    <option value="">選択してください</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}"
                            {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid items-start gap-3 md:grid-cols-[180px_1fr]">
            <label class="pt-3 font-bold text-slate-700 md:text-right">
    <span class="inline-flex items-center gap-2 whitespace-nowrap">
        ラベル名（商品名）
        <span class="shrink-0 rounded-full bg-red-100 px-2 py-1 text-xs text-red-600">必須</span>
    </span>
</label>
            <div>
                <textarea name="item_name" rows="3"
    class="w-full resize-y rounded-xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100">{{ old('item_name') }}</textarea>

@error('item_name')
    <p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p>
@enderror
            </div>
        </div>

        <div class="grid items-start gap-3 md:grid-cols-[180px_1fr]">
            <label class="pt-3 font-bold text-slate-700 md:text-right">
                入庫本数
                <span class="ml-1 rounded-full bg-red-100 px-2 py-1 text-xs text-red-600">必須</span>
            </label>
            <div>
                <select name="receiving_count"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100">
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ old('receiving_count') == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
                @error('receiving_count')
                    <p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid items-start gap-3 md:grid-cols-[180px_1fr]">
            <label class="pt-3 font-bold text-slate-700 md:text-right">
                賞味期限日
                <span class="ml-1 rounded-full bg-slate-100 px-2 py-1 text-xs text-slate-500">任意</span>
            </label>
            <div>
                <input type="date" name="expiration_date" value="{{ old('expiration_date') }}"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100">
                @error('expiration_date')
                    <p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p>
                @enderror

                <p class="mt-2 text-xs font-bold text-slate-500">
                未入力の場合は、お酒の種類名に設定された日数から自動計算します。
                </p>
            </div>
        </div>

        <div class="pt-4 text-center">
            <button type="submit"
                class="inline-flex h-12 items-center justify-center rounded-full bg-gradient-to-r from-emerald-400 to-teal-500 px-12 font-bold text-white shadow-md transition hover:-translate-y-0.5 hover:shadow-lg">
                登録
            </button>
        </div>

    </div>
</form>

@endsection
