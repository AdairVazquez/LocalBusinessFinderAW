
@extends('firebase.app')

@section('content')
    
    <div class="container">
        <div class="row">
            <div class="col-mid-12">
                @if (@session('status'))
                    <h4 class="alert alert-warning mb-2">
                        {{session('status')}}
                    </h4>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>Lista de usuarios
                            <a href="{{url('aggUsuario')}}" class="btn btn-primary float-end">Agregar usuario</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Correo electrónico</th>
                                    <th>Eliminar</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @forelse ($usuarios as $key => $item)
                                        <tr>
                                            <td>{{$key}}</td>
                                            <td>{{$item['nombre']}}</td>
                                            <td>{{$item['apellido']}}</td>
                                            <td>{{$item['correo']}}</td>
                                            <td><a href="{{url('delUsuario/'.$key)}}" class="btn btn-danger">🗑</a></td>
                                            <td><a href="{{url('updUsuario/'.$key)}}" class="btn btn-primary">✍</a></td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7">No existen usuarios en la bae de datos</td>
                                            </tr>
                                    @endforelse
                                    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection