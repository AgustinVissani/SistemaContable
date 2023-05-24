@extends('welcome')
@section('section')

    <form action="altaUsuario" method="POST">
        @csrf
        <div class="container text-center ">
            <h1 class="text-center h1tablaCliente">Alta Usuario</h1>
        </div>


        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" value=" {{ old('name') }} " id="name"
                    placeholder="Nombre" required>
            </div>
        </div>

        <div class="mb-4 row">
            <div class=" col-md-2">
                <label for="idR">ID Rol</label>
                <label class="sr-only">ID Rol</label>
                <input type="number" class="form-control" name="idR" value=" {{ old('idR') }} " id="idR"
                    placeholder="ID Rol" onkeyup="setRol()">

            </div>
            <div class=" col-md-3">
                <label for="id_rol">Rol</label>
                <select name="id_rol" id="id_rol" class="form-control" required>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id }}">{{ $rol->id }} {{ $rol->descripcion }}
                        </option>
                    @endforeach
                </select>
                <label hidden id="noRol">No se encontraron resultados</label>
            </div>
            {{-- <div class=" col-md-3 my-4">
            <label for="rol">Agregar Rol</label>
            <a type="button" href="/roles" title="Agregar Rol" class="btn btn-outline-success"><i
                    style="color: black" class="fas fa-plus"></i></a>
        </div> --}}

        </div>



        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="email">E-mail</label>
                <label class="sr-only">E-Mail</label>
                <input type="email" class="form-control" name="email" value=" {{ old('email') }} " id="email"
                    placeholder="E-mail" required>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="password">Contraseña</label>
                <label class="sr-only">Contraseña</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña"
                    required>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="password_confirmation">Confirmar contraseña</label>
                <label class="sr-only">Confirmar contraseña</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                    placeholder="Confirmar contraseña" required>
            </div>
        </div>

        <script>
            document.getElementById('idR').value = parseInt(document.getElementById('idR').defaultValue);
        </script>


        @if (count($errors) > 0)
            <div class="alert alert-danger" style="width: 500px">
                <ul>

                    @foreach ($errors->all() as $error)

                        <li class="errorMessage">{{ $error }}</li>

                    @endforeach

                </ul>
            </div>
        @endif



        <div class="form-group">
            <button style="margin: 10px" type="submit" class="btn btn-primary">GUARDAR</button>


            <a  type="reset" id="cancel" name="cancel" href="/usuarios"  class="btn btn-secondary" value="1">CANCELAR</a>
        </div>


    </form>
@endsection
