
@extends('pages.adminPages.appAdmin')

@section('content')
<main class="container text-center">
    <h1>Editar Categoría</h1>
    <form action="{{ route('categoria.editar',$id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
            <div class="form-group">
                <label for="tipo_negocio">Tipo de Negocio</label>
                <input type="text" value="{{ $categoria['tipo_negocio'] }}" class="form-control" id="tipo_negocio" name="tipo_negocio">
            </div>

            <div class="form-group">
                <label for="info">Información de la categoria</label>
                <input type="text" value="{{$categoria['info']}}" class="form-control" id="info" name="info">
            </div>

            <h3>Imagen actual</h3>
            <img width="500px" height="450" src="{{$categoria['img_url']}}" alt="">
            <div class="form-group">
                <label for="image">Imagen</label>
                <input type="file" value="{{$categoria['img_url']}}" class="form-control" id="image" name="image">
            </div>          <br>
        <button type="submit" class="btn btn-success">Editar Categoría</button>
        <br>
        <br>
        <br>
    </form>
</main>
@endsection