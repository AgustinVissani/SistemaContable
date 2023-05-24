@extends('welcome')
@section('section')
    <form action="altaplanCuenta" method="POST" onsubmit="return validacion()">
        @csrf
        <div class="container text-center ">
            <h1 class="text-center h1tablaCliente">Alta registro en Plan de cuentas</h1>
        </div>

        <script>
            var campo = $('#id_del_input').val();
        </script>


        <div class="mb-3 row">
            <div class=" col-md-2">
                <label for="codigo">Código</label>
                <label class="sr-only">Código</label>
                <input type="number" class="form-control" name="codigo" value=" {{ old('codigo') }} " id="codigo"
                    placeholder="Código" onkeyup="setCodigo()">

            </div>
            <div class=" col-md-3">
                <label for="id_nivel">Nivel</label>
                <select name="id_nivel" id="id_nivel" class="form-control" onchange="setAgregarenNivelUno()">
                    @foreach ($planCuentas as $plan)
                        @if ($plan->id == 1)
                            <option value="{{ $plan->prefijo }}{{ $plan->sufijo }}">-- {{ $plan->nombre }} --
                            </option>
                        @else
                            <option value="{{ $plan->prefijo }}{{ $plan->sufijo }}">{{ $plan->id }} -
                                {{ $plan->prefijo }}{{ $plan->sufijo }} - {{ $plan->nombre }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <label hidden id="noCodigo">No se encontraron resultados</label>
            </div>
            <div class="col-md-4">
                <label for="sufijo">Número</label>
                <input type="number" class="form-control soloNumeros" name="sufijo" value=" {{ old('sufijo') }} "
                    id="sufijo" placeholder="Número" min="01" max="99" required>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-3">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" value=" {{ old('nombre') }} " id="nombre" placeholder="Nombre" required>
            </div>
        </div>

        <div class="mb-3 row">
            <div class=" col-md-4">
                <div class="form-group form-check">
                    <input disabled style="width:20px; height:20px;" type="checkbox" class="form-check-input;" id="imp"
                        name="imp" value=" {{ old('imp') }} ">
                    <label class="form-check-label" for="imp" style="font-size: 20px;">Imputable</label>
                </div>
            </div>
        </div>



        <!-- <div class="mb-3 row">
                    <div class=" col-md-4">
                        <label for="nivel">Nivel</label>
                        <label class="sr-only">Nivel</label>
                        <input type="text" class="form-control" name="nivel" value=" {{ old('nivel') }} " id="nivel"
                            placeholder="nivel" required>
                    </div>
                </div> -->

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


            <a  type="reset" id="cancel" name="cancel" href="/planCuentas"  class="btn btn-secondary" value="1">CANCELAR</a>
        </div>


    </form>
@endsection
