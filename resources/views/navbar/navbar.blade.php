<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    @if (Route::has('login'))
        @auth
            @if (Auth::user()->id_rol != 3 || Auth::user()->id_rol != 1 || Auth::user()->id_rol != 2 || Auth::user()->id_rol != 4)
                <a class="navbar-brand" style="color: white" href="/inicio">Empresa</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            @endif
        @endauth
    @endif
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        @if (Route::has('login'))
            @auth

                <ul class="navbar-nav mr-auto">
                    @if (Auth::user()->id_rol == 3 || Auth::user()->id_rol == 1)
                        <!-- REGISTRAR TABLAS -->


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Registros
                            </a>
                            <div class="dropdown-menu"  aria-labelledby="navbarDropdown" >
                            <a class="dropdown-item" title='Clientes' href="/clientes">Clientes <i class="fas fa-users"></i></a>
                              <a class="dropdown-item" title='Provincias' href="/provincias">Provincias <i
                                class="fas fa-map-marker-alt"></i></a>
                              @if (Auth::user()->id_rol == 2 || Auth::user()->id_rol == 1)
                              <!-- REGISTRAR USUARIOS -->
                                  <a class="dropdown-item" title='Registrar usuarios' href="/usuarios">Usuarios <i
                                          class="fas fa-user"></i></a>
                          @endif
                            </div>
                          </li>

                          <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Contabilidad
                            </a>
                            <div class="dropdown-menu"  aria-labelledby="navbarDropdown" >
                            <a class="dropdown-item"  title='Plan Cuentas' href="/planCuentas">Plan de Cuentas <i class="fas fa-poll-h"></i></a>
                              <a class="dropdown-item" title='Asientos' href="/asientos">Asientos <i class="fas fa-book"></i></a>
                              <a class="dropdown-item" title='Diario-Mayor' href="/diariomayor">Diario-Mayor <i class="fas fa-book-open"></i></a>
                              <a class="dropdown-item" title='listadoBalance' href="/listadoBalance">Balance <i class="fas fa-balance-scale-right"></i></i></a>
                              <a class="dropdown-item"  title='Sucursal' href="/sucursales">Sucursal </a>
                              <a class="dropdown-item" title='Sección' href="/secciones">Sección </a>
                            </div>
                          </li>



                    @endif

                    {{-- @if (Auth::user()->id_rol == 2 || Auth::user()->id_rol == 1)
                        <!-- REGISTRAR USUARIOS -->
                        <li class="nav-item">
                            <a class="nav-link" title='Registrar usuarios' href="/usuarios">Usuarios <i
                                    class="fas fa-user"></i></a>
                        </li>
                    @endif --}}

                    @if (Auth::user()->id_rol == 4 || Auth::user()->id_rol == 1)
                        <!-- AUDITAR -->
                        <li class="nav-item">
                            <a class="nav-link" title='Auditorias' href="/audit">Auditar <i class="fas fa-eye"></i></a>
                        </li>
                    @endif



                    @if (Auth::user()->id_rol == 1)
                        <!-- BACKUPS -->
                        <li class="nav-item">
                            <a class="nav-link" title='Backup' href="/backup">Backup <i class="fas fa-save"></i></a>
                        </li>
                    @endif



                </ul>
        </div>
        <ul class="navbar-nav ml-auto">
            @if (Auth::check())

                <li class="nav-item">
                    <a class="nav-link">Usuario: {{ $name = Auth::user()->name }} <i class="far fa-user"></i></i></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link">Empresa:  {{$empre }} <i class="fas fa-industry"></i></a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link" data-title='Cerrar sesión' data-toggle="modal" data-target="#modalLogOut"><i
                        class="fas fa-sign-out-alt"></i></a>
            </li>
        </ul>





    @else

        {{-- <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" title='Iniciar sesión' href="/login">
                    <i class="fas fa-sign-in-alt"></i></a>
            </li>
        </ul> --}}
        <a class="navbar-brand" style="color: white" href="/inicio">Inicio</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

    @endauth
    @endif
    </div>

</nav>

<div class="modal " tabindex="-1" id="modalLogOut" data-keyboard="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cierrre de sesión</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Desea cerrar sesión?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a class="btn btn-danger" href="route('logout')" onclick="event.preventDefault();
                                            this.closest('form').submit();">
                        {{ __('Cerrar sesión') }}
                        <a>
                </form>
            </div>
        </div>
    </div>
</div>
