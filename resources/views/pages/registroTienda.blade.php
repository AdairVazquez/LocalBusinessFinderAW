<?php
$reference = session('user');
// dd(session('user'));

$id = null; // Inicializa la variable
    if ($reference && is_array($reference) && count($reference) > 0) {
        // Accede al primer elemento del arreglo usando la clave
        $id = array_key_first($reference);
    } 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('css/formulario.css')}}">
    <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        #map {
            height: 400px;
            width: 100%;
        }

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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQ8agMsnkZNkUOwVIXjz37rVDGMSEJR1s&callback=initMap&libraries=places" async defer></script>
    <script>
        let map, marker;

        function initMap() {
            // Coordenadas de Lomas de Tecámac
            const tecamac = { lat: 19.655253237159656, lng: -98.99658121053943 };

            // Inicialización del mapa estándar centrado en Lomas de Tecámac
            map = new google.maps.Map(document.getElementById('map'), {
                center: tecamac,
                zoom: 14, // Ajusta el nivel de zoom si lo deseas
                mapTypeId: 'roadmap' // Este es el tipo de mapa estándar, no Street View
            });

            // Marcador inicial en Lomas de Tecámac
            marker = new google.maps.Marker({
                position: tecamac,
                map: map,
                draggable: true, // Permite arrastrar el marcador
            });

            // Evento para actualizar los valores de latitud y longitud cuando se mueva el marcador
            google.maps.event.addListener(marker, 'dragend', function() {
                const position = marker.getPosition();
                document.getElementById('lat').value = position.lat();
                document.getElementById('lng').value = position.lng();
            });
        }

        // Ejecutar initMap después de que el DOM esté completamente cargado
        window.onload = initMap;
    </script>

    <title>¡Bienvenido!</title>
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
                <a href="#clients" class="d-flex align-items-center"><i class="fas fa-user me-2"></i> Clientes</a>
            </div>
            <!-- Elemento Contacto en la parte inferior -->
            <a href="#" class="d-flex align-items-center mt-auto"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>

        </div>
        
        
        
        <!-- Botón para abrir el menú en pantallas pequeñas -->
        <button class="open-btn" onclick="toggleSidebar()">☰ Menú</button>
    </div>

    <div class="containeree">
        <div class="main-content">
        <div class="form-section">
            <h2>Registrar una tienda</h2>
            <h5 style="color: red">* Campos obligatorios </h5>
            <form action="{{route('categorias.subcat')}}" class="form-data" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_usuario" value="{{$id}}">
                <label for=""><b>Nombre del negocio</b><p style="color: red">*</p></label>
                <input type="text" name="nombre_negocio" placeholder="Nombre del negocio" required>
                <label for=""><b>Dirección</b><p style="color: red">*</p></label>
                <input type="text" name="direccion" placeholder="Direccion" required>
                <label for=""><b>Arrastra el marcador a la ubicación de tu negocio.</b><p style="color: red">*</p></label>
                <div id="map"></div>
                <input type="hidden" id="lat" name="lat" required>
                <input type="hidden" id="lng" name="lng" required>
                <label for="">Contacto</label>
                <label for=""><b>Número telefonico</b><p style="color: red">*</p></label>
                <input type="tel" name="telefono" placeholder="Numero telefonico" required>
                <label for=""><b>Correo del negocio</b><p style="color: red">*</p></label>
                <input type="email" name="correo" placeholder="Correo del negocio" required>
                <label for=""><b>URL de tus Redes sociales</b></label>
                <div class="cont">
                    <input type="text" name="instagram" placeholder="Instagram" >
                    <input type="text" name="whatsapp" placeholder="WhatsApp" >
                    <input type="text" name="facebook" placeholder="Facebook" >
                </div>
                <div class="cont">
                    <input type="text" name="telegram" placeholder="Telegram" >
                    <input type="text" name="youtube" placeholder="Youtube" >
                    <input type="text" name="tiktok" placeholder="Tiktok" >
                </div>
                <textarea name="descripcion" placeholder="Informacion adicional" ></textarea>
    
                <label for="imgLocal"><b>Agrega una imagen de la fachada de tu negocio</b><p style="color: red">*</p></label>
                <input type="file" id="imgLocal" name="imagen" required>
    
                <div class="comb">
                    <label for="categoria"><b>Seleccione una categoría:</b></label>
                    <select id="categoria" name="id_categoria" onchange="mostrarInputOtro()" required>
                        <option value="" disabled selected>Seleccione...</option>
                        @foreach ($categorias as $key => $data)
                            <option value="{{ $key }}">{{ $data['tipo_negocio'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="horario">Horario (Días de apertura)</label>
                    <input type="text" name="horario" class="form-control" placeholder="Ej. Lunes a Viernes" required>
                </div>
        
                <!-- Campos de Hora Apertura y Hora Cierre -->
                <div class="form-group">
                    <label for="hora_apertura">Hora de Apertura</label>
                    <input type="time" name="hora_apertura" class="form-control" required>
                </div>
        
                <div class="form-group">
                    <label for="hora_cierre">Hora de Cierre</label>
                    <input type="time" name="hora_cierre" class="form-control" required>
                </div>

                <div class="comb">
                    <label for="estacionamiento">¿Cuenta con estacionamiento?</label>
                    <select id="estacionamiento" name="estacionamiento" onchange="mostrarInputOtro()">
                        <option selected disabled value="">Seleccione...</option>
                        <option value="Si">Si</option>
                        <option value="No">No</option>
                    </select>
    
                    <!-- Input que aparecerá si se selecciona "Otro" -->
                    

                    <div class="contt">
                        <p id="label1">Costo</p>
                        <input type="text" id="otroInput" name="costo" placeholder="$" >
                        <p id="label2" >Por </p>
                        <input type="text" id="otroInput2" name="tiempo" placeholder="horas" >
                    </div><br>

                <button type="">Registrar negocio</button>
            </form>
        </div>
        </div>
    </div>



    <!-- La ventana modal -->
    <div id="myModal" class="modal">

        <!-- Contenido del modal -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>¡Atención!</h3>
            <p>Recuerda registrar todos los datos obligatorios.</p>
        </div>
    
    </div>
    
    
    
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('js/graficas.js')}}"></script>
    <script>
        // Obtiene los elementos del DOM
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("openModalBtn");
        var span = document.getElementsByClassName("close")[0];
        var prueba = 0
    
        if(prueba === 0){
            modal.style.display = "block";
        }
    
        // Muestra el modal cuando se hace clic en el botón
       
    
        // Cierra el modal cuando se hace clic en la "X"
        span.onclick = function() {
            modal.style.display = "none";
        }
    
        // Cierra el modal cuando se hace clic fuera del contenido del modal
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function mostrarInputOtro() {
        var select = document.getElementById("estacionamiento");
        var otroInput = document.getElementById("otroInput");
        var otroInput2 = document.getElementById("otroInput2");
        var label1 = document.getElementById("label1");
        var label2 = document.getElementById("label2");

        // Muestra u oculta el input dependiendo de la selección
        if (select.value === "Si") {
            otroInput.style.display = "block";
            otroInput2.style.display = "block";
            label1.style.display = "inline-block";
            label2.style.display = "inline-block";
        } else {
            otroInput.style.display = "none";
            otroInput2.style.display = "none";
            label1.style.display = "none";
            label2.style.display = "none";
        
            otroInput.value = ""; // Limpia el campo si se cambia la selección
            otroInput2.value = ""; // Limpia el campo si se cambia la selección
        }
        }
    </script>
    
</body>
</html>










































































































































