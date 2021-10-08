<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Inventory</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
<style>
body {
    background-color: #eadbc8;
    background-repeat: no-repeat;
    background-size: cover;
 }

 .vl {
  border-right: 1px solid white;
  height: 300px;
  margin-right: 350px;
}   

</style>
</head>
<body>
    <div id="app">    
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
