<?php 
    //dd($mensajes);
?>
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

<style>
    .message-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .message-link {
        text-decoration: none; /* Elimina el subrayado */
        color: inherit; /* Mantiene el color del texto original */
    }

    .message-card {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
    }

    .message-header {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .message-body {
        font-size: 1.1em;
        margin-bottom: 10px;
    }

    .message-footer {
        font-size: 0.9em;
        color: #666;
    }

    .message-footer small {
        color: #888;
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
                <a href="" class="d-flex align-items-center"><i class="fas fa-message me-2"></i> Mensajes</a>
            </div>
            <!-- Elemento Contacto en la parte inferior -->
            <a href="#" class="d-flex align-items-center mt-auto"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>

        </div>
        
        
        
        <!-- Botón para abrir el menú en pantallas pequeñas -->
        <button class="open-btn" onclick="toggleSidebar()">☰ Menú</button>
    </div>

<div class="containeree">
    <div class="main-content">
        <h3>Lista de mensajes recibidos.</h3><br>
        @if(count($mensajes) > 0)
        <div class="message-list">
            @foreach($mensajes as $mensaje)
                <a href="{{url('chat/'. $mensaje['id_subcategoria'])}}" class="message-link">
                    <div class="message-card">
                        <div class="message-header">
                            <strong>Enviado por:</strong> {{ $mensaje['correo_usuario'] }}
                        </div>
                        <div class="message-body">
                            <p><strong>Mensaje:</strong> {{ $mensaje['mensaje'] }}</p>
                            <p><strong>Local:</strong> {{ $mensaje['nombre_negocio'] }}</p>
                        </div>
                        <div class="message-footer">
                            <small><strong>Enviado:</strong> {{ \Carbon\Carbon::parse($mensaje['timestamp'])->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                </a> 
            @endforeach
        </div>
    @else
        <p>No hay mensajes para mostrar.</p>
    @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>