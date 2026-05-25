@extends('layouts.app')

@section('title', '在庫一覧')

@section('content')

<div class="mb-6">
    <a href="{{ route('home') }}"
        class="inline-flex h-12 items-center justify-center rounded-full bg-gradient-to-r from-cyan-400 to-teal-500 px-8 font-bold text-white shadow-md transition hover:-translate-y-0.5 hover:shadow-lg">
        ← Menuへ
    </a>
</div>

<div class="mb-8 text-center">
    <div class="inline-flex rounded-full bg-white/80 px-10 py-3 shadow-md ring-1 ring-cyan-100">
        <h2 class="text-3xl font-black tracking-[0.18em] text-teal-700">
            在庫一覧
        </h2>
    </div>
</div>

<form method="GET" action="{{ route('stock.index') }}"
    class="mb-8 rounded-[28px] bg-white/85 p-6 shadow-lg ring-1 ring-teal-100">

    <div class="mb-4 flex items-center justify-between border-b border-teal-100 pb-3">
        <h2 class="text-lg font-bold text-teal-700">
            検索条件
        </h2>

        <a href="{{ route('stock.out') }}"
            class="inline-flex h-11 items-center justify-center rounded-full bg-gradient-to-r from-emerald-400 to-teal-500 px-7 font-bold text-white shadow-md transition hover:-translate-y-0.5 hover:shadow-lg">
            出庫一覧へ
        </a>
    </div>

    <div class="grid gap-5 md:grid-cols-3">
        <div>
            <label class="mb-2 block font-bold text-slate-700">
                ラベル名（商品名）
            </label>
            <input type="text" name="keyword" value="{{ request('keyword') }}"
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-teal-400 focus:outline-none focus:ring-4 focus:ring-teal-100">
        </div>

        <div>
            <label class="mb-2 block font-bold text-slate-700">
                お酒の種類
            </label>
            <select name="category_id" onchange="this.form.submit()"
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-teal-400 focus:outline-none focus:ring-4 focus:ring-teal-100">
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
            <label class="mb-2 block font-bold text-slate-700">
                並び替え
            </label>
            <select name="sort" onchange="this.form.submit()"
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-teal-400 focus:outline-none focus:ring-4 focus:ring-teal-100">

                <option value="new" {{ request('sort') == 'new' ? 'selected' : '' }}>新着順</option>
                <option value="qty" {{ request('sort') == 'qty' ? 'selected' : '' }}>本数が多い順</option>
            </select>
        </div>
    </div>

    <div class="mt-5 flex flex-wrap items-center justify-between gap-4">
        <label class="inline-flex h-11 items-center gap-2 rounded-full bg-amber-50 px-5 font-bold text-slate-700 ring-1 ring-amber-100">
            <input type="checkbox" name="expired" value="1"
                onchange="this.form.submit()"
                {{ request('expired') == '1' ? 'checked' : '' }}
                class="h-4 w-4 accent-teal-500">
            賞味期限切れ
        </label>

        <div class="flex gap-3">
            <button type="submit"
                class="inline-flex h-11 items-center justify-center rounded-full bg-gradient-to-r from-cyan-400 to-teal-500 px-8 font-bold text-white shadow-md transition hover:-translate-y-0.5 hover:shadow-lg">
                検索
            </button>

            <a href="{{ route('stock.index') }}"
                class="inline-flex h-11 items-center justify-center rounded-full bg-gradient-to-r from-slate-200 to-slate-400 px-8 font-bold text-slate-700 shadow-md transition hover:-translate-y-0.5 hover:shadow-lg">
                クリア
            </a>
        </div>
    </div>

</form>

<div class="mb-4 inline-flex rounded-full bg-teal-50 px-5 py-2 font-bold text-teal-700 ring-1 ring-teal-100">
    全 {{ $total }} 件中 {{ $displayCount }} 件
</div>

<div class="overflow-x-auto rounded-2xl bg-white shadow-lg ring-1 ring-slate-200">
    <table class="w-full table-fixed border-collapse text-sm">
        <tr class="bg-gradient-to-r from-amber-100 to-orange-50 text-slate-700">
            <th class="border border-slate-200 px-4 py-3 text-left">入庫日</th>
            <th class="border border-slate-200 px-4 py-3 text-left">お酒の種類名</th>
            <th class="w-[220px] whitespace-nowrap border border-slate-200 px-4 py-3 text-left">ラベル名（商品名）</th>
            <th class="border border-slate-200 px-4 py-3 text-left">入庫本数</th>
            <th class="border border-slate-200 px-4 py-3 text-left">賞味期限日</th>
            <th class="border border-slate-200 px-4 py-3 text-center">編集</th>
            <th class="border border-slate-200 px-4 py-3 text-center">削除</th>
            <th class="border border-slate-200 px-4 py-3 text-center">出庫</th>
        </tr>

        @foreach ($stocks as $stock)
            <tr class="even:bg-slate-50 hover:bg-teal-50">
                <td class="border border-slate-200 px-4 py-3">{{ $stock->arrival_date->format('Y/m/d') }}</td>
                <td class="border border-slate-200 px-4 py-3">{{ $stock->item->category->category_name }}</td>
                <td class="max-w-[260px] break-words border border-slate-200 px-4 py-3">{{ $stock->item->item_name }}</td>
                <td class="border border-slate-200 px-4 py-3">{{ $stock->receiving_count }}</td>
                <td class="border border-slate-200 px-4 py-3">{{ $stock->expiration_date->format('Y/m/d') }}</td>

                <td class="border border-slate-200 px-4 py-3 text-center">
                    <a href="{{ route('stock.edit', $stock->stock_id) }}"
                        class="inline-flex h-10 items-center justify-center rounded-full bg-gradient-to-r from-cyan-400 to-teal-500 px-5 font-bold text-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        編集
                    </a>
                </td>

                <td class="border border-slate-200 px-4 py-3 text-center">
                    <form action="{{ route('stock.destroy', $stock->stock_id) }}" method="POST"
                        onsubmit="return confirm('本当に削除しますか？');"
                        class="m-0 inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex h-10 items-center justify-center rounded-full bg-gradient-to-r from-orange-400 to-pink-500 px-5 font-bold text-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                            削除
                        </button>
                    </form>
                </td>

                <td class="border border-slate-200 px-4 py-3 text-center">
                    <a href="{{ route('stock.out.create', $stock->stock_id) }}"
                        class="inline-flex h-10 items-center justify-center rounded-full bg-gradient-to-r from-emerald-400 to-teal-500 px-5 font-bold text-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                        出庫
                    </a>
                </td>
            </tr>
        @endforeach

        <tr class="bg-teal-50 font-bold">
            <td colspan="3" class="border border-slate-200 px-4 py-3">総 本数</td>
            <td colspan="5" class="border border-slate-200 px-4 py-3">{{ $totalCount }} 本</td>
        </tr>
    </table>
</div>



@endsection
