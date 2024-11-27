
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Mis tiendas</title>
    <style>
        /* Estilos para la ventana modal */
        .modal {
            display: none; /* Oculta el modal por defecto */
            position: fixed; /* Fija la posición en pantalla */
            z-index: 1; /* Superpone el modal sobre el contenido */
            left: 0;
            top: 0;
            width: 100%; /* Ancho total de la pantalla */
            height: 100%; /* Altura total de la pantalla */
            background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
        }

        .modal-content {
            background-color: white;
            margin: 15% auto; /* Centra el contenido vertical y horizontalmente */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Ancho del contenido modal */
            max-width: 400px; /* Ancho máximo del modal */
            text-align: center;
        }

        .close {
            color: red;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .agregar-tienda-btn {
            position: absolute; /* Permite posicionar el botón de forma absoluta */
            right: 100px; /* Margen desde el lado derecho */
            top: 40px; /* Margen desde la parte superior */
            padding: 10px 20px; /* Tamaño del botón */
            background-color: #0add14; /* Color de fondo */
            color: white; /* Color del texto */
            border: none; /* Sin bordes */
            border-radius: 8px; /* Bordes redondeados */
            cursor: pointer; /* Cursor de mano al pasar por encima */
            text-decoration: none;
        }

        .agregar-tienda-btn:hover {
            background-color: #057a0b; /* Color de fondo al pasar el cursor */
        }

    </style>
</head>
<body>
    <div class="degradado">
        <div class="sidebar" id="mySidebar">
            <div class="d-flex flex-column align-items-center mb-4">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo">
                <span class="text-center">Local Business Finder</span>
            </div>
            <div>
                <a href="{{route('homepage')}}" class="d-flex align-items-center"><i class="fas fa-home me-2"></i> Inicio</a>
                <a href="{{route('subCategorias.store')}}" class="d-flex align-items-center active"><i class="fas fa-shop me-2"></i> Tiendas</a>
            </div>
            
            <!-- Formulario oculto -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <a href="#" class="d-flex align-items-center mt-auto" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i>
                Cerrar Sesión
            </a>

        </div>
    
        
        <!-- Botón para abrir el menú en pantallas pequeñas -->
        <button class="open-btn" onclick="toggleSidebar()">☰ Menú</button>
    </div>
<div class="containeree">
    <div class="main-content">
            <h1>Mis tiendas.</h1>
            <a href="{{route('categorias.list')}}" class="agregar-tienda-btn">Agregar Nueva Tienda</a>

        
        
        <div class="row">
            @foreach ($subcategorias as $key=>$datos)
                <div class="col-md-4 mb-3">
                    <div class="card" style="width: 18rem; background-color: #bfbfbf;">
                        <img src="{{$datos['imagen']}}" class="card-img-top" width="150px" height="200px" onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/d/da/Imagen_no_disponible.svg/300px-Imagen_no_disponible.svg.png';">
                        <div class="card-body">
                        <h5 class="card-title">{{$datos['nombre_negocio']}}</h5>
                        <p class="card-text">Descripcion: {{$datos['descripcion']}}</p>
                        <a href="{{url('editarSubCategoria/'.$key)}}" class="btn btn-primary">Ver Datos</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('js/graficas.js')}}"></script>


</body>
</html>
