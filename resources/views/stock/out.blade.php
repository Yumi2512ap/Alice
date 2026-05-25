@extends('layouts.app')

@section('title', '出庫一覧')

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
            出庫一覧
        </h2>
    </div>
</div>

<form method="GET" action="{{ route('stock.out') }}"
    class="mb-8 rounded-[28px] bg-white/85 p-6 shadow-lg ring-1 ring-amber-100">

    <div class="mb-4 flex items-center justify-between border-b border-amber-100 pb-3">
        <h2 class="text-lg font-bold text-amber-700">検索条件</h2>

        <a href="{{ route('stock.index') }}"
            class="inline-flex h-11 items-center justify-center rounded-full bg-gradient-to-r from-cyan-400 to-teal-500 px-7 font-bold text-white shadow-md transition hover:-translate-y-0.5 hover:shadow-lg">
            在庫一覧へ
        </a>
    </div>

    <div class="grid gap-5 md:grid-cols-3">
        <div>
            <label class="mb-2 block font-bold text-slate-700">ラベル名（商品名）</label>
            <input type="text" name="keyword" value="{{ request('keyword') }}"
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-amber-400 focus:outline-none focus:ring-4 focus:ring-amber-100">
        </div>

        <div>
            <label class="mb-2 block font-bold text-slate-700">お酒の種類</label>
            <select name="category_id" onchange="this.form.submit()"
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-amber-400 focus:outline-none focus:ring-4 focus:ring-amber-100">
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
            <label class="mb-2 block font-bold text-slate-700">並び替え</label>
            <select name="sort" onchange="this.form.submit()"
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-amber-400 focus:outline-none focus:ring-4 focus:ring-amber-100">
                <option value="new" {{ request('sort', 'new') == 'new' ? 'selected' : '' }}>新着順</option>
                <option value="qty" {{ request('sort') == 'qty' ? 'selected' : '' }}>出庫本数が多い順</option>
            </select>
        </div>
    </div>

    <div class="mt-5 flex justify-end gap-3">
        <button type="submit"
            class="inline-flex h-11 items-center justify-center rounded-full bg-gradient-to-r from-yellow-50 via-amber-50 to-orange-100 px-8 font-bold text-amber-700 shadow-md ring-1 ring-amber-100 transition hover:-translate-y-0.5 hover:shadow-lg">
            検索
        </button>

        <a href="{{ route('stock.out') }}"
            class="inline-flex h-11 items-center justify-center rounded-full bg-gradient-to-r from-slate-200 to-slate-300 px-8 font-bold text-slate-700 shadow-md transition hover:-translate-y-0.5 hover:shadow-lg">
            クリア
        </a>
    </div>
</form>

<div class="mb-4 inline-flex rounded-full bg-amber-50 px-5 py-2 font-bold text-amber-700 ring-1 ring-amber-100">
    全 {{ $total }} 件中 {{ $displayCount }} 件
</div>


    <table class="w-full table-fixed border-collapse text-sm">
        <thead>
            <tr class="bg-gradient-to-r from-yellow-50 via-amber-50 to-orange-100 text-slate-700">
                <th class="w-[110px] border border-slate-200 px-4 py-3 text-left">入庫日</th>
                <th class="w-[130px] border border-slate-200 px-4 py-3 text-left">お酒の種類名</th>
                <th class="w-[260px] border border-slate-200 px-4 py-3 text-left">ラベル名（商品名）</th>
                <th class="w-[110px] border border-slate-200 px-4 py-3 text-left">出庫日</th>
                <th class="w-[100px] border border-slate-200 px-4 py-3 text-left">出庫本数</th>
                <th class="w-[160px] border border-slate-200 px-4 py-3 text-left">評価</th>
                <th class="w-[150px] border border-slate-200 px-4 py-3 text-left">リピート</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($stocks as $stock)
                @foreach ($stock->issuings as $issuing)
                    <tr class="even:bg-slate-50 hover:bg-amber-50">
                        <td class="whitespace-nowrap border border-slate-200 px-4 py-3">
                            {{ $stock->arrival_date->format('Y/m/d') }}
                        </td>
                        <td class="whitespace-nowrap border border-slate-200 px-4 py-3">
                            {{ $stock->item->category->category_name }}
                        </td>
                        <td class="break-words border border-slate-200 px-4 py-3">
                            {{ $stock->item->item_name }}
                        </td>
                        <td class="whitespace-nowrap border border-slate-200 px-4 py-3">
                            {{ $issuing->issuing_date->format('Y/m/d') }}
                        </td>
                        <td class="whitespace-nowrap border border-slate-200 px-4 py-3">
                            {{ $issuing->issuing_count }}
                        </td>
                        <td class="whitespace-nowrap border border-slate-200 px-4 py-3">
                            {{ $issuing->evaluation }}
                        </td>
                        <td class="border border-slate-200 px-4 py-3">
                            @if ($issuing->repeat == config('constants.REPEAT_YES'))
                                <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 font-bold text-emerald-700 ring-1 ring-emerald-100">
                                    リピートしたい
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 font-bold text-slate-600 ring-1 ring-slate-200">
                                    リピートしない
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach

            <tr class="bg-amber-50 font-bold">
                <td colspan="4" class="border border-slate-200 px-4 py-3">
                    総 出庫本数
                </td>
                <td colspan="3" class="border border-slate-200 px-4 py-3">
                    {{ $totalCount }} 本
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
