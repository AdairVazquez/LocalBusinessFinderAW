<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>BIENVENID@</title>
  <style>
    html,body { 
      height: 100%; 
    }

    .global-container{
      height:100%;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #f5f5f5;
    }

    form{
      padding-top: 10px;
      font-size: 14px;
      margin-top: 30px;
    }

    .card-title{ font-weight:300; }

    .btn{
      font-size: 14px;
      margin-top:20px;
    }


    .login-form{ 
      width:330px;
      margin:20px;
    }

    .sign-up{
      text-align:center;
      padding:20px 0 0;
    }

    .alert{
      margin-bottom:-30px;
      font-size: 13px;
      margin-top:20px;
    }
  </style>
</head>
<body>
  <div class="global-container">
    <div class="card login-form">
    <div class="card-body">
      <h3 class="card-title text-center">¡Registra un nuevo usuario!</h3>

      <div class="card-text">
        <!--
        <div class="alert alert-danger alert-dismissible fade show" role="alert">Incorrect username or password.</div> -->
        <form action="{{ url('aggUsuario') }}" method="POST">
          <!-- to error: add class "has-danger" -->
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control form-control-sm"  aria-describedby="emailHelp">
          </div>
          <div class="form-group">
            <label >Apellido Paterno</label>
            <input type="text" name="apellido" class="form-control form-control-sm"  aria-describedby="emailHelp">
          </div>
          <div class="form-group">
            <label>Correo electronico</label>
            <input type="email" name="correo" class="form-control form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp">
          </div>
          <div class="form-group">
            <label>Contraseña</label>
            <a href="#" style="float:right;font-size:12px;">¿Olvidaste tu contraseña?</a>
            <input type="password" name="contra" class="form-control form-control-sm">
          </div>
          <center><button type="submit" class="btn btn-primary btn-block">Ingresar</button></center>
          
          <div class="sign-up">
            ¿No tienes una cuenta? <a href="#">¡Crea una!</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>  
</body>
</html>