@extends('welcome')
@section('section')
    <form action="/editCliente/{{ $cliente->id }}" method="POST">

        @csrf
        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre" required
                    value="{{ $cliente->nombre }}">
            </div>
            <div class="col-md-4">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" name="apellido" id="apellido" required
                    value="{{ $cliente->apellido }}">
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-3">
                <label for="dni">DNI</label>
                <input type="number" min="1" max="99999999" class="form-control soloNumeros" name="dni" id="dni" required
                    value="{{ $cliente->dni }}">
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="mail">E-mail</label>
                <input type="email" class="form-control" name="mail" id="mail" required value="{{ $cliente->mail }}">
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" name="direccion" id="direccion" required
                    value="{{ $cliente->direccion }}">
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-3">
                <label for="telefono">Teléfono</label>
                <input type="number" class="form-control" name="telefono" id="telefono" required
                    value="{{ $cliente->telefono }}">
            </div>
        </div>


        <div class="mb-3 row">
            <div class=" col-md-3">
                <label for="sexo">Género</label>
                <select name="sexo" id="sexo" class="form-control" required>
                    @foreach ($sexos as $sexo)
                        <option value="{{ $sexo->id }}">{{ $sexo->tipo }}</option>
                    @endforeach
                </select>
                <script>
                    document.getElementById('sexo').value = {{ $cliente->sexo }};
                </script>
            </div>
        </div>




        <div class="mb-3 row">
            <div class=" col-md-2">
                <label for="dni">ID Provincia</label>
                <label class="sr-only">ID Provincia</label>
                <input type="number" class="form-control" name="idP" id="idP" placeholder="ID Provincia"
                    onkeyup="setProvincia()">

            </div>

            <div class=" col-md-3">
                <label for="id_provincia">Provincia</label>
                <select name="id_provincia" id="id_provincia" class="form-control form-persona-required"
                    oninvalid="this.setCustomValidity('Debe ingresar una ciudad pare el cliente')" required="true"
                    oninput="setCustomValidity('')" required>
                    @foreach ($provincias as $provincia)
                        <option value="{{ $provincia->id }}">{{ $provincia->id }} - {{ $provincia->descripcion }}
                        </option>
                    @endforeach
                </select>
                <script>
                    document.getElementById('id_provincia').value = {{ $cliente->id_provincia }};
                </script>
                <label hidden id="noProvincia">No se encontraron resultados</label>
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

            <a  type="reset" id="cancel" name="cancel" href="/clientes"  class="btn btn-secondary" value="1">CANCELAR</a>
        </div>
    </form>
@endsection
