<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$news->title}}</title>
</head>
<body class="antialiased">
    <h1>{{$news->title}}</h1>
    <p>{{ $news->text }}</p>
    <p>{{ $news->published_at }}</p>
</body>
</html>
