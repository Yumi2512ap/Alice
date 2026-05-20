<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
<title>@yield('title')</title>
</head>

<body>

<header>
<h1>@yield('title')</h1>
<hr>
</header>

<main>
@yield('content')
</main>

{{-- メッセージ表示 --}}
@if (session('message'))
<script>
alert("{{ session('message') }}");
</script>
@endif

{{-- バリデーションエラー --}}
@if ($errors->any())
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
@endif

</body>

</html>
