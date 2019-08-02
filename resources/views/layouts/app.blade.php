<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cruds</title>
    <link rel="stylesheet" type="text/css" href="{{getenv('APP_URL')}}/css/app.css">
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>
<body>
@yield('content')
<script src="/js/app.js"></script>
</body>
</html>