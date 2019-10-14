<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>@yield('title',config('app.name'))</title>
    <meta name="author" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">


</head>

<body>
@include('layout.partials.navbar')
<h1>@yield('content')</h1>

<hr>
@include('layout.partials.footer',['yil'=>2019])


</body>

</html>
