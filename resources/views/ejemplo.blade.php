<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventana Popup</title>
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

<h2>Ventana Popup Ejemplo</h2>

<!-- Botón para abrir la ventana modal -->
<button id="openModalBtn">Abrir Popup</button>

<!-- La ventana modal -->
<div id="myModal" class="modal">

    <!-- Contenido del modal -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Este es un mensaje de popup!</h3>
        <p>Puedes poner cualquier contenido aquí.</p>
    </div>

</div>

<script>
    // Obtiene los elementos del DOM
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("openModalBtn");
    var span = document.getElementsByClassName("close")[0];

    // Muestra el modal cuando se hace clic en el botón
    btn.onclick = function() {
        modal.style.display = "block";
    }

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
</script>

</body>
</html>
