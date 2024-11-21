@extends('firebase.app')

@section('content')
    
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Editar usuario
                            <a href="{{url('usuarios')}}" class="btn btn-danger float-end">Regresar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('upUsuario/'.$key) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb3">
                                <label>Nombre</label>
                                <input type="text" name="nombre" value="{{$editar['nombre']}}" class="form-control">
                            </div>
                            <div class="form-group mb3">
                                <label>Apellido</label>
                                <input type="text" name="apellido" value="{{$editar['apellido']}}" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label>Correo electronico</label>
                                <input type="email" name="correo" value="{{$editar['correo']}}" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label>Contraseña</label>
                                <input type="password" name="contra" value="{{$editar['contraseña']}}" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection