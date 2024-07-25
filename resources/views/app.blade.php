<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MK Themed Attractions Phils</title>

    @vite('resources/js/app.js')
</head>

<body class="text-slate-800 antialiased bg-stone-100 ">
    <div id="overlay">

        <div id="toast"></div>
    </div>
    <div id="app">
    </div>
</body>

</html>