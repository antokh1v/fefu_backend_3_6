<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Profile</title>
</head>
<body class="antialiased">
<h1>Profile</h1>
<div>
    <h4>App:</h4>
    <label>
        <b> Last login date: </b>{{ $user['app_logged_in_at'] ?? 'Never' }}<br>
        <b> Registration date: </b>{{ $user['app_registered_at'] ?? 'Never' }}<br>
    </label>
    <h3>Oauth info:</h3>
    <h4>GitHub:</h4>
    <label>
        <b> Last login date:</b> {{ $user['github_logged_in_at'] ?? 'Never' }}<br>
        <b> Registration date:</b> {{ $user['github_registered_at'] ?? 'Never' }}<br>
    </label>
    <h4>VK:</h4>
    <label>
        <b> Last login date:</b> {{ $user['vkontakte_logged_in_at'] ?? 'Never' }}<br>
        <b> Registration date:</b> {{ $user['vkontakte_registered_at'] ?? 'Never' }}<br>
    </label>
</div>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">
        Logout
    </button>
</form>
</body>
</html>
