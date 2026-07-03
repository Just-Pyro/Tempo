<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://kit.fontawesome.com/102455eaa4.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/jquery-4.0.0.min.js') }}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @yield('content')

    @stack('scripts')
</body>
</html>