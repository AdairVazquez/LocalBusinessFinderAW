
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>¡Bienvenido!</title>
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
                <a href="{{route('categoria.mensajes')}}" class="d-flex align-items-center"><i class="fas fa-message me-2"></i> Mensajes</a>
            </div>
            
            <!-- Formulario oculto -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i>
                Cerrar Sesión
            </a>

        </div>
        
        
        
        <!-- Botón para abrir el menú en pantallas pequeñas -->
        <button class="open-btn" onclick="toggleSidebar()">☰ Menú</button>
    </div>

<div class="container">
    
    <div class="main-content">
        <div class="chart">
            <h4>Estadisticas de vistas</h4>
            <div class="chart-container">
                <canvas id="myChart"></canvas>
            </div>
        </div>

        <div class="dashboard">
            <div class="card">
              <div class="icon"><img src="https://cdn-icons-png.flaticon.com/512/3126/3126647.png" alt="Customers Icon"></div>
              <h3>Visitas del mes actual</h3>
              <p class="value">{{$visitasDelMesActual}}</p>
            </div>
            
            <div class="card">
              <div class="icon"><img src="https://cdn-icons-png.flaticon.com/256/17069/17069425.png" alt="Revenue Icon"></div>
              <h3>Tiendas</h3>
              <p class="value">{{$numRegistros}}</p>
            </div>
            
            <div class="card">
                <div class="icon"><img src="https://cdn-icons-png.flaticon.com/512/2052/2052723.png" alt="Traffic Share Icon"></div>
                <h3>Calificación total</h3>
                <p class="value">{{$comentarios['calificacionTotal']}}</p>
                
            </div>
            
        </div>
        
        <div class="latest-comments">
            <h4>Ultimos comentarios</h4>
            <div class="comment-section">
                @foreach ($comentarios as $comentario => $item)
                    @if (is_array($item))
                        <div class="comment-card">
                            <div class="store-name">{{$item['nombre_negocio']}}</div>
                            <div class="comment-text">{{$item['comentario']}}</div>
                        </div> 
                    @endif
                @endforeach
            </div>            
        </div>
    </div>

    <div class="side-content">
        <div class="profile-card">
            @foreach(session('user') as $key => $data)
                @if (!isset($data['avatar']))
                    <img src="https://cdn-icons-png.flaticon.com/512/456/456212.png" alt="Profile Picture">
                @else
                    <img src="{{$data['avatar']}}" alt="Profile Picture">
                @endif
                
                @if (!isset($data['nombre']))
                    <h3>Sin nombre registrado</h3>
                @else
                    <h3>{{ $data['nombre'] }}</h3>
                @endif
            @endforeach
        </div>

        <div class="recent-messages">
            <h4><center>Mensajes Recientes</center></h4>
            
                @foreach ($recentMessages as $mensaje)
                <div class="message">
                    <p><strong>Usuario:</strong> {{ $mensaje['correo'] }}</p>
                    <p><strong>Mensaje:</strong> {{ $mensaje['mensaje'] }}</p>
                    <p><small><strong>Fecha:</strong> {{ $mensaje['fecha'] }}</small></p>
                </div>
                @endforeach
            
            
        </div>
<br>
        <button onclick="location.href='{{route('categoria.mensajes')}}'" class="start-conversation">Ir a mensajes</button>
<br><br>
        <div class="visitor-profile">
            <h4>Estrellas</h4>
            <div class="chart-container">
                <canvas id="myPieChart"></canvas>
            </div>
        </div>
    </div>

    <!-- La ventana modal -->
<div id="myModal" class="modal">

    <!-- Contenido del modal -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Aún no tienes ninguna tienda registrada, ¿Deseas agregarla?</h3>
        <div class="row">
            <div class="col-sm-12">
                <button onclick="location.href='{{route('categorias.list')}}'" class="accept-button">Si</button>
            </div>
            <div class="col-sm-12">
                <button class="neg-button">No</button>
            </div>
        </div>
    </div>

</div>



</div>
<input type="hidden" id="count" value="{{$count}}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Pasar datos de PHP a JavaScript
    const visitasPorMes = @json($visitasMensuales);
    const estrellas = @json($estrellas);
</script>
<script src="{{asset('js/graficas.js')}}"></script>
<script>
    // Obtiene los elementos del DOM
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("openModalBtn");
    var span = document.getElementsByClassName("close")[0];
    var spann = document.getElementsByClassName("neg-button")[0];
    const count = document.getElementById("count");
    // Obtiene el valor del elemento y lo convierte a un número
    const countValue = parseInt(count.value, 10);

    console.log(countValue);

    if(countValue === 0){
        modal.style.display = "block";
    }

    // Muestra el modal cuando se hace clic en el botón
   

    // Cierra el modal cuando se hace clic en la "X"
    span.onclick = function() {
        modal.style.display = "none";
    }

    spann.onclick = function() {
        modal.style.display = "none";
    }

    // Cierra el modal cuando se hace clic fuera del contenido del modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>