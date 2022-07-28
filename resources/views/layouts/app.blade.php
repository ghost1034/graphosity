<!DOCTYPE html>
<html lang="en">
<head>
    <title>Graphosity</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/graph.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<header class="container">
    <img src="images/logo.png" alt="logo" class="logo">
</header>
<nav>
    <ul>
        <li class="nav-item"><a id="quadratic">Quadratic</a></li>
        <li class="nav-item"><a id="linear">Linear</a></li>
        <li class="nav-item"><a id="exponential">Exponential</a></li>
        <li class="nav-item"><a id="square-root">Square Root</a></li>
        <li class="nav-item"><a id="absolute-value">Absolute Value</a></li>
    </ul>
</nav>
@yield('content')
</body>
</html>
