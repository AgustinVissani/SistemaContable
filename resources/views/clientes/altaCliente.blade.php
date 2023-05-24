@extends('welcome')
@section('section')
    <form action="altaCliente" method="POST" onsubmit="return validacion()">
        @csrf
        <div class="container text-center ">
            <h1 class="text-center h1tablaCliente">Alta Cliente</h1>
        </div>

        <script>
            var campo = $('#id_del_input').val();
        </script>




        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" value=" {{ old('nombre') }} " id="nombre"
                    placeholder="Nombre" required>
            </div>
            <div class="col-md-4">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" name="apellido" value=" {{ old('apellido') }} " id="apellido"
                    placeholder="Apellido" required>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-3">
                <label for="dni">DNI</label>
                <input type="number" class="form-control soloNumeros" name="dni" value=" {{ old('dni') }} " id="dni"
                    placeholder="DNI" min="1" max="99999999" required>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="mail">E-mail</label>
                <label class="sr-only">Mail</label>
                <input type="email" class="form-control" name="mail" value=" {{ old('mail') }} " id="mail"
                    placeholder="E-mail" required>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="direccion">Dirección</label>
                <label class="sr-only">Dirección</label>
                <input type="text" class="form-control" name="direccion" value=" {{ old('direccion') }} " id="direccion"
                    placeholder="Dirección" required>
            </div>
        </div>




        <div class="mb-3 row">
            <div class=" col-md-3">
                <label for="telefono">Teléfono</label>
                <label class="sr-only">Teléfono</label>
                <input type="number" class="form-control" name="telefono" value=" {{ old('telefono') }} " id="telefono"
                    placeholder="Teléfono" required>
            </div>
        </div>




        <div class="mb-3 row">
            <div class=" col-md-12">
                <label for="sexo">Género</label>
                <select name="sexo" id="sexo" class="form-control" required>
                    @foreach ($sexos as $sexo)
                        <option value="{{ $sexo->id }}">{{ $sexo->tipo }}</option>
                    @endforeach
                </select>
            </div>

            <div class=" col-md-3 my-4">
                <label for="id_provincia">Agregar género</label>
                <a type="button" href="/sexos" title="Agregar Géneros" class="btn btn-outline-success"><i
                        style="color: black" class="fas fa-plus"></i></a>
            </div>
        </div>





        <div class="mb-3 row">
            <div class=" col-md-2">
                <label for="idP">ID Provincia</label>
                <label class="sr-only">ID Provincia</label>
                <input type="number" class="form-control" name="idP" value=" {{ old('idP') }} " id="idP"
                    placeholder="ID Provincia" onkeyup="setProvincia()">

            </div>

            <div class=" col-md-3">
                <label for="id_provincia">Provincia</label>
                <select name="id_provincia" id="id_provincia" class="form-control" required>
                    @foreach ($provincias as $provincia)
                        <option value="{{ $provincia->id }}">{{ $provincia->id }} {{ $provincia->descripcion }}
                        </option>
                    @endforeach
                </select>
                <label hidden id="noProvincia">No se encontraron resultados</label>
            </div>
        </div>

        <script>
            document.getElementById('telefono').value = parseInt(document.getElementById('telefono').defaultValue);
            document.getElementById('dni').value = parseInt(document.getElementById('dni').defaultValue);
            document.getElementById('idP').value = parseInt(document.getElementById('idP').defaultValue);
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


            <a  type="reset" id="cancel" name="cancel" href="/clientes"  class="btn btn-secondary" value="1">CANCELAR</a>
        </div>


    </form>
@endsection
