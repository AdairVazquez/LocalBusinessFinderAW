
@extends('pages.adminPages.appAdmin')

@section('content')
    <main class="container text-center">
        <div class="row align-items-center ">
            
            <div class="col-md-6 ">
                <center>
                <div class="card" style="width: 18rem;">
                    <img src="{{asset('img/usuarios.png')}}" class="card-img-top" alt="...">
                    <div class="card-body">
                      <h5 class="card-title">Usuarios</h5>
                      <p class="card-text">Revisa los usuarios que no han pagado para suspender la sucripción.</p>
                      <a href="{{route('ListaUsuario')}}" class="btn btn-primary">Ir a lista de usuarios</a>
                    </div>    
                </div>
                </center>
            </div><!--div principal-->
            <div class="col-md-6">
                <center>
                    <div class="card mt-4 mb-4" style="width: 18rem;">
                        <img src="{{asset('img/categoria.png')}}" class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">Categorías</h5>
                          <p class="card-text">Revisa las categorias qu los usuarios han agregado, corrige algún error de ortografía o elimínala.</p>
                          <a href="{{route('categorias.store')}}" class="btn btn-primary">Ir a lista de categorías</a>
                        </div>    
                    </div>
                </center>
            </div>
        </div>
    </main>
@endsection