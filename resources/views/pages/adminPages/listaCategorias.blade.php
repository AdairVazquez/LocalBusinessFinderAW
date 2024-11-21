@extends('pages.adminPages.appAdmin')

@section('content') 
<main class="container text-center">
    <h1>Lista de categorías registradas</h1><br>
    <a href="{{route('form.categoria')}}" class="btn btn-success">Agregar nueva categoría</a><br>
    <div class="row align-items-center">
        @foreach ($categorias as $key=>$datos)
            <div class="col-md-4 mb-3">
                <div class="card" style="width: 18rem;">
                    <img src="{{$datos['img_url']}}" class="card-img-top" width="150px" height="200px" alt="...">
                    <div class="card-body">
                    <h5 class="card-title">{{$datos['tipo_negocio']}}</h5>
                    <p class="card-text">Información del negocio: {{$datos['info']}}</p>
                    <a href="{{url('editarCategoria/'.$key)}}" class="btn btn-primary">Editar</a>
                    <form action="{{ url('eliminarCategoria/'.$key) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</main>
@endsection