@extends('welcome')
@section('section')


    <h1 class="display-5 text-center" style="color: blue">Vista completa de los asientos</h1>

    <div class="container p-4">
        {{-- <a href="{{ route('asientos.pdf') }}" class="botonPDF" title="Descarga listado vertical de asientos PDF">
            <i class="far fa-file-pdf fa-3x " style="color: black;"></i>
        </a> --}}
        <a href="{{ route('asientosH.pdf') }}" class="botonPDF" title="Descarga listado horizontal de asientos PDF">
            <i class="far fa-file-pdf fa-3x " style="color: black;"></i>
        </a>
        {{-- <a href="{{ route('asientosP.pdf') }}" class="botonPDF" title="Descarga listado prueba de asientos PDF">
            <i class="far fa-file-pdf fa-3x " style="color: black;"></i>
        </a> --}}
        {{-- <a href="{{ route('asientos.xlsx') }}" class="botonPDF" title="Descarga listado de asientos XLSX">
            <i class="far fa-file-excel fa-3x " style="color: black;"></i>
        </a> --}}
    </div>
    <form action="/asientosDH" method="POST">
        @csrf
        <div class="mb-3 row">
            <div class=" col-md-2">
                <script type="text/javascript">
                    // guardar datos
                    localStorage.setItem("fecha_desde", "fecha_desde");
                </script>
                <label for="fecha_desde" style="font-size: 20px;">Fecha desde:</label>
                <input type="date" class="form-control" name="fecha_desde" value=" {{ old('fecha_desde') }} "
                    id="fecha_desde" placeholder="Fecha" required>
            </div>
            <div class=" col-md-2">
                <script type="text/javascript">
                    // guardar datos
                    localStorage.setItem("fecha_hasta", "fecha_hasta");
                </script>
                <label for="fecha_hasta" style="font-size: 20px;">Fecha hasta:</label>
                <input type="date" class="form-control" name="fecha_hasta" value=" {{ old('fecha_hasta') }} "
                    id="fecha_hasta" placeholder="Fecha" required>
            </div>
        </div>
        <button style="margin: 10px" type="submit" class="btn btn-success">Generar listado DESDE/HASTA</button>
    </form>





    {{-- <br>
    <br>
    <br> --}}
    <div class="container p-4">
        <div class="" style=" display:flex; justify-content: center; overflow: scroll; height:700px;">
            <table class="table table-bordered" id="TablaVerCliente">
                <thead>
                    <tr class="text-center ">
                        <th class="text-center  tdNombre">ID</th>
                        <th class="text-center  tdNombre">Fecha</th>
                        <th class="text-center  tdNombre">Tipo de asiento</th>
                        <th class="text-center  tdNombre">Registrado</th>
                        <th class="text-center  tdNombre">Carga</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($asientos as $asiento)
                        <tr>
                            <td class="text-center">{{ $asiento->id }}</td>
                            <td class="text-center">
                                {{ date_format(date_create_from_format('Y-m-d H:i:s', $asiento->fecha), 'd-m-y') }}
                            </td>
                            @if ($asiento->tipo_asiento == 1)
                                <td class="text-center">Apertura</td>
                            @elseif ($asiento->tipo_asiento == 5)
                                <td class="text-center">Normal</td>
                            @elseif ($asiento->tipo_asiento == 9)
                                <td class="text-center">Cierre</td>
                            @endif

                            @if ($asiento->registrado == 0)
                                <td class="text-center">No</td>
                            @else
                                <td class="text-center">Sí</td>
                            @endif
                            @if ($asiento->ok_carga == 0)
                                <td class="text-center">Mal cargado</td>
                            @else
                                <td class="text-center">Bien cargado</td>
                            @endif
                        </tr>
                    @endforeach



                </tbody>
            </table>
        </div>
    </div>


@endsection
