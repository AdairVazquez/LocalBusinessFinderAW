<?php
$reference = session('user');
$id = null; // Inicializa la variable
    if ($reference && is_array($reference) && count($reference) > 0) {
        $id = array_key_first($reference);
    }
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{asset('css/formulario.css')}}">
        <title>LocalBusinessFinder</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/x-icon">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        
        <!-- Styles -->
        <style>
            .navColorFont{color:white}
            .img-logo{
               background-color: white;
               border-radius: 20%;
           }
           body{
            background: linear-gradient(to bottom, #6c0775, #fa7bfe);
           }
       </style>
    </head>
    <body>
        @include('pages.inc.navbar')
        <div class="py-3">
            @yield('content')
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>