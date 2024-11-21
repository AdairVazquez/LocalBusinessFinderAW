<nav style="background-color:  #37033b;" class="navbar navbar-expand-lg" >
    <div class="container-fluid">
      <a class="navColorFont navbar-brand d-flex align-items-center" href="{{url('homePage')}}">
        <img src="{{asset('img/logo.png')}}" alt="logo" width="50px" height="50px" class="img-logo d-inline-block align-text-top me-2">
        <span class="align-middle">LocalBusinessFinder</span>
    </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="me-2 d-flex  navbar-brand" id="navbarSupportedContent">
        <ul  class=" navColorFont navbar-nav me-2 mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="navColorFont nav-link" aria-current="page" href="#">Agregar usuario</a>
          </li>
          <li class="nav-item">
            <a class="navColorFont nav-link" href="{{url('usuarios')}}">Link</a>
          </li>
        </ul>       
      </div>
    </div>
  </nav>