<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class sessionAuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Verifica si el usuario no está en la sesión
         if (session('user') === null ){
            // Redirige al usuario a una ruta específica
            return redirect('/login')->with('status','Debes iniciar sesion para acceder a esta ruta'); // Cambia '/ruta-login' por la ruta deseada
        }else{
            $userSession = session('user');

            // Acceder al primer elemento (el array asociativo con la clave única)
            $firstUserData = reset($userSession); // Obtiene el primer elemento del array

            // Consultar el atributo 'rol'
            $rol = $firstUserData['rol'];
            if($rol != 'administrador'){
                return redirect('/login')->with('status','Debes ser administrador para acceder a esta ruta'); 
            }
        }

        // Continúa con la solicitud
        return $next($request);
    }
}
