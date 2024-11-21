<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\CategoriaController;
use Kreait\Firebase\Contract\Database;
use Illuminate\Http\RedirectResponse;
use Kreait\Firebase\Contract\Storage as FirebaseStorageContract;

class CategoriaControllerTest extends TestCase
{

    protected $controller;
    protected $databaseMock;
    protected $storageMock;
    protected $categoriaId = '-OAWBB6KU-E_3-hxwQrs'; // ID fijo para las pruebas

    public function setUp(): void
    {
        parent::setUp();

        // Creamos un mock de la clase Database
        $this->databaseMock = Mockery::mock(Database::class);
        $this->storageMock = Mockery::mock(FirebaseStorageContract::class);
        
        // Asignamos el mock al controlador
        $this->controller = new CategoriaController($this->databaseMock, $this->storageMock);
    }

    public function test_can_list_categories()
    {
        // Configura el comportamiento esperado del mock
        $this->controller->listarCategorias();
        
        // Aquí deberías verificar que se devuelvan las categorías esperadas
        $this->assertTrue(true); // Reemplaza con una verificación real
    }

    public function testAgregarNuevaCategoria()
    {
        // Simular la subida de un archivo
        $file = UploadedFile::fake()->image('categoria.jpg');

        // Realizar una solicitud POST a la ruta correspondiente
        $response = $this->post(route('categorias.save'), [
            'image' => $file,
            'info' => 'Información de la categoría',
            'tipo_negocio' => 'Tipo de negocio'
        ]);

        // Verificar que la respuesta sea correcta (200 OK o redirección)
        $response->assertStatus(302); // Cambia a 200 si no hay redirección

        // Aquí es donde simulas la interacción con Firebase
        // Asegúrate de que la biblioteca de Firebase esté correctamente configurada para pruebas

        // Puedes usar un mock para simular Firebase
        // Asegúrate de que tu controlador use inyección de dependencias para poder hacerlo
        $firebaseMock = \Mockery::mock('Firebase\Database\Database');
        
        // Simular la respuesta esperada de Firebase
        $firebaseMock->shouldReceive('getReference')
            ->with('categoria_negocio')
            ->andReturnSelf();
        $firebaseMock->shouldReceive('push')
            ->with([
                'img_url' => \Mockery::any(), // Usa un matcher si es necesario
                'info' => 'Información de la categoría',
                'tipo_negocio' => 'Tipo de negocio',
            ]);

        // Reemplaza la instancia de Firebase en tu controlador
        app()->instance('Firebase\Database\Database', $firebaseMock);

        // Verifica que la categoría se haya creado en Firebase
        // Esto dependerá de cómo hayas estructurado tu controlador y tu servicio de Firebase

        // Aquí podrías hacer más aserciones dependiendo de la lógica adicional
    }



    public function test_editar_categoria_con_imagen()
    {
        // Simular la subida de un archivo
        $file = UploadedFile::fake()->image('categoria.jpg');

        // Datos de la categoría
        $categoriaData = [
            'tipo_negocio' => 'Tipo de negocio',
            'info' => 'Información de la categoría',
            'img_url' => 'url/imagine.jpg'
        ];

        // ID de la categoría
        $categoriaId = '-OAWBB6KU-E_3-hxwQrs';

        // Mock de la respuesta de Firebase para obtener la categoría existente
        $this->databaseMock->shouldReceive('getReference')
            ->with('categoria_negocio/' . $categoriaId)
            ->andReturnSelf();
        
        $this->databaseMock->shouldReceive('getValue')
            ->andReturn($categoriaData);
        
        // Mock para almacenar la imagen
        $this->storageMock->shouldReceive('getBucket')
            ->andReturnSelf();
        
        // Mock para la carga del archivo
        $this->storageMock->shouldReceive('upload')
            ->with(Mockery::any(), ['name' => 'categoria.jpg']);
        
        // Mock para obtener la URL de la imagen
        $this->storageMock->shouldReceive('object')
            ->with('categoria.jpg')
            ->andReturnSelf();
        
        $this->storageMock->shouldReceive('signedUrl')
            ->with(Mockery::type(\DateTime::class))
            ->andReturn('http://url/fake-signed-url');

        // Mock para guardar la categoría actualizada
        $this->databaseMock->shouldReceive('set')
            ->with(Mockery::subset([
                'info' => 'Información de la categoría',
                'tipo_negocio' => 'Tipo de negocio',
                'img_url' => 'http://url/fake-signed-url',
            ]));

        // Realizar una solicitud POST a la ruta correspondiente
        $response = $this->post(route('categoria.editar', $categoriaId), [
            'image' => $file,
            'info' => 'Información de la categoría',
            'tipo_negocio' => 'Tipo de negocio'
        ]);

        // Verificar que la respuesta sea correcta (200 OK o redirección)
        $response->assertStatus(200); // Cambia a 302 si se redirige a otra página

        // Verificar que el contenido de la respuesta sea el esperado
        $this->assertEquals('ok', $response->getContent());
    }

    public function test_editar_categoria_sin_imagen()
    {
        // Datos de la categoría
        $categoriaData = [
            'tipo_negocio' => 'Tipo de negocio',
            'info' => 'Información de la categoría',
            'img_url' => 'url/imagine.jpg'
        ];

        // ID de la categoría
        $categoriaId = '-OAWBB6KU-E_3-hxwQrs';

        // Mock de la respuesta de Firebase para obtener la categoría existente
        $this->databaseMock->shouldReceive('getReference')
            ->with('categoria_negocio/' . $categoriaId)
            ->andReturnSelf();
        
        $this->databaseMock->shouldReceive('getValue')
            ->andReturn($categoriaData);

        // Mock para guardar la categoría actualizada sin imagen
        $this->databaseMock->shouldReceive('set')
            ->with(Mockery::subset([
                'info' => 'Información de la categoría',
                'tipo_negocio' => 'Tipo de negocio',
                'img_url' => 'url/imagine.jpg', // La imagen no cambia
            ]));

        // Realizar una solicitud POST a la ruta correspondiente sin imagen
        $response = $this->post(route('categoria.editar', $categoriaId), [
            'info' => 'Información de la categoría',
            'tipo_negocio' => 'Tipo de negocio'
        ]);

        // Verificar que la respuesta sea correcta
        $response->assertStatus(200);
        $this->assertEquals('ok', $response->getContent());
    }
  
    public function testEliminarCategoria()
    {
        // Simula el ID de la categoría a eliminar
        $categoriaId = '-OAWBB6KU-E_3-hxwQrs';
    
        // Configura el mock para que se llame al método getReference con el ID correcto y devuelva un mock adecuado
        $referenceMock = Mockery::mock('ReferenceMock');
        $this->databaseMock->shouldReceive('getReference')
            ->with('categoria_negocio/' . $categoriaId)
            ->andReturn($referenceMock);
    
    
        // Ejecuta el método eliminarCategoria en el controlador
        $response = $this->controller->eliminarCategoria($categoriaId);
    
        // Verifica que la redirección sea correcta
        $this->assertEquals(route('categorias.store'), $response->getTargetUrl());
    }
    
    

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
