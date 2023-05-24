@extends('welcome')
@section('section')
    <form action="altaAsientos" method="POST" onsubmit="return validacion()">
        @csrf

        <div class="container text-center ">
            <h1 class="text-center h1tablaCliente">CARGA DE ASIENTOS</h1>

            <p style="font-size: 20px; color: rgb(255, 50, 14)" class="text-center"><em>Ultima fecha de emisión del
                    diario:
                    '{{ date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa->fecha_emision_diario), 'd-m-y') }}'
                </em></p>

            <p style="font-size: 20px; color: rgb(255, 50, 14)" class="text-center"><em>Fecha de apertura del ejercicio:
                    '{{ date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa->fecha_apertura), 'd-m-y') }}'</em>
            </p>

            <p style="font-size: 20px; color: rgb(255, 50, 14)" class="text-center"><em>Fecha de cierre del ejercicio:
                    '{{ date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa->fecha_cierre), 'd-m-y') }}'</em>
            </p>



        </div>




        <div class="mb-3 row">
            <div class=" col-md-2">
                <script type="text/javascript">
                    // guardar datos
                    localStorage.setItem("fecha_asiento", "fecha_asiento");
                </script>
                <label for="fecha_asiento" style="font-size: 20px;">Fecha del asiento:</label>
                <input type="date"
                {{-- onchange="setTipo_asiento('2021-10-12','2021-10-12','2021-10-12')" --}}
                oninput="finmes()"
                onchange="setTipo_asiento('{{date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa->fecha_apertura), 'Y-m-d')}}', '{{date_format(date_create_from_format('Y-m-d H:i:s',$datosempresa->fecha_cierre), 'Y-m-d')}}', '{{date_format(date_create_from_format('Y-m-d H:i:s',$datosempresa->fecha_emision_diario), 'Y-m-d')}}')"

                    class="form-control" name="fecha_asiento" id="fecha_asiento" placeholder="Fecha" required>
                {{-- <input type="date" onchange="setTipo_asiento(({{$datosempresa->fecha_cierre}}, {{$datosempresa->fecha_apertura}}, {{$datosempresa->fecha_emision_diario}}))" class="form-control" name="fecha_asiento"
                    value="{{ old('fecha_asiento') }}" id="fecha_asiento" placeholder="Fecha" required> --}}
                <label hidden id="noFinmes" style="color: red; font-size: 16px">No es fin de mes</label>
            </div>


            <div class="col-md-2">
                <label for="tipo_asiento" style="font-size: 20px;">Tipo de asiento</label>

                <select name="tipo_asiento" id="tipo_asiento" class="form-control" required>
                    <option value="1"> 1: Apertura</option>
                    <option value="5"> 5: Normal</option>
                    <option value="9"> 9: Cierre</option>

                </select>
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
            <button style="margin: 10px" type="submit" class="btn btn-primary">Agregar Renglones</button>


            {{-- <button type="reset" id="cancel" name="cancel" class="btn btn-secondary" value="1">CANCELAR</button> --}}
        </div>


    </form>

    <a class="btn btn-success" data-title='Guardar Asiento' data-toggle="modal" data-target="#modalRegistrar">Registrar
        Asientos por fecha</a>

    <table class="table  table-bordered" id="MyTable">
        <thead>
            <tr class="text-center ">
                <th class="text-center  tdNombre">ID</th>
                <th class="text-center  tdNombre">Fecha del asiento</th>
                <th class="text-center  tdNombre">Tipo de asiento</th>
                <th class="text-center  tdNombre">Registrado</th>
                <th class="text-center  tdNombre">Carga</th>
                <th class="text-center  tdNombre">Registrar</th>
                <th class="text-center tdNombre">Editar</th>
                <th class="text-center tdNombre">Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asientos as $asiento)
                <tr>
                    <td class="text-center">{{ $asiento->id }}</td>

                    <td class="text-center">
                        {{ date_format(date_create_from_format('Y-m-d H:i:s', $asiento->fecha), 'd-m-y') }}</td>
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


                    <td class="text-center">
                        <form method="POST" action="registrarAsiento/{{ $asiento->id }}">
                            @csrf
                            <button class="btn btn-info btn-xs " type="submit"
                                onclick="return confirm('¿Seguro quiere registrar?')">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true">REGISTRAR
                            </button>
                        </form>
                    </td>


                    <td class="text-center">

                        <a href="renglones/{{ $asiento->id }}" class="btn btn-success btn-xs">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>EDITAR
                        </a>
                    </td>

                    <td class="text-center">
                        <form method="POST" action="deleteAsiento/{{ $asiento->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-xs " type="submit"
                                onclick="return confirm('¿Seguro quiere eliminar?')">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true">ELIMINAR
                            </button>
                        </form>
                    </td>

            @endforeach
            </tr>
        </tbody>
    </table>
    <td class="text-center">
        <a href="verAsientos/" class="btn btn-link botonLink">
            <span aria-hidden="true"></span>Generar listados
        </a>
    </td>



    <div class="modal " tabindex="-1" id="modalRegistrar" data-keyboard="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Asientos por fecha</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="registrarDH" method="POST">
                        @csrf
                        <div class="mb-6 row">
                            <div class=" col-md-5">
                                <label for="fecha_desde" style="font-size: 20px;">Fecha desde:</label>
                                <input type="date" class="form-control" name="fecha_desde"
                                    value=" {{ old('fecha_desde') }} " id="fecha_desde" placeholder="Fecha" required>
                            </div>
                            <div class=" col-md-5">
                                <label for="fecha_hasta" style="font-size: 20px;">Fecha hasta:</label>
                                <input type="date" class="form-control" name="fecha_hasta"
                                    value=" {{ old('fecha_hasta') }} " id="fecha_hasta" placeholder="Fecha" required>
                            </div>
                        </div>
                        <button style="margin: 10px" type="submit" class="btn btn-success">Registrar asiento
                            DESDE/HASTA</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


@endsection
