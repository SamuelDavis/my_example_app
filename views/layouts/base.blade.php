<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/main.css">
    @yield('head')
</head>
<body>
@include('includes/nav')
@yield('body')
@yield('foot')
</body>
</html>
