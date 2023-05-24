@extends('welcome')
@section('section')

    <form action="/editdatosEmpresa/{{ $empresa->id }}" method="POST">
        @csrf
        <div class="container text-center ">

            <h1 class="text-center h1tablaCliente">Editar Empresa</h1>

        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="nombrepila">Nombre de la empresa </label>
                <input type="text" class="form-control" name="nombrepila" id="nombrepila" placeholder="Empresa"
                    value="{{ $empresa->nombrepila }}" required autofocus>
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
                <select name="id_provincia" id="id_provincia" class="form-control">
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
                <input type="number" class="form-control" name="cp" id="cp"
                    value="{{ $empresa->cp }}" autofocus>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="id_localidad">Localidad </label>
                <input type="text" class="form-control" name="id_localidad" id="id_localidad"
                    value="{{ $empresa->id_localidad }} " autofocus>
            </div>
        </div>



        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="calle">Calle </label>
                <input type="text" class="form-control" name="calle" id="calle"
                    value="{{ $empresa->calle }} " autofocus>
            </div>
        </div>



        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="numero">Número </label>
                <input type="text" class="form-control" name="numero" id="numero"
                    value="{{ $empresa->numero }} " autofocus>
            </div>
        </div>


        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="piso">Piso </label>
                <input type="text" class="form-control" name="piso" id="piso"
                    value="{{ $empresa->piso }} " autofocus>
            </div>
        </div>


        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="tipo_responsable">Tipo de responsable </label>
                <input type="text" class="form-control soloNumeros" name="tipo_responsable" id="tipo_responsable"
                     value="{{ $empresa->tipo_responsable }} "min="0" max="1" required >
            </div>
        </div>





        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="cuit">CUIT</label>
                <input type="text" class="form-control soloNumeros" name="cuit" id="cuit"
                    value="{{ $empresa->cuit }} " autofocus  max="99999999999">
            </div>
        </div>



        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="fecha_emision_diario">Última Fecha de emisión diario</label>
                <input type="date" class="form-control " name="fecha_emision_diario" id="fecha_emision_diario"
                    placeholder="Última Fecha de emisión diario" value="{{date_format(date_create_from_format('Y-m-d H:i:s', $empresa->fecha_emision_diario), 'Y-m-d')}}" required
                    autofocus>
            </div>
        </div>



        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="fecha_apertura">Fecha de apartura</label>
                <input type="date" class="form-control " name="fecha_apertura" id="fecha_apertura"
                    placeholder="Fecha de apartura" value="{{date_format(date_create_from_format('Y-m-d H:i:s', $empresa->fecha_apertura), 'Y-m-d')}}" required autofocus>

            </div>
        </div>



        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="fecha_cierre">Fecha de cierre</label>
                <input type="date" class="form-control " name="fecha_cierre" id="fecha_cierre"
                    placeholder="Fecha de cierre" value="{{date_format(date_create_from_format('Y-m-d H:i:s', $empresa->fecha_cierre), 'Y-m-d')}}" required autofocus>

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
            <a type="reset" id="cancel" name="cancel" href="/empresas" class="btn btn-secondary" value="1">CANCELAR</a>
        </div>



    </form>
@endsection













@if (count($errors) > 0)
    <div class="alert alert-danger" style="width: 500px">
        <ul>

            @foreach ($errors->all() as $error)

                <li class="errorMessage">{{ $error }}</li>

            @endforeach

        </ul>
    </div>
@endif
