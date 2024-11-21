<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\firebase\usuarioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\testController;
use App\Http\Controllers\firebase\FirebaseUserController;
use App\Http\Middleware\sessionAuth;
use App\Http\Middleware\sessionAuthAdmin;

use Laravel\Socialite\Facades\Socialite;
 
Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/logout', [usuarioController::class, 'logout'])->name('logout');

//Rutas del login
Route::post('registrarUsuario', [usuarioController::class,'store']);


Route::post('logeo', [usuarioController::class,'login']);


//Rutas de login redes sociales
//google
Route::get('/login-google', function () { 
    return Socialite::driver('google') ->scopes(['openid', 'profile', 'email'])->redirect();
});
Route::get('/google-callback', [usuarioController::class,'procesamientoGoogle']);
//facebook
Route::get('/login-github', function () {
    return Socialite::driver('github')->redirect();
});
Route::get('/github-callback', [usuarioController::class,'procesamientoGithub']);

use App\Http\Controllers\GoogleLoginController;

Route::get('auth/google', [usuarioController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [usuarioController::class, 'handleGoogleCallback'])->name('auth.callback');

Route::get('prueba', [testController::class, 'test']);

Route::get('/login', function () {
    return view('login');
})->name('login');
  

//RUTAS LOCATARIO

Route::middleware([sessionAuth::class])->group(function () {
    Route::get('/homepage', [CategoriaController::class, 'ListaSubCategoriasCount'])->name('homepage');
    Route::get('/registroLocal', function () { 
    return view('pages/registroTienda');
    });
    Route::get('/registro', [CategoriaController::class, 'listarCategorias'])->name('categorias.list');
    Route::get('listaMensajes', [CategoriaController::class, 'mensajes'])->name('categoria.mensajes');
    Route::get('chat/{id}',[CategoriaController::class,'chat'])->name('categoria.chat');
    Route::post('chat/respuesta/{subcategoriaId}',[CategoriaController::class,'respuesta'])->name('chat.respuesta');
    Route::post('registroTienda', [CategoriaController::class, 'agregarNuevaSubcategoria'])->name('categorias.subcat');
    Route::get('tusNegocios', [CategoriaController::class, 'ListaSubCategorias'])->name('subCategorias.store');    
});




//RUTAS ADMINISTRADOR

Route::middleware([sessionAuthAdmin::class])->group(function () {
    Route::get('/admin', function () { 
        return view('pages/adminPages/homePageAdm');
    })->name('homeAdmin');
    Route::get('/aggCat', function () { 
        return view('pages/adminPages/aggCategoria');
    })->name('form.categoria');
    Route::post('/guardarCat', [CategoriaController::class, 'agregarNuevaCategoria'])->name('categorias.save');
    Route::get('/categorias', [CategoriaController::class, 'listarCategorias2'])->name('categorias.store');
    Route::get('editarCategoria/{id}', [CategoriaController::class, 'editarCategoria'])->name('categoria.found');
    Route::post('editarCategoriaa/{id}', [CategoriaController::class, 'editarCategoria'])->name('categoria.editar');
    Route::delete('eliminarCategoria/{id}', [CategoriaController::class, 'eliminarCategoria'])->name('categoria.eliminar');
    Route::get('/editarCat/{id}', function () { 
        return view('pages.adminPages.editarCategoria');
    })->name('form.editCat');

    Route::get('/listausuarios',[usuarioController::class,'index'])->name('ListaUsuario');

});














 
//Controlador sub categorias 
