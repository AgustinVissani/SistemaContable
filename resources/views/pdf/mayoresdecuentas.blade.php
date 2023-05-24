<!DOCTYPE html>
<html lang="es">


<style>
    .tablePDF {
        font-size: 10px;
        text-align: left;

        width: 100%;
        /*  border: 1px solid #999999; */
    }

</style>

<style>
    .page-break {
        page-break-after: always;
        margin-top: 90px;
        padding: 100px;
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



<body>
    <header>
        <h3 class="text-left ">Sistema de Contabilidad - EMPRESA:
            '{{ $datosempresa[0]->nombrepila }}'</h3>
        <h4 class="text-left ">Fecha desde: {{ $fechadesde }} - Fecha hasta: {{ $fechahasta }}</h4>
        <script type="text/php">

            if ( isset($pdf) ) {
                    $pdf->page_script('
                                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                                $pdf->text(600, 20, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 12);
                      ');
                    }
                      </script>
        <br>
    </header>
    <main>
        <br>
        <h1 style="text-align: center;">Mayores de Cuentas </h1>
        {{-- <a style="visibility: hidden"> {{ $saldo = 0 }}</a> --}}
        <table class="tablePDF">

            <tr class="text-left ">
                <th class="text-left "
                    style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;  border-left-style: solid; ">
                    ID Asiento</th>
                <th class="text-left "
                    style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">ID Renglon</th>
                <th class="text-left "
                    style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;"></th>
                <th class="text-left  "
                    style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">F.Op</th>
                <th class="text-left  "
                    style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">F.vto</th>
                <th class="text-left  "
                    style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">Compro</th>
                <th class="text-left  "
                    style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">SU</th>
                <th class="text-left  "
                    style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">SE</th>
                <th class="text-left  "
                    style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">Leyenda</th>
                <th class="text-left  "
                    style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">Debitos</th>
                <th class="text-left  "
                    style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">Creditos</th>
                <th class="text-left  "
                    style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;  border-right-style: solid; ">
                    Saldo</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($cuentas as $cuenta)
                    @if (isset($datosCuenta))
                        {{ $saldo = $datosCuenta[$cuenta->IdCuenta]['saldo'] }}
                    @else
                        {{ $saldo = 0 }}
                    @endif
                    @php
                        $debitosTotales = 0;
                        $creditosTotales = 0;
                    @endphp
                    <tr>
                        <th class="text-left  tdNombre">ID Cuenta</th>
                        <th class="text-left  tdNombre">Nombre de la cuenta</th>
                        <th class="text-left  tdNombre">Codigo Plan de Cuentas</th>
                    </tr>
                    <tr>
                        <td class="text-left" style="border: 0.3px solid #000000">{{ $cuenta->IdCuenta }}</td>
                        <td class="text-left" style="border: 0.3px solid #0000000">{{ $cuenta->NombreCuenta }}
                        </td>
                        <td class="text-left" style="border: 0.3px solid #000000">{{ $cuenta->CodigoCuenta }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left">
                        </td>

                        <td>
                        </td>

                        <td class="text-left">
                        </td>

                        <td class="text-left">
                            {{ $fechadesde }} </td>

                        <td class="text-left">
                            {{ $fechahasta }}
                        </td>

                        <td class="text-left">
                        </td>


                        <td class="text-left">
                        </td>

                        <td class="text-left">
                        </td>


                        <td class="text-left">
                            @if (isset($datosCuenta))
                                {{ $datosCuenta[$cuenta->IdCuenta]['leyenda'] }}
                            @endif

                        </td>

                        <td class="text-left">
                            @if (isset($datosCuenta))
                                {{ sprintf('%.2f', $datosCuenta[$cuenta->IdCuenta]['debitos']) }}
                            @endif
                        </td>

                        <td class="text-left">
                            @if (isset($datosCuenta))
                                {{ sprintf('%.2f', $datosCuenta[$cuenta->IdCuenta]['creditos']) }}
                            @endif
                        </td>

                        <td class="text-left" style="border: 0.3px solid #000000">
                            @if (isset($datosCuenta))
                                {{ sprintf('%.2f', $datosCuenta[$cuenta->IdCuenta]['saldo']) }}
                            @else
                                {{ sprintf('%.2f', $saldo )}}
                            @endif
                        </td>
                    </tr>
                    @foreach ($RenglonesDiario_Mayor as $RenglonDiario_Mayor)
                        @if ($RenglonDiario_Mayor->id_cuenta == $cuenta->IdCuenta)

                            <tr>

                                <td class="text-left">
                                    {{ $RenglonDiario_Mayor->id_asiento }}

                                </td>

                                <td>
                                    {{ $RenglonDiario_Mayor->id }}

                                </td>

                                <td class="text-left">

                                    {{ $RenglonDiario_Mayor->CodigoCuenta }}
                                    {{ $RenglonDiario_Mayor->NombreCuenta }}</p>
                                </td>
                                <td class="text-left">

                                    {{ date_format(date_create_from_format('Y-m-d H:i:s', $RenglonDiario_Mayor->fecha_oper), 'd-m-y') }}</a>
                                </td>

                                <td class="text-left">
                                    {{ date_format(date_create_from_format('Y-m-d H:i:s', $RenglonDiario_Mayor->fecha_vencimiento), 'd-m-y') }}
                                </td>

                                <td class="text-left">
                                    {{ $RenglonDiario_Mayor->comprobante }}
                                </td>


                                <td class="text-left">
                                    {{ $RenglonDiario_Mayor->sucursal }}
                                </td>

                                <td class="text-left">
                                    {{ $RenglonDiario_Mayor->seccion }}
                                </td>


                                <td class="text-left">
                                    {{ $RenglonDiario_Mayor->leyenda }}</a>
                                </td>
                                @if ($RenglonDiario_Mayor->debe_haber == 0)
                                    <td class="text-left">
                                        {{ sprintf('%.2f', $RenglonDiario_Mayor->importe) }}
                                        {{-- <a style="visibility: hidden">
                                            </a> --}}
                                        @php
                                            $saldo += $RenglonDiario_Mayor->importe;
                                            $debitosTotales += $RenglonDiario_Mayor->importe;
                                        @endphp

                                    </td>
                                    <td class="text-left">

                                    </td>
                                @else
                                    <td class="text-left">

                                    </td class="text-left">
                                    <td>
                                        {{ sprintf('%.2f', $RenglonDiario_Mayor->importe) }}
                                        {{-- <a
                                            style="visibility: hidden"></a> --}}

                                        @php
                                            $saldo -= $RenglonDiario_Mayor->importe;
                                            $creditosTotales += $RenglonDiario_Mayor->importe;
                                        @endphp
                                    </td>
                                @endif
                                <td class="text-left" style="border: 0.3px solid #000000">
                                    {{ sprintf('%.2f', $saldo) }}
                                </td>
                            </tr>


                        @endif
                        {{-- end del for renglon --}}
                    @endforeach
                    <tr>
                        <td class="text-left">
                        </td>

                        <td>
                        </td>

                        <td class="text-left">
                        </td>

                        <td class="text-left">
                            {{ $fechadesde }} </td>

                        <td class="text-left">
                            {{ $fechahasta }}
                        </td>

                        <td class="text-left">
                        </td>


                        <td class="text-left">
                        </td>

                        <td class="text-left">
                        </td>


                        <td class="text-left">
                            SUBTOTALES DEL PERÍODO
                        </td>

                        <td class="text-left">
                            {{ sprintf('%.2f', $debitosTotales) }}
                        </td>

                        <td class="text-left">
                            {{ sprintf('%.2f', $creditosTotales) }}
                        </td>

                        <td class="text-left" style="border: 0.3px solid #000000">
                            {{ sprintf('%.2f', $debitosTotales - $creditosTotales) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left">
                        </td>

                        <td>
                        </td>

                        <td class="text-left">
                        </td>

                        <td class="text-left">
                            {{ $fechadesde }} </td>

                        <td class="text-left">
                            {{ $fechahasta }}
                        </td>

                        <td class="text-left">
                        </td>


                        <td class="text-left">
                        </td>

                        <td class="text-left">
                        </td>


                        <td class="text-left">
                            TOTALES DEL PERÍODO
                        </td>

                        <td class="text-left">
                            @if (isset($datosCuenta))
                                {{ sprintf('%.2f', $datosCuenta[$cuenta->IdCuenta]['debitos'] + $debitosTotales) }}
                            @else
                                {{ sprintf('%.2f', $debitosTotales) }}
                            @endif
                        </td>

                        <td class="text-left">
                            @if (isset($datosCuenta))
                                {{  sprintf('%.2f', $datosCuenta[$cuenta->IdCuenta]['creditos'] + $creditosTotales) }}
                            @else
                                {{ sprintf('%.2f', $creditosTotales) }}
                            @endif
                        </td>

                        <td class="text-left" style="border: 0.3px solid #000000">
                            {{ sprintf('%.2f', $saldo) }}
                        </td>
                    </tr>
                    {{-- end del for cuenta --}}
                @endforeach



            </tbody>
        </table>




    </main>

</body>

</html>
