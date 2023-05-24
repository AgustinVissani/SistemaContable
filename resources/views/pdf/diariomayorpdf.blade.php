<!DOCTYPE html>
<html lang="es">


<style>
    .tablePDF {
        text-align: left;
        width: 100%;
        border: 1px solid #999999;

    }

</style>

<style>
    .page-break {
        page-break-after: always;
    }

</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 90px;

            /** Extra personal styles **/
            /* background-color: #ffffff; */
            color: rgb(0, 0, 0);
            text-align: left;
            border: 1px solid #999999;
        }

        body {
            margin-top: 1cm;
            /* margin-left: 2cm;
                margin-right: 2cm; */
            margin-bottom: 2cm;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            color: rgb(0, 0, 0);
            text-align: left;
            line-height: 35px;
        }

    </style>



</head>
<a style="visibility: hidden"> {{ $totalDebe = 0 }}</a>
<a style="visibility: hidden"> {{ $totalHaber = 0 }}}</a>


<body>
    <header>
        <h5 class="text-lef">Sistema de Contabilidad - EMPRESA:
            '{{ $datosempresa[0]->nombrepila }}'</h5>
        <h5 class="text-lef">Fecha de cierre del ejercicio:
            {{ date_format(date_create_from_format('Y-m-d H:i:s', $datosempresa[0]->fecha_cierre), 'd-m-y') }}</h5>
        <script type="text/php">
            if ( isset($pdf) ) {
                                                                                            $pdf->page_script('
                                                                                                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                                                                                                $pdf->text(580, 35, "Folio: $PAGE_NUM", $font, 12);
                                                                                            ');
                                                                                        }

                                                                                </script>
    </header>

    <main>
        <h1>Libro diario</h1>
        <a>TRANSPORTE {{ $totalHaber }} - {{ $totalDebe }}</a>
        <div class="tabla">
            <table class=" tablePDF table-bordered" style="font-size: 12px">

                <tr class="text-left ">
                    <th style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;  border-left-style: solid; "
                        class="text-lef tdNombre">Registro</th>
                    <th style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;"
                        class="text-lef tdNombre">ID Asiento</th>
                    <th style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;"
                        class="text-lef tdNombre">ID Renglon</th>
                    <th style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;"
                        class="text-lef tdNombre">CÓDIGO / NOMBRE Cuenta</th>
                    <th style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;"
                        class="text-lef  tdNombre">F.Op</th>
                    <th style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;"
                        class="text-lef  tdNombre">F.vto</th>
                    <th style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;"
                        class="text-lef  tdNombre">Compro</th>
                    <th style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;"
                        class="text-lef  tdNombre">SU</th>
                    <th style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;"
                        class="text-lef  tdNombre">SE</th>
                    {{-- <th class="text-lef  tdNombre">Leyenda</th> --}}
                    <th style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;"
                        class="text-lef  tdNombre">Debe</th>
                    <th style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;  border-right-style: solid; "
                        class="text-lef  tdNombre">Haber</th>
                    {{-- <th class="text-lef  tdNombre">Total Debe</th>
                <th class="text-lef  tdNombre">Total Haber</th> --}}

                </tr>
                </thead>
                <tbody>

                    <a style="visibility: hidden"> {{ $registro = 0 }}</a>
                    @foreach ($asientosDiario_Mayor as $asientoDiario_Mayor)
                        <tr>
                            <th class="text-left">ID</th>
                            <th class="text-left">Fecha del asiento</th>
                        </tr>
                        <tr>
                            <td class="text-left">{{ $asientoDiario_Mayor->id }}</td>

                            <td class="text-left">
                                {{ date_format(date_create_from_format('Y-m-d H:i:s', $asientoDiario_Mayor->fecha), 'd-m-y') }}
                            </td>

                        </tr>

                        @foreach ($RenglonesDiario_Mayor as $RenglonDiario_Mayor)
                            @if ($RenglonDiario_Mayor->id_asiento == $asientoDiario_Mayor->id)
                                <tr>
                                    {{ $registro = $registro + 1 }}
                                    <td class="text-left">{{ $registro }}</td>

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


                                    {{-- <td>
                                    {{ $RenglonDiario_Mayor->leyenda }}</a>
                                </td> --}}
                                    @if ($RenglonDiario_Mayor->debe_haber == 0)
                                        <td>
                                            {{ sprintf('%.2f', $RenglonDiario_Mayor->importe) }}

                                            <a
                                                style="visibility: hidden">{{ $totalDebe += $RenglonDiario_Mayor->importe }}</a>

                                        </td>
                                        <td>

                                        </td>
                                    @else
                                        <td>

                                        </td>
                                        <td>
                                            {{ sprintf('%.2f', $RenglonDiario_Mayor->importe)  }}
                                            <a
                                                style="visibility: hidden">{{ $totalHaber += $RenglonDiario_Mayor->importe }}</a>


                                        </td>

                                </tr>


                            @endif


                        @endif
                        {{-- end del for renglon --}}

                    @endforeach
                    <tr>
                        <th>
                            <hr>
                        </th>
                        <th>
                            <hr>
                        </th>
                        <th>
                            <hr>
                        </th>
                        <th>
                            <hr>
                        </th>
                        <th>
                            <hr>
                        </th>
                        <th>
                            <hr>
                        </th>
                        <th>
                            <hr>
                        </th>
                        <th>
                            <hr>
                        </th>
                        <th>
                            <hr>
                        </th>
                        <th>
                            <hr>
                        </th>
                        <th>
                            <hr>
                        </th>
                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>


    </main>
    <footer>
        <a>TRANSPORTE: Total debe: {{ sprintf('%.2f', $totalDebe) }} - Total haber: {{ sprintf('%.2f', $totalHaber) }}</a>
        <br>
        <a>Cantidad de registros: {{ $registro }} </a>
        <br>
        @if (isset($asientoDiario_Mayor))
            <a>Último asiento: {{ $asientoDiario_Mayor->id }} </a>
        @else
            {{ $asientoDiario_Mayor = 0 }}
        @endif
        @if (isset($RenglonDiario_Mayor))
            <a>Último renglon: {{ $RenglonDiario_Mayor->id }} </a>
        @else
            {{ $asientoDiario_Mayor = 0 }}
        @endif


    </footer>

</body>



</html>

