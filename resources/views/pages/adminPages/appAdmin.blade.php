<?php
$reference = session('user');
$id = null; // Inicializa la variable
    if ($reference && is_array($reference) && count($reference) > 0) {
        // Accede al primer elemento del arreglo usando la clave
        $id = array_key_first($reference);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bienvenido</title>
    <style>
         .navColorFont{color:white}
            .img-logo{
               background-color: white;
               border-radius: 20%;
           }
           body{
            background: linear-gradient(to bottom, #6c0775, #fa7bfe);
           }
           .container {
              background-color: white;
              border-radius: 4%;
              min-height: 100vh; /* Cambiado de height a min-height */
              display: flex; /* Esto ayuda a centrar el contenido si es necesario */
              flex-direction: column; /* Mantiene el flujo del contenido verticalmente */
            }
    </style>
</head>
<body>
    <nav style="background-color:  #37033b;" class="navbar navbar-expand-lg">
        <div class="container-fluid">
          <a class="navbar-brand navColorFont" href="{{route('homeAdmin')}}"><img src="{{asset('img/logo.png')}}" width="30px" height="30px" alt="">LocalBusinessFinder</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link navColorFont" aria-current="page" href="{{route('homeAdmin')}}">Inicio</a>
              </li>
              <li class="nav-item">
                <a class="nav-link navColorFont" href="{{route('ListaUsuario')}}">Usuarios</a>
              </li>
              <li class="nav-item">
                <a class="nav-link navColorFont" href="{{route('categorias.store')}}">Categorias</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

    <div class="py-3">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>