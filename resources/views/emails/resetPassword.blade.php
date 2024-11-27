<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{asset('img/logo.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('css/formulario.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Restablecimiento de contraseña</title>
    <style>
        body {
            background-color: rebeccapurple;
            
        }
    </style>
</head>
<body>
    <div class="container" style="background-color: white; border-radius: 5px; margin-top:5rem;">
            <div class="main-content">
            <div class="form-section">
                <h2>Restablece tu contraseña</h2>
                <h5 style="color: red">* Si no solicitaste el cambio de tu contraseña, has caso omiso a este correo electrónico.</h5>
                <form action="https://localbusinessfinder.site/restablecerPass" class="form-data" method="post">
                    @csrf 
                    <label for=""><b>Ingresa tu nueva contraseña</b><p style="color: red">*</p></label>
                    <input type="password" name="contraseña" placeholder="Nueva contraseña" required>
                    <label for=""><b>Respite tu contraseña.</b><p style="color: red">*</p></label>
                    <input type="password" name="repContraseña" placeholder="Repite la contraseña" required>
                    <button type="submit">Restablecer contraseña</button>
                    <br><br>
                </form>
            </div>
            </div>
        </div>
    </div>
   
</body>
</html>
