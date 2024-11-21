@extends('firebase.app')

@section('content')
    
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Agregar usuario
                            <a href="{{url('usuarios')}}" class="btn btn-danger float-end">Regresar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('aggUsuario') }}" method="POST">
                            @csrf
                            <div class="form-group mb3">
                                <label>Nombre</label>
                                <input type="text" name="nombre" class="form-control">
                            </div>
                            <div class="form-group mb3">
                                <label>Apellido</label>
                                <input type="text" name="apellido" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label>Correo electronico</label>
                                <input type="email" name="correo" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label>Contraseña</label>
                                <input type="password" name="contra" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection