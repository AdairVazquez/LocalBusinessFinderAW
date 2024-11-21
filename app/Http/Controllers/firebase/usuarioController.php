<?php

namespace App\Http\Controllers\firebase;

use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Contract\Database;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Kreait\Firebase\Factory;
use GuzzleHttp\Client;
use App\Models\User;
use Illuminate\Http\Response;

class usuarioController extends Controller
{
    protected $database;
    protected $auth;

    public function __construct()
    {
        // Cargar las credenciales de Firebase desde .env
        $credentials = [
            "type" => env('FIREBASE_TYPE'),
            "project_id" => env('FIREBASE_PROJECT_ID'),
            "private_key_id" => env('FIREBASE_PRIVATE_KEY_ID'),
            "private_key" => str_replace("\\n", "\n", env('FIREBASE_PRIVATE_KEY')),
            "client_email" => env('FIREBASE_CLIENT_EMAIL'),
            "client_id" => env('FIREBASE_CLIENT_ID'),
            "auth_uri" => env('FIREBASE_AUTH_URI'),
            "token_uri" => env('FIREBASE_TOKEN_URI'),
            "auth_provider_x509_cert_url" => env('FIREBASE_AUTH_PROVIDER_CERT_URL'),
            "client_x509_cert_url" => env('FIREBASE_CLIENT_CERT_URL'),
        ];

        // Crear la conexión a Firebase utilizando el Factory
        $firebase = (new Factory)
            ->withServiceAccount($credentials)  // Autenticar con las credenciales
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL')); 

        // Inicializar la base de datos y la autenticación
        $this->database = $firebase->createDatabase(); // Método para obtener la base de datos
        $this->auth = $firebase->createAuth(); // Método para obtener la autenticación
        $this->tabla = 'usuario';
    }


    public function login(Request $req)
    {
        $correo = $req->correo;
        $contraseña = $req->contraseña;

        $reference = $this->database->getReference($this->tabla)
            ->orderByChild('correo')
            ->equalTo($correo)
            ->getValue();
            
        $usuario = reset($reference);
        $contraseñaDB = $usuario['contraseña'];

        if (!empty($reference)) {
            
            if($usuario['rol']=='administrador' && $usuario['contraseña']=='admin'){
                if ($reference && $req->contraseña=='admin') {
                    // Crear una instancia del modelo User
                    $user = new User([
                        'email' => $usuario['correo'],
                        'password' => $usuario['contraseña'],
                        // agrega otros campos necesarios
                    ]);
    
                    Auth::login($user);
                    session(['user' => $reference]);

                    return redirect('/admin');                
                }
            }else{
                if ($reference && Hash::check($req->contraseña, $contraseñaDB)) {
                    // Crear una instancia del modelo User
                    $user = new User([
                        'email' => $usuario['correo'],
                        'password' => $usuario['contraseña'],
                        // agrega otros campos necesarios
                    ]);
    
                    Auth::login($user);
                    session(['user' => $reference]);
    
                    return redirect()->intended('homepage');
                    
                } else {
                    return redirect('login')->with('status', 'Contraseña incorrecta :c');
                }
            }

        } else {
            return redirect('login')->with('status', 'No existe un usuario con este correo');
        }
    }


    public function logout(Request $request)
    {
        Auth::logout(); // Cierra la sesión del usuario autenticado
        $request->session()->invalidate(); // Invalida la sesión actual
        $request->session()->regenerateToken(); // Regenera el token CSRF por seguridad

        return redirect('/login')->with('status', 'Sesión cerrada correctamente.');
    }

    public function index(){
       $usuarios = $this->database->getReference($this->tabla)->getValue();
       return view('pages.adminPages.listaUsuarios', compact('usuarios'));
    }

    public function create(){
        return view('firebase.usuarios.create');
    }

