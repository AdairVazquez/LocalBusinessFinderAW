<?php

namespace App\Http\Controllers\firebase;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class FirebaseUserController extends Controller
{
    public function listUsers()
    {
        // Inicializa Firebase usando las credenciales
        $firebase = (new Factory)
            ->withServiceAccount(base_path('local-business-finder-yapp-firebase-adminsdk-5wwjf-5487f1be4f.json'))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));  // Reemplaza con la URL de tu base de datos si es necesario

        $auth = $firebase->createAuth(); // Utiliza createAuth() en lugar de create()

        // Listar hasta 1000 usuarios
        $users = $auth->listUsers(1000);

        // Mostrar información de cada usuario
        foreach ($users as $user) {
            echo 'UID: '.$user->uid.PHP_EOL;
            echo 'Email: '.$user->email.PHP_EOL;
            echo 'Nombre: '.$user->displayName.PHP_EOL;
            echo '-----'.PHP_EOL;
        }
    }
}

