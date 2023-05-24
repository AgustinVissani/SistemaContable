@extends('welcome')
@section('section')


    <h1 class="text-center h1tablaProvincia">Tabla DIARIO - MAYOR</h1>
    <p style="font-size: 20px; color: rgb(255, 50, 14)" class="text-center"><em>Ultima fecha de emisión del diario:
            '{{ date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa->fecha_emision_diario), 'd-m-y') }}'
        </em></p>

    <p style="font-size: 20px; color: rgb(255, 50, 14)" class="text-center"><em>Fecha de apertura del ejercicio:
            '{{ date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa->fecha_apertura), 'd-m-y') }}'</em>
    </p>

    <p style="font-size: 20px; color: rgb(255, 50, 14)" class="text-center"><em>Fecha de cierre del ejercicio:
            '{{ date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa->fecha_cierre), 'd-m-y') }}'</em>
    </p>

    <a href="{{ route('diariomayorH.pdf') }}" class="botonPDF" title="Descarga listado libro diario PDF">
        <i class="far fa-file-pdf fa-3x " style="color: black;"></i>
    </a>

    <a href="{{ route('mayoresdecuentas.pdf') }}" class="botonPDF"
        title="Descarga listado horizontal de mayores de cuentas PDF">
        <i class="far fa-file-pdf fa-3x " style="color: black;"></i>
    </a>
    <link rel="stylesheet" href="/css/stylesTablaFija.css">

    {{-- <a href="{{ route('listadoBalance') }}" class="btn btn-success">
        Listar balance
    </a> --}}
    <form action="diariosDH" method="POST">
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
                <input type="date"  class="form-control" name="fecha_hasta"
                 value=" {{ old('fecha_hasta') }} "  onchange="finmes2()" id="fecha_hasta" placeholder="Fecha" required>
                <label style="color: red" hidden id="noFinmes">No es fin de mes</label>
            </div>
        </div>
        <button style="margin: 10px" type="submit" class="btn btn-success">Listado Mayores de cuentas</button>
    </form>

    <br>

    <form action="libroDH" method="POST">
        @csrf
        <div class="mb-3 row">
            <div class=" col-md-2">
                <script type="text/javascript">
                    // guardar datos
                    localStorage.setItem("fecha_hasta2", "fecha_hasta2");
                </script>
                <label for="fecha_hasta2" style="font-size: 20px;">Fecha hasta:</label>
                <input type="date"  class="form-control" name="fecha_hasta2"
                 value=" {{ old('fecha_hasta2') }} "  onchange="finmes3()" id="fecha_hasta2" placeholder="Fecha" required>
                 <label style="color: red" hidden id="noFinmes3">No es fin de mes</label>
            </div>
        </div>
        <button
            onclick="return confirm('Si descarga el libro diario se actualizará la última fecha de emisión del diario: ¿Quiere continuar?')"
            style="margin: 10px" type="submit" class="btn btn-success">Listado libro diario</button>
    </form>


    <div class="tabla">
        <div class="container">
            <table class="table  table-bordered" id="MyTable">
                <thead>
                    <tr class="text-center ">
                        {{-- 'id_cuenta' => $cuentas[$countCuentas]->id,
                'codigo' => $cuentas[$countCuentas]->codigo,
                'prefijo' => $cuentas[$countCuentas]->prefijo,
                'sufijo' => $cuentas[$countCuentas]->sufijo,
                'nombre' => $cuentas[$countCuentas]->nombre,
                'nivel' => $cuentas[$countCuentas]->nivel,
                'debitos' => $debe,
                'creditos' => $haber,
                'saldo_inicial' => $saldoInicial,
                'saldo_acumulado' => $saldoAcumulado,
                'saldo_cierre' => $saldoCierre, --}}
                        <th class="sticky-column ">ID Asiento</th>
                        <th class="sticky-column">ID Renglon</th>
                        <th class="sticky-column">CÓDIGO / NOMBRE Cuenta</th>
                        <th class="sticky-column">F.Op</th>
                        <th class="sticky-column">F.vto</th>
                        <th class="sticky-column">Compro</th>
                        <th class="sticky-column">SU</th>
                        <th class="sticky-column">SE</th>
                        <th class="sticky-column">Leyenda</th>
                        <th class="sticky-column">Debe</th>
                        <th class="sticky-column">Haber</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($asientosDiario_Mayor as $asientoDiario_Mayor)
                        <tr>
                            <th class="text-center  tdNombre">ID</th>
                            <th class="text-center  tdNombre">Fecha del asiento</th>
                            <th class="text-center  tdNombre">Tipo de asiento</th>
                            <th class="text-center  tdNombre">Registrado</th>
                            <th class="text-center  tdNombre">Carga</th>
                        </tr>
                        <tr>
                            <td class="text-center">{{ $asientoDiario_Mayor->id }}</td>

                            <td class="text-center">
                                {{ date_format(date_create_from_format('Y-m-d H:i:s', $asientoDiario_Mayor->fecha), 'd-m-y') }}
                            </td>
                            @if ($asientoDiario_Mayor->tipo_asiento == 1)
                                <td class="text-center">Apertura</td>
                            @elseif ($asientoDiario_Mayor->tipo_asiento == 5)
                                <td class="text-center">Normal</td>
                            @elseif ($asientoDiario_Mayor->tipo_asiento == 9)
                                <td class="text-center">Cierre</td>
                            @endif
                            @if ($asientoDiario_Mayor->registrado == 0)
                                <td class="text-center">No</td>
                            @else
                                <td class="text-center">Sí</td>
                            @endif
                            @if ($asientoDiario_Mayor->ok_carga == 0)
                                <td class="text-center">Mal cargado</td>
                            @else
                                <td class="text-center">Bien cargado</td>
                            @endif
                        </tr>
                        @foreach ($RenglonesDiario_Mayor as $RenglonDiario_Mayor)
                            @if ($RenglonDiario_Mayor->id_asiento == $asientoDiario_Mayor->id)
                                <tr>

                                    <td>
                                        {{ $asientoDiario_Mayor->id }}

                                    </td>

                                    <td>
                                        {{ $RenglonDiario_Mayor->id }}
                                    </td>

                                    <td>
                                        {{ $RenglonDiario_Mayor->CodigoCuenta }}
                                        {{ $RenglonDiario_Mayor->NombreCuenta }}</a>
                                    </td>
                                    <td>

                                        {{ date_format(date_create_from_format('Y-m-d H:i:s', $RenglonDiario_Mayor->fecha_oper), 'd-m-y') }}</a>
                                    </td>

                                    <td>
                                        {{ date_format(date_create_from_format('Y-m-d H:i:s', $RenglonDiario_Mayor->fecha_vencimiento), 'd-m-y') }}
                                    </td>

                                    <td>
                                        {{ $RenglonDiario_Mayor->comprobante }}</a>
                                    </td>


                                    <td>
                                        {{ $RenglonDiario_Mayor->sucursal }}
                                    </td>

                                    <td>
                                        {{ $RenglonDiario_Mayor->seccion }}
                                    </td>


                                    <td>
                                        {{ $RenglonDiario_Mayor->leyenda }}</a>
                                    </td>
                                    @if ($RenglonDiario_Mayor->debe_haber == 0)
                                        <td>
                                            {{sprintf('%.2f',  $RenglonDiario_Mayor->importe )}}
                                        </td>
                                        <td>

                                        </td>
                                    @else
                                        <td>

                                        </td>
                                        <td>
                                            {{sprintf('%.2f',  $RenglonDiario_Mayor->importe) }}
                                        </td>
                                </tr>
                            @endif

                        @endif
                        {{-- end del for renglon --}}
                    @endforeach
                    {{-- end del for asiento --}}
                    @endforeach
                </tbody>
                <br>
            </table>

            <br>
            <br>
            <br>
        </div>


        {{-- <td class="text-center">
            <a href="verClientes/" class="btn btn-link botonLink">
                <span aria-hidden="true"></span>Generar listados
            </a>
        </td> --}}

    </div>


@endsection
