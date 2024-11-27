@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <title>Bienvenido</title>
</head>
<body>
  @if (@session('status'))
    <script>
        alert("{{session('status')}}");
    </script>
  @endif
    <div class="container">
        <div class="formBox level-login">
          <div class="box boxShaddow"></div>
          <div class="box loginBox">
            <h2>INICIO DE SESIÓN</h2>
            <form class="form" action="{{url('logeo')}}" method="POST">
              @csrf
              <div class="f_row"> 
                <label>Correo</label>
                <input type="text" name="correo" class="input-field" required>
                <u></u>
              </div>
              <div class="f_row last">
                <label>Contraseña</label>
                <input type="password" name="contraseña" class="input-field" required>
            
                <u></u>
              </div>
              <button class="btn"><span>Entrar</span><u></u>
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 415.582 415.582" xml:space="preserve">
                  <path d="M411.47,96.426l-46.319-46.32c-5.482-5.482-14.371-5.482-19.853,0L152.348,243.058l-82.066-82.064
                        c-5.48-5.482-14.37-5.482-19.851,0l-46.319,46.32c-5.482,5.481-5.482,14.37,0,19.852l138.311,138.31
                        c2.741,2.742,6.334,4.112,9.926,4.112c3.593,0,7.186-1.37,9.926-4.112L411.47,116.277c2.633-2.632,4.111-6.203,4.111-9.925
                        C415.582,102.628,414.103,99.059,411.47,96.426z"/>
                  </svg>
              </button>
            </form>
              <div class="f_link">
                <label>Inicia sesion con:</label><br>
                <a href="{{url('login-github')}}"><img src="{{asset('img/github.png')}}" alt=""></a><a href="{{url('login-google')}}"><img src="{{asset('img/gmail.png')}}" alt=""></a><br>
                
                <a href="" class="resetTag">¿Olvidaste tu contraseña?</a>
              </div>
   
          </div>
          <div class="box forgetbox">
            <a href="#" class="back icon-back">
            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 199.404 199.404" style="enable-background:new 0 0 199.404 199.404;"
           xml:space="preserve">
          <polygon points="199.404,81.529 74.742,81.529 127.987,28.285 99.701,0 0,99.702 99.701,199.404 127.987,171.119 74.742,117.876 
              199.404,117.876 "/>
      </svg>
            </a>
            <h2>Recuperar contraseña</h2>
            <form class="form" method="POST" action="{{route('envCorreo')}}">
              @csrf
              <p>Escribe tu correo en el siguente cuadro de texto, posteriormente se te enviará un correo para la recuperación de tu contraseña.</p>
              <div class="f_row last">
                <label>Ingresa tu email</label>
                <input type="email" name="email" class="input-field" required>
                <u></u>
              </div>
              <button class="btn" type="submit"><span>Recuperar</span><u></u>
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 415.582 415.582" xml:space="preserve">
                                      <path d="M411.47,96.426l-46.319-46.32c-5.482-5.482-14.371-5.482-19.853,0L152.348,243.058l-82.066-82.064
                                            c-5.48-5.482-14.37-5.482-19.851,0l-46.319,46.32c-5.482,5.481-5.482,14.37,0,19.852l138.311,138.31
                                            c2.741,2.742,6.334,4.112,9.926,4.112c3.593,0,7.186-1.37,9.926-4.112L411.47,116.277c2.633-2.632,4.111-6.203,4.111-9.925
                                            C415.582,102.628,414.103,99.059,411.47,96.426z"/>
                                      </svg>
              </button>
            </form>
          </div>
          <div class="box registerBox">
            <span class="reg_bg"></span>
            <h2>Registrarse</h2>
            <form class="form" action="{{url('registrarUsuario')}}" method="POST">
              @csrf
              <div class="f_row">
                <label>Nombre</label>
                <input type="text" name="nombre" class="input-field" required>
                <u></u>
              </div>
              <div class="f_row">
                <label>Correo electronico</label>
                <input type="text" name="correo" class="input-field" required>
                <u></u>
              </div>
              <div class="f_row">
                <label>Contraseña</label>
                <input type="password" name="contra" class="input-field" required>
                <u></u>
              </div>
              <div class="f_row last">
                <label>Repite tu contraseña</label>
                <input type="password" class="input-field" name="repContra" required>
                <u></u>
              </div>
              <button class="btn-large">Enviar</button>
            </form>
          </div>
          <a href="#" title='¡Registrate ahora!' class="regTag icon-add">
            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 357 357" style="enable-background:new 0 0 357 357;" xml:space="preserve">
      <path d="M357,204H204v153h-51V204H0v-51h153V0h51v153h153V204z"/>
      </svg>
      
          </a>
        </div>
      </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('js/funciones.js')}}"></script>
    
</body>
</html>