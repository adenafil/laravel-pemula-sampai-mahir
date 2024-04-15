<html>
<head>
    <title>Nama Aplikasi - @yield('title')</title>
</head>

<body>

{{--@yield('header')--}}

{{--@yield('content')--}}

@section('header')
    <h1>Default Header</h1>
@show

@section('content')
    <h1>Default Content</h1>
@show


</body>
</html>
