<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="https://js.stripe.com/v3/"></script>
    <title>Vue Booking</title>
</head>
<body class="h-full bg-slate-200">
    <div id="app" class="h-full"></div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
