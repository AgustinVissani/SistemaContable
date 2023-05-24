@extends('welcome')
@section('section')
    <form action="/editUsuario/{{ $user->id }}" method="POST">

        @csrf

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Nombre" required
                    value="{{ $user->name }}">
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-2">
                <label for="dni">ID Rol</label>
                <label class="sr-only">ID Rol</label>
                <input type="number" class="form-control" name="idR" id="idR" placeholder="ID Rol" onkeyup="setRol()">

            </div>

            <div class=" col-md-3">
                <label for="id_rol">Rol</label>
                <select name="id_rol" id="id_rol" class="form-control form-persona-required"
                    oninvalid="this.setCustomValidity('Debe ingresar un rol para el usuario')" required="true"
                    oninput="setCustomValidity('')" required>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id }}">{{ $rol->id }} - {{ $rol->descripcion }}
                        </option>
                    @endforeach
                </select>
                <script>
                    document.getElementById('id_rol').value = {{ $user->id_rol }};
                </script>
                <label hidden id="noRol">No se encontraron resultados</label>
            </div>
        </div>




        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="mail">E-mail</label>
                <input type="email" class="form-control" name="email" id="email" required value="{{ $user->email }}">
            </div>
        </div>



        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="password">Contraseña</label>
                <label class="sr-only">Contraseña</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Dirección">
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="password_confirmation">Confirmar contraseña</label>
                <label class="sr-only">Confirmar contraseña</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                    placeholder="Confirmar contraseña">
            </div>
        </div>




        @if (count($errors) > 0)
            <div class="alert alert-danger" style="width: 500px">
                <ul>

                    @foreach ($errors->all() as $error)

                        <li class="errorMessage">{{ $error }}</li>

                    @endforeach

                </ul>
            </div>
        @endif

        <br>




        <div class="form-group">
            <button style="margin: 10px" type="submit" class="btn btn-primary">GUARDAR</button>
            <a  type="reset" id="cancel" name="cancel" href="/usuarios"  class="btn btn-secondary" value="1">CANCELAR</a>
        </div>

    </form>
@endsection
