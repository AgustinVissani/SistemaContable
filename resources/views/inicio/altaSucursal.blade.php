@extends('welcome')
@section('section')



    <form action="altaSucursal" method="POST">
        @csrf
        <div class="container text-center ">

            <h1 class="text-center h1tablaCliente">Alta sucursal</h1>

        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="denominacion">Nombre Sucursal </label>
                <input type="text" class="form-control" name="denominacion" id="denominacion"
                    placeholder="Nombre Sucursal" value=" {{ old('denominacion') }} " required autofocus>
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



        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="cp">Código Postal </label>
                <input type="text" class="form-control" name="cp" id="cp" placeholder="Código Postal"
                    value="{{ old('cp') }}" r autofocus>

            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="id_localidad">Localidad </label>
                <input type="text" class="form-control" name="id_localidad" id="id_localidad" placeholder="Localidad"
                    value="{{ old('id_localidad') }}" autofocus>

            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="calle">Calle </label>
                <input type="text" class="form-control" name="calle" id="calle" placeholder="Calle"
                    value="{{ old('calle') }}" autofocus>

            </div>
        </div>


        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="numero">Número </label>
                <input type="text" class="form-control" name="numero" id="numero" placeholder="Número"
                    value="{{ old('numero') }}" autofocus>

            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="piso">Piso </label>
                <input type="text" class="form-control" name="piso" id="piso" placeholder="Piso"
                    value="{{ old('piso') }}" autofocus>
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


        <div class="form-group">
            <button style="margin: 10px" type="submit" class="btn btn-primary">GUARDAR</button>


            <a  type="reset" id="cancel" name="cancel" href="/sucursales"  class="btn btn-secondary" value="1">CANCELAR</a>
        </div>



    </form>
@endsection
