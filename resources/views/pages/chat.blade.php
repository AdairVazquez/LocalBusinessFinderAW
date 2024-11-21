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
        /* Estilos para el chat */
        .message-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-height: 500px;
            overflow-y: auto;
            padding: 20px;
        }

        .message {
            display: flex;
            flex-direction: column;
            max-width: 70%; /* Limita el tamaño de los mensajes */
            margin-bottom: 10px;
        }

        .message.received {
            align-self: flex-start; /* Los mensajes recibidos se alinean a la izquierda */
            background-color: #e0e0e0; /* Color de fondo para los mensajes recibidos */
            padding: 10px;
            border-radius: 8px;
        }

        .message.sent,
        .response {
            align-self: flex-end; /* Los mensajes enviados y respuestas se alinean a la derecha */
            background-color: #0084ff; /* Color de fondo para los mensajes enviados */
            color: white;
            padding: 10px;
            border-radius: 8px;
        }

        .response {
            background-color: #af39b9; /* Color de fondo para las respuestas */
            margin-left: auto; /* Asegura que las respuestas no excedan el ancho */
            color: white; /* Color de texto para las respuestas */
        }

        .message-header {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .message-body {
            font-size: 1.1em;
            margin-bottom: 5px;
        }

        .message-footer {
            font-size: 0.9em;
            color: wheat;
            text-align: right;
        }

        /* Ajustes visuales */
        .containeree {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            background: #f4f4f9;
            padding: 20px;
        }

        .main-content {
            width: 100%;
            max-width: 800px; /* Limitar el ancho máximo para un mejor diseño */
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex-grow: 1; /* Permite que este elemento crezca para ocupar espacio extra */
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Distribuir el espacio libre entre los elementos */
        }

        /* Estilo adicional para el formulario */
        .input-message form {
            display: flex;
            align-items: center;
            width: 100%; /* Hacer que el formulario ocupe el 100% del ancho disponible */
        }

        .input-message textarea {
            flex-grow: 1; /* Permitir que el textarea crezca para llenar el espacio disponible */
            margin-right: 10px; /* Añadir margen a la derecha del textarea */
            height: 50px; /* Fijar altura */
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            resize: none; /* Evitar el redimensionamiento */
        }

        .input-message button {
            flex-shrink: 0; /* Evitar que el botón se encoja */
            padding: 10px 20px; /* Ajustar el padding para un mejor diseño */
            background-color: #0084ff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .input-message button:hover {
            background-color: #006bb3;
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
            <h3>Conversación</h3>
            <div class="message-list">
                @foreach($mensajes as $item)
                    @if($item['tipo'] === 'mensaje')
                        <div class="message @if($item['usuario_id'] == auth()->id()) sent @else received @endif">
                            <div class="message-header">
                                {{ $item['correo_usuario'] }} <small>{{ \Carbon\Carbon::parse($item['fecha'])->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="message-body">
                                {{ $item['mensaje'] }}
                            </div>
                        </div>
                    @else
                        <div class="message response">
                            <div class="message-body">
                                {{ $item['mensaje'] }}
                            </div>
                            <div class="message-footer">
                                {{ \Carbon\Carbon::parse($item['fecha'])->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="input-message">
                <form action="{{route('chat.respuesta',['subcategoriaId' => $categoriaId])}}" method="post">
                    @csrf
                    <textarea name="respuesta" placeholder="Escribe tu mensaje..."></textarea>
                    <button type="submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>
    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
