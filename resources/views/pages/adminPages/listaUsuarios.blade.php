@extends('pages.adminPages.appAdmin')

@section('content')
<main class="container text-center">
    <h1>Lista de usuarios suscritos</h1>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Estatus pago</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
       
            @foreach ($usuarios as $key => $user)
                <tr>
                    <td>{{ $user['nombre'] ?? 'No disponible' }}</td>
                    <td>{{ $user['correo'] ?? 'No disponible' }}</td>
                    <td style="color: green">Activo</td>
                    <td><a style="color: red" href="">Desactivar cuenta</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</main>
@endsection
