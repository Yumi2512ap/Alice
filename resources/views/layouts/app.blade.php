<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-stone-50 via-teal-50 to-amber-50 text-slate-800">

    <header class="mx-auto mt-8 mb-6 max-w-6xl rounded-[32px] bg-gradient-to-r from-teal-100 via-emerald-50 to-amber-50 px-8 py-10 text-center shadow-lg">

    <h1 class="text-5xl font-black tracking-[0.18em] text-teal-700 drop-shadow-sm">
        日本酒・ワイン在庫管理
    </h1>

</header>

    <main class="mx-auto mb-10 max-w-6xl px-8 py-6">

 @if (session('message'))
    <div class="mx-auto mb-6 flex max-w-sm items-center justify-center gap-3 rounded-lg bg-teal-50 px-5 py-3 text-center text-2xl font-bold text-teal-700 shadow-sm ring-1 ring-teal-100">
        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-teal-600 text-base text-white">
            ✓
        </span>

        <span>
            {{ session('message') }}
        </span>
    </div>
@endif
    @yield('content')

</main>

       </body>

</html>
