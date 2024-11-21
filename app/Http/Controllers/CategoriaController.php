<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\ServiceAccount;
use Carbon\Carbon;
use DateTime;


class CategoriaController extends Controller
{
    protected $database;
    protected $storage;

    public function __construct(Database $database)
    {
        // Aqui se cargan las credenciales y la URL desde el archivo .env
         // Inicialización de Firebase Auth
         $this->auth = (new Factory)
         ->withServiceAccount(config('firebase.connections.firebase.credentials'))
         ->createAuth();
     
     // Inicialización de Firebase Database
     $this->database = (new Factory)
         ->withServiceAccount(config('firebase.connections.firebase.credentials'))
         ->withDatabaseUri('https://local-business-finder-yapp-default-rtdb.firebaseio.com/')
         ->createDatabase();
     
     $this->tabla = 'categoria_negocio';

     // Inicialización de Firebase Storage
     $this->storage = (new Factory)
         ->withServiceAccount(config('firebase.connections.firebase.credentials'))
         ->createStorage();
    }


    public function testConnection()
    {
        // Cargar las credenciales desde el archivo JSON
        $firebase = (new Factory)
            ->withServiceAccount(config('firebase.connections.firebase.credentials'))
            ->withDatabaseUri('https://local-business-finder-yapp-default-rtdb.firebaseio.com/');

        // Obtener la referencia de la base de datos
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

    public function listarCategorias()
    {
        $categorias = $this->database->getReference('categoria_negocio')->getValue();
        return view('pages.registroTienda', compact('categorias'));
    }

    public function listarCategorias2() 
    {
        $categorias = $this->database->getReference('categoria_negocio')->getValue();
        return view('pages.adminPages.listaCategorias', compact('categorias'));
    }

    public function agregarNuevaCategoria(Request $request)
    {
        $file = $request->file('image');
        $fileName = $file->getClientOriginalName();
        $bucket = $this->storage->getBucket();
        $bucket->upload(
            file_get_contents($file->getRealPath()),
            [
                'name' => $fileName
            ]
        );

        $imageUrl = $bucket->object($fileName)->signedUrl(new \DateTime('tomorrow'));

        $newCategory = $this->database
            ->getReference('categoria_negocio')
            ->push([
                'img_url' => $imageUrl,
                'info' => $request->input('info'),
                'tipo_negocio' => $request->input('tipo_negocio')
            ]);
        return redirect()->route('categorias.store');
    }

    public function editarCategoria(Request $request, $id)
    {
        $categoria = $this->database->getReference('categoria_negocio/' . $id)->getValue();
        if ($request->isMethod('post')) {
            $file = $request->file('image');
            if ($file) {
                $fileName = $file->getClientOriginalName();
                $bucket = $this->storage->getBucket();
                $bucket->upload(
                    file_get_contents($file->getRealPath()),
                    [
                        'name' => $fileName
                    ]
                );

                $imageUrl = $bucket->object($fileName)->signedUrl(new \DateTime('tomorrow'));
                $categoria['img_url'] = $imageUrl; 
            }
            $categoria['info'] = $request->input('info');
            $categoria['tipo_negocio'] = $request->input('tipo_negocio');

            $this->database->getReference('categoria_negocio/' . $id)->set($categoria);

            $categorias = $this->database->getReference('categoria_negocio')->getValue();

           return view('pages.adminPages.listaCategorias', compact('categorias'));
        }

        return view('pages.adminPages.editarCategoria', compact('categoria', 'id'));
    }

    public function encontrarCategoria($id){
        $categoria=$this->database->getReference('categoria_negocio/'. $id)->getValue();
        return view('pages.adminPages.editarCategoria', compact('categoria','id'));
    }

    public function eliminarCategoria($id)
    {
        $borrar = $this->database->getReference('categoria_negocio/' . $id)->remove();
        return redirect()->route('categorias.store');
    }





    //Controladores de subCategorias

    public function agregarNuevaSubcategoria(Request $request)
    {
        $categorias = $this->database->getReference('categoria_negocio')->getValue();

        if ($request->isMethod('post')) {
            $data = $request->all();

            // Manejar la imagen
            $file = $request->file('imagen');
            if ($file) {
                $fileName = $file->getClientOriginalName();
                $bucket = $this->storage->getBucket();
                $bucket->upload(
                    file_get_contents($file->getRealPath()),
                    [
                        'name' => $fileName
                    ]
                );
                // Obtener URL de la imagen subida
                $imageUrl = $bucket->object($fileName)->signedUrl(new \DateTime('+6 months'));
                $data['imagen'] = $imageUrl;
            }

            $data['horario'] = $request->input('horario');  // Actualizar el horario
            $data['correo'] = $request->input('correo') ?? '';  // Asigna cadena vacía si es nulo
            $data['instagram'] = $request->input('instagram') ?? '';
            $data['telefono'] = $request->input('telefono') ? str_replace(' ', '', $request->input('telefono')) : 0;
            $data['whatsapp'] = $request->input('whatsapp') ? str_replace(' ', '', $request->input('whatsapp')) : 0;
            $data['telegram'] = $request->input('telegram') ? str_replace(' ', '', $request->input('telegram')) : 0;
            $data['youtube'] = $request->input('youtube') ?? '';
            $data['tiktok'] = $request->input('tiktok') ?? '';
            $data['facebook'] = $request->input('facebook') ?? '';

            
            // Convertir las horas de apertura y cierre a UTC antes de almacenarlas
            $horaApertura = new \DateTime($request->input('hora_apertura'), new \DateTimeZone('America/Mexico_City'));
            $horaApertura->setTimezone(new \DateTimeZone('UTC'));
            $data['hora_apertura'] = $horaApertura->getTimestamp();

            $horaCierre = new \DateTime($request->input('hora_cierre'), new \DateTimeZone('America/Mexico_City'));
            $horaCierre->setTimezone(new \DateTimeZone('UTC'));
            $data['hora_cierre'] = $horaCierre->getTimestamp();
            
            // Guardar los datos en Firebase
            $this->database->getReference('subcategoria_negocio')->push($data);
            return redirect()->route('homepage');
        }

        return view('subcategorias.create', compact('categorias'));
    }

    public function ListaSubCategorias(){
        $reference = session('user');
        $id = array_key_first($reference);
        $subcategorias = $this->database
        ->getReference('subcategoria_negocio')
        ->orderByChild('id_usuario')
        ->equalTo($id)
        ->getValue();
        return view('pages.listaTiendas', compact('subcategorias'));
    }

    public function ListaSubCategoriasCount() {
        $reference = session('user');
        $id = array_key_first($reference);
        $subcategorias = $this->database
            ->getReference('subcategoria_negocio')
            ->orderByChild('id_usuario')
            ->equalTo($id)
            ->getValue();
    
        $numRegistros = $this->database
            ->getReference('subcategoria_negocio')
            ->orderByChild('id_usuario')
            ->equalTo($id)
            ->getSnapshot()
            ->numChildren();
    
        $comentarios = [];
        $calificacionTotal = 0;
        $count = 0;
    
        if (is_array($subcategorias)) {
            foreach ($subcategorias as $idSubcategoria => $subcategoria) {
                $calificaciones = $this->database
                    ->getReference("calificaciones/$idSubcategoria")
                    ->getValue();
    
                // Verificar que las calificaciones existan y sean un arreglo
                if (is_array($calificaciones)) {
                    foreach ($calificaciones as $calificacion) {
                        if (isset($calificacion['comentario']) && $calificacion['comentario'] !== "") {
                            $calificacionTotal += $calificacion['calificacion'];
                            $comentarios[] = [
                                'comentario' => $calificacion['comentario'],
                                'calificacion' => $calificacion['calificacion'],
                                'nombre_negocio' => $subcategoria['nombre_negocio'] ?? 'Nombre desconocido',
                            ];
                        }
                    }
                    // Contador para el promedio de calificación
                    $count += count($calificaciones);
                }
            }
        }
    
        // Evitar dividir por cero
        $cT = $count > 0 ? $calificacionTotal / $count : 0;
        // Formatear a un decimal
        $comentarios['calificacionTotal'] = number_format($cT, 1);
    
        $visitasMensuales = [];
    
        if (is_array($subcategorias)) {
            foreach ($subcategorias as $idSubcategoria => $subcategoria) {
                // Verificamos si la subcategoría tiene un campo de visitas
                if (isset($subcategoria['vistas']) && is_array($subcategoria['vistas'])) {
                    foreach ($subcategoria['vistas'] as $mes => $cantidad) {
                        // Sumamos las visitas por cada mes
                        if (!isset($visitasMensuales[$mes])) {
                            $visitasMensuales[$mes] = 0;
                        }
                        $visitasMensuales[$mes] += $cantidad;
                    }
                }
            }
        }
    
        // Obtén el mes actual en formato `YYYY-MM`
        $mesActual = Carbon::now()->format('Y-m');
    
        // Obtén las visitas del mes actual o 0 si no existen
        $visitasDelMesActual = $visitasMensuales[$mesActual] ?? 0;
    
        // Ordenar los meses para que aparezcan en orden cronológico
        ksort($visitasMensuales);
    
        $estrellas = [ 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0 ];
        if (is_array($subcategorias)) {
            foreach ($subcategorias as $idSubcategoria => $subcategoria){
                $calificaciones = $this->database ->getReference("calificaciones/$idSubcategoria") 
                ->getValue(); if (is_array($calificaciones)) { 
                    foreach ($calificaciones as $calificacion) { 
                        if (isset($calificacion['calificacion']) && is_numeric($calificacion['calificacion'])) { 
                            $estrellas[$calificacion['calificacion']]++; 
                        } 
                    } 
                } 
            } 
        } 
    
        $idsSubcategorias = [];
        if (is_array($subcategorias)) {
            foreach ($subcategorias as $idSubcategoria => $subcategoria) {
                $idsSubcategorias[] = $idSubcategoria;
            }
        }
    
        // Función para obtener los 3 mensajes más recientes
        $recentMessages = [];
    
        if (is_array($subcategorias)) {
            foreach ($subcategorias as $idSubcategoria => $subcategoria) {
                // Obtener la referencia de los mensajes enviados
                $chat = $this->database
                    ->getReference("chat/$idSubcategoria")
                    ->getValue();
    
                if (is_array($chat)) {
                    foreach ($chat as $idUsuarioRemisor => $subcoleccion) {
                        if (isset($subcoleccion['enviados']) && is_array($subcoleccion['enviados'])) {
                            foreach ($subcoleccion['enviados'] as $mensaje) {
                                $recentMessages[] = $mensaje;
                            }
                        }
                    }
                }
            }
        }
    
        // Ordenar los mensajes por fecha y obtener los tres más recientes
        usort($recentMessages, function ($a, $b) {
            return strtotime($b['fecha']) - strtotime($a['fecha']);
        });
    
        $recentMessages = array_slice($recentMessages, 0, 3);

    
        return view('pages.homePage', compact('numRegistros', 'count', 'comentarios', 'visitasMensuales', 'visitasDelMesActual', 'estrellas', 'recentMessages'));
    }
    

    public function mensajes() {
        // Obtener el ID del usuario logueado desde la sesión
        $reference = session('user');
        $userId = array_key_first($reference);
    
        // Obtener las subcategorías que pertenecen al usuario logueado
        $subcategorias = $this->database
            ->getReference('subcategoria_negocio')
            ->orderByChild('id_usuario')
            ->equalTo($userId)
            ->getValue();
    
        // Crear un array con los IDs de las subcategorías del usuario
        $idsSubcategorias = [];
        if (is_array($subcategorias)) {
            foreach ($subcategorias as $idSubcategoria => $subcategoria) {
                $idsSubcategorias[] = $idSubcategoria;
            }
        }
    
        // Obtener todos los mensajes que correspondan a las subcategorías del usuario
        $mensajes = [];
        $subcategoriasMap = [];
        
        if (is_array($subcategorias)) {
            foreach ($subcategorias as $idSubcategoria => $subcategoria) {
                $chat = $this->database
                    ->getReference("chat/$idSubcategoria")
                    ->getValue();
                    
                // Verificar si el chat contiene mensajes
                if (is_array($chat)) {
                    foreach ($chat as $idUsuarioRemisor => $subcoleccion) {
                        if (isset($subcoleccion['enviados']) && is_array($subcoleccion['enviados'])) {
                            foreach ($subcoleccion['enviados'] as $mensaje) {
                                $mensajes[] = [
                                    'id_subcategoria' => $idSubcategoria,
                                    'correo_usuario' => $mensaje['correo'] ?? 'Correo no disponible',
                                    'mensaje' => $mensaje['mensaje'] ?? 'Sin contenido',
                                    'timestamp' => $mensaje['fecha'] ?? 'Sin fecha',
                                    'usuario_id' => $idUsuarioRemisor,
                                    'nombre_negocio' => $subcategoria['nombre_negocio'] ?? 'Nombre desconocido',
                                ];
                            }
                        }
                    }
                }
            }
        }
    
        // Pasar los mensajes a la vista
        return view('pages.listaMensajes', compact('mensajes'));
    }

    
        public function chat($categoriaId) {
            // Obtener el ID del usuario logueado desde la sesión
            $reference = session('user');
            $userId = array_key_first($reference);
    
            // Obtener las subcategorías que pertenecen al usuario logueado
            $subcategorias = $this->database
                ->getReference('subcategoria_negocio')
                ->orderByChild('id_usuario')
                ->equalTo($userId)
                ->getValue();
    
            // Crear un array con los IDs de las subcategorías del usuario
            $idsSubcategorias = [];
            if (is_array($subcategorias)) {
                foreach ($subcategorias as $idSubcategoria => $subcategoria) {
                    $idsSubcategorias[] = $idSubcategoria;
                }
            }
    
            // Verificar si la subcategoría solicitada pertenece al usuario logueado
            if (!in_array($categoriaId, $idsSubcategorias)) {
                return redirect()->back()->with('error', 'No tienes acceso a esta subcategoría.');
            }
    
            $mensajes = [];
            $subcategoriasMap = [];
            $respuestasAgregadas = [];
    
            if (is_array($subcategorias)) {
                foreach ($subcategorias as $idSubcategoria => $subcategoria) {
                    $subcategoriasMap[$idSubcategoria] = $subcategoria['nombre_negocio'] ?? 'Nombre desconocido';
                }
            }
    
            // Obtener la referencia de los mensajes y respuestas para la subcategoría seleccionada
            $chat = $this->database
                ->getReference("chat/$categoriaId")
                ->getValue();
    
            if (is_array($chat)) {
                foreach ($chat as $idUsuarioRemisor => $subcoleccion) {
                    // Obtener los mensajes enviados
                    if (isset($subcoleccion['enviados']) && is_array($subcoleccion['enviados'])) {
                        foreach ($subcoleccion['enviados'] as $mensajeId => $mensaje) {
                            $mensaje['tipo'] = 'mensaje'; // Añadir tipo al mensaje
                            $mensaje['fecha'] = $mensaje['fecha']; // Asegurarse de que la fecha está disponible
                            $mensaje['usuario_id'] = $idUsuarioRemisor; // Asegurarse de que el ID del usuario está disponible
                            $mensaje['correo_usuario'] = $mensaje['correo'] ?? 'Correo desconocido'; // Verificar si el correo está disponible
                            $mensajes[] = $mensaje;
    
                            // Obtener las respuestas para este mensaje (subcolección "respuestas")
                            if (isset($subcoleccion['respuestas']) && is_array($subcoleccion['respuestas'])) {
                                foreach ($subcoleccion['respuestas'] as $respuestaId => $respuesta) {
                                    if (!isset($respuestasAgregadas[$respuestaId])) {
                                        $respuesta['tipo'] = 'respuesta'; // Añadir tipo a la respuesta
                                        $respuesta['fecha'] = $respuesta['fecha']; // Asegurarse de que la fecha está disponible
                                        $respuesta['mensaje_id'] = $mensajeId; // Asociar respuesta con mensaje
                                        $respuesta['usuario_id'] = $idUsuarioRemisor; // Asegurarse de que el ID del usuario está disponible
                                        $respuesta['correo_usuario'] = $respuesta['correo'] ?? 'Correo desconocido'; // Verificar si el correo está disponible
                                        $mensajes[] = $respuesta;
                                        $respuestasAgregadas[$respuestaId] = true; // Marcar la respuesta como agregada
                                    }
                                }
                            }
                        }
                    }
                }
            }
    
            // Ordenar los elementos combinados por fecha usando DateTime para asegurar precisión
            usort($mensajes, function($a, $b) {
                $dateA = new DateTime($a['fecha']);
                $dateB = new DateTime($b['fecha']);
                return $dateA <=> $dateB;
            });
    
            //dd($mensajes);

            // Pasar los mensajes a la vista
            return view('pages.chat', ['mensajes' => $mensajes, 'categoriaId' => $categoriaId]);
        }

    
    
        public function respuesta(Request $request, $subcategoriaId)
        {
            $mensaje = $request->input('respuesta');
            $usuarioId = auth()->id(); // Obtener el ID del usuario autenticado
        
            $now = microtime(true); 
            $fecha = Carbon::now()->format('Y-m-d\TH:i:s.u');

            // Crear la estructura de la respuesta con la fecha en formato ISO 8601 incluyendo microsegundos
            $respuesta = [
                'mensaje' => $mensaje,
                'fecha' => $fecha, // Usar 'fecha' para ser consistente con la estructura de la base de datos
                'usuario_id' => $usuarioId,
            ];
        
            // Buscar el documento en 'chat' donde 'subcategoria_negocio' coincide con $subcategoriaId
            $chatRef = $this->database->getReference("chat/$subcategoriaId");
            $chatSnapshot = $chatRef->getSnapshot();
        
            if ($chatSnapshot->exists()) {
                // Obtener los usuarios remitentes dentro de la subcategoría especificada
                $usuariosRemisores = $chatSnapshot->getValue();
                
                foreach ($usuariosRemisores as $idUsuarioRemisor => $subcoleccion) {
                    // Agregar la respuesta a la subcolección 'respuestas' al mismo nivel que 'enviados'
                    $this->database
                        ->getReference("chat/$subcategoriaId/$idUsuarioRemisor/respuestas")
                        ->push($respuesta);
                }
        
                return redirect()->back()->with('success', 'Respuesta enviada con éxito');
            } else {
                return redirect()->back()->with('error', 'No se encontró la subcategoría especificada.');
            }
        }
        
    

    
}
