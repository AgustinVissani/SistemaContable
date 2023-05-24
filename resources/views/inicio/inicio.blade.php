<div class="fondoInicio">
    @extends('welcome')
    @section('section')
            <h1 class=" text-center h1tablaProvincia">PRACTICAS PROFESIONALES</h1>
            <h1 class="text-center" style="color: white">EMPRESAS</h1>

            <div class="container">
                <div class=" col-md-3 my-4 botonPDF">
                    <label style="color: white" for="id">Agregar Empresa</label>
                    <a type="button" href="/empresas" title="Agregar empresa" class="btn btn-outline-success"><i
                            style="color: rgb(255, 255, 255)" class="fas fa-plus"></i></a>
                </div>
            </div>

        <form action="seleccionEmpresa" method="POST" onsubmit="return validacion()">
          @csrf



            <div class="container">
                <div class=" col-md-3">
                    <label style="color: white; " for="nombreEmpresa">Nombres de las empresas a trabajar</label>
                    <select name="nombreEmpresa" id="nombreEmpresa" class="form-control" required>
                        @foreach ($empresas as $empresa)
                            <option value="{{ $empresa->nombre }}">{{ $empresa->nombrepila }}</option>
                        @endforeach
                    </select>
                </div>
                <div class=" col-md-3">




        @if (count($errors) > 0)

            <ul>

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        @endif

        <button style="margin: 10px" type="submit" class="btn btn-primary">INGRESAR</button>
        </form>

@endsection