    public function store(Request $req){
        $contraseña = $req -> contra;
        $repContra = $req ->repContra;

        if($contraseña == $repContra ){
            $postData = [
                'nombre' => $req->nombre,
                'correo' => $req->correo,
                'contraseña' => Hash::make($contraseña),
            ];
            $postRef = $this->database->getReference($this->tabla)->push($postData);
            if($postRef){
                return redirect('login')->with('status','Usuario Agregado Satisfactoriamente, Por Favor Inicia Sesion');
            }else{
                return redirect('login')->with('status','Usuario NO Agregado');
            }    
        }else{
            //en este return quiero que se haga el envio de la alerta
            return redirect('login')->with('status', 'Las contraseñas no coinciden');
        }         
    }

    public function update($id){
        $key = $id;
        $editar = $this->database->getReference($this->tabla)->getChild($key)->getValue();
        if($editar){
            return view('firebase.usuarios.editar',compact('editar','key'));
        }else{
            return redirect('usuarios')->with('status','ID del usuario no registrado');
        }
    }

    public function save(Request $req, $id){
        $key = $id;
        $postData = [
            'nombre' => $req->nombre,
            'correo' => $req->correo,
            'contraseña' => $req->contra,
        ];
        $updUsuario=$this->database->getReference($this->tabla.'/'.$key)->update($postData);
        if($updUsuario){
            return redirect('usuarios')->with('status','Usuario Actualizado');
        }else{
            return redirect('usuarios')->with('status','Usuario No Actualizado');
        }
    }

    public function delete($id){
        $key = $id;
        $delUs=$this->database->getReference($this->tabla.'/'.$key)->remove();
        if($delUs){
            return redirect('usuarios')->with('status','Usuario Eliminado');
        }else{
            return redirect('usuarios')->with('status','Usuario No Eliminado');
        }
    }
    

    public function procesamientoGoogle(){
        $user = Socialite::driver('google')->user();
        //dd($user);
        $nombre = $user['name'];
        $id = $user['id'];
        $email = $user['email'];
        $avatarUrl = $user->avatar;

        $reference = $this->database->getReference($this->tabla)
        ->orderByChild('correo')
        ->equalTo($email)
        ->getValue();

        if (!empty($reference)){
            $usuario = reset($reference);
            session(['user' => $reference]);
            return redirect()->route('homepage');
            Auth::login($usuario);
            echo('logeado');
        } else {
            $usuario = $datosUser = [
                'id' => $id,
                'nombre' => $nombre,
                'correo' => $email,
                'avatar' => $avatarUrl,
                'oAuth' => 'Google',
                'rol' => 'Locatario'
            ];
            $postRef = $this->database->getReference($this->tabla)->push($datosUser);

            $referenceNueva = $this->database->getReference($this->tabla)
            ->orderByChild('correo')
            ->equalTo($email)
            ->getValue();
            $usuario = reset($referenceNueva);
            session(['user' => $referenceNueva]);
            Auth::login($usuario);
            return redirect()->route('homepage');
            echo('Registrado y logeado con exito');
        }
    }
    

    public function procesamientoGithub(){
        $user = Socialite::driver('github')->user();
        
        $nombre = $user['name'];
        $id = $user['id'];
        $email = $user['email'];
        $avatar = $user['avatar_url'];

        $reference = $this->database->getReference($this->tabla)
        ->orderByChild('correo')
        ->equalTo($email)
        ->getValue();

        if (!empty($reference)){
            session(['user' => $reference]);
            return redirect()->route('homepage'); 
            echo('logeado');
        } else {
            $usuario = $datosUser = [
                'id' => $id,
                'nombre' => $nombre,
                'correo' => $email,
                'avatar' => $avatar,
                'oAuth' => 'Github',
            ];
            $postRef = $this->database->getReference($this->tabla)->push($datosUser);
            $referenceNueva = $this->database->getReference($this->tabla)
            ->orderByChild('correo')
            ->equalTo($email)
            ->getValue();
            session(['user' => $referenceNueva]);
            return redirect()->route('homepage');
            echo('Registrado y logeado con exito');
        }
    }

    public function listadoUsuariosAndroid(){
        $userss = $this->auth->listUsers(1000);

        // Convierte el generador a una colección o array
        $users = iterator_to_array($userss);
    
        // Retorna la vista con la lista de usuarios
        return view('pages.adminPages.listaUsuarios')->with('users', $users);
    }
}
