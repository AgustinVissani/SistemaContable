@extends('welcome')
@section('section')



    <form action="altaEmpresa" method="POST">
        @csrf
        <div class="container text-center ">

            <h1 class="text-center h1tablaCliente">Alta Empresa</h1>

        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="nombre">Nombre de la empresa </label>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="empresa"
                    value=" {{ old('nombre') }} " required autofocus>
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
                <input type="number" class="form-control" name="cp" id="cp" placeholder="Código Postal"
                    value=" {{ old('cp') }} " autofocus>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="id_localidad">Localidad </label>
                <input type="text" class="form-control" name="id_localidad" id="id_localidad" placeholder="Localidad"
                    value=" {{ old('id_localidad') }} " autofocus>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="calle">Calle </label>
                <input type="text" class="form-control" name="calle" id="calle" placeholder="Calle"
                    value=" {{ old('calle') }} " autofocus>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="numero">Número </label>
                <input type="text" class="form-control" name="numero" id="numero" placeholder="Número"
                    value=" {{ old('numero') }} " autofocus>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="piso">Piso </label>
                <input type="text" class="form-control" name="piso" id="piso" placeholder="Piso"
                    value=" {{ old('piso') }} " autofocus>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="tipo_responsable">Tipo de responsable </label>
                <input type="number" class="form-control" name="tipo_responsable" id="tipo_responsable"
                    placeholder="Tipo de responsable" value=" {{ old('tipo_responsable') }} "min="0" max="1" required autofocus>
            </div>
        </div>


        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="cuit">CUIT</label>
                <input type="number" class="form-control soloNumeros" name="cuit" id="cuit" placeholder="CUIT"
                    value=" {{ old('cuit') }} " autofocus  max="99999999999">
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="fecha_emision_diario">Última Fecha de emisión diario</label>
                <input type="date" class="form-control " name="fecha_emision_diario" id="fecha_emision_diario"
                    placeholder="Última Fecha de emisión diario" value=" {{ old('fecha_emision_diario') }} " required autofocus>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="fecha_apertura">Fecha de apartura</label>
                <input type="date" class="form-control " name="fecha_apertura" id="fecha_apertura"
                    placeholder="Fecha de apartura" value=" {{ old('fecha_apertura') }} " required autofocus>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <label for="fecha_cierre">Fecha de cierre</label>
                <input type="date" class="form-control " name="fecha_cierre" id="fecha_cierre"
                    placeholder="Fecha de cierre" value=" {{ old('fecha_cierre') }} " required autofocus>
            </div>
        </div>










        {{-- {{-- AGREGAAAR SUCURSAL Y SECCION

            <div class="mb-3 row">
            <div class=" col-md-12">
                <label for="Sucursal">Sucursal</label>
                <select name="sucursal" id="sucursal" class="form-control" required>
                    @foreach ($sucursales as $sucursal)
                        <option value="{{ $sucursal->id }}">{{ $sucursal->suc_denominacion }}-{{ $sucursal->suc_domicilio }}</option>
                    @endforeach
                </select>
            </div>

            <div class=" col-md-3 my-4">
                <label for="suc_id">Agregar Sucursal</label>
                <a type="button" href="/sucural" title="Agregar Sucursal" class="btn btn-outline-success"><i
                        style="color: black" class="fas fa-plus"></i></a>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-12">
                <label for="Seccion">Sección</label>
                <select name="seccion" id="seccion" class="form-control" required>
                    @foreach ($secciones as $seccion)
                        <option value="{{ $seccion->id }}">{{ $seccion->suc_denominacion }}</option>
                    @endforeach
                </select>
            </div>

            <div class=" col-md-3 my-4">
                <label for="suc_id">Agregar Sección</label>
                <a type="button" href="/seccion" title="Agregar Sección" class="btn btn-outline-success"><i
                        style="color: black" class="fas fa-plus"></i></a>
            </div>
        </div> --}}




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

            <a  type="reset" id="cancel" name="cancel" href="/empresas"  class="btn btn-secondary" value="1">CANCELAR</a>
        </div>



    </form>
@endsection
