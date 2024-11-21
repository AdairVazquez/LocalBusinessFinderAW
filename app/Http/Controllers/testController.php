<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class testController extends Controller
{
    public function test(){
        $credentials = [
            "type" => env('FIREBASE_TYPE'),
            "project_id" => env('FIREBASE_PROJECT_ID'),
            "private_key_id" => env('FIREBASE_PRIVATE_KEY_ID'),
            "private_key" => str_replace("\\n", "\n", env('FIREBASE_PRIVATE_KEY')), // Reemplaza \\n por saltos de línea reales
            "client_email" => env('FIREBASE_CLIENT_EMAIL'),
            "client_id" => env('FIREBASE_CLIENT_ID'),
            "auth_uri" => env('FIREBASE_AUTH_URI'),
            "token_uri" => env('FIREBASE_TOKEN_URI'),
            "auth_provider_x509_cert_url" => env('FIREBASE_AUTH_PROVIDER_CERT_URL'),
            "client_x509_cert_url" => env('FIREBASE_CLIENT_CERT_URL'),
        ];
        $firebase = (new Factory)
            ->withServiceAccount($credentials)
            ->withDatabaseUri('https://local-business-finder-yapp-default-rtdb.firebaseio.com/');
        $database = $firebase->createDatabase();

        // Escribir en la base de datos para probar la conexión
        $newPost = $database
            ->getReference('test')
            ->set([
                'title' => 'Prueba de conexión',
                'body' => 'Conexión exitosa a Firebase Realtime Database desde Laravel'
            ]);

        // Leer los datos para verificar que se guardaron correctamente
        $snapshot = $database->getReference('test')->getSnapshot();

        // Devolver el resultado
        return response()->json($snapshot->getValue());
        
    }
}
