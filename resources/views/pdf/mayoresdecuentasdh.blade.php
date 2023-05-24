<!DOCTYPE html>
<html lang="es">


<style>
    .tablePDF {
        font-size: 10px;
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
                    <tr>
                        <th class="text-left  tdNombre">ID Cuenta</th>
                        <th class="text-left  tdNombre">Nombre de la cuenta</th>
                        <th class="text-left  tdNombre">Codigo Plan de Cuentas</th>
                    </tr>
                    <tr>
                        <td class="text-left">{{ $cuenta->IdCuenta }}</td>
                        <td class="text-left">{{ $cuenta->NombreCuenta }}</td>
                        <td class="text-left">{{ $cuenta->CodigoCuenta }}</td>
                    </tr>
                    @foreach ($RenglonesDiario_Mayor as $RenglonDiario_Mayor)
                        @if ($RenglonDiario_Mayor->id_cuenta == $cuenta->IdCuenta)
                            <tr>

                                <td>
                                    {{ $RenglonDiario_Mayor->id_asiento }}

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
                                        {{ sprintf('%.2f', $RenglonDiario_Mayor->importe) }}
                                    </td>
                                    <td>

                                    </td>
                                @else
                                    <td>

                                    </td>
                                    <td>
                                        {{ sprintf('%.2f', $RenglonDiario_Mayor->importe) }}
                                    </td>
                            </tr>
                        @endif

                    @endif
                    {{-- end del for renglon --}}
                @endforeach
                {{-- end del for cuenta --}}
                @endforeach
            </tbody>
        </table>


        <script type="text/php">
            if ( isset($pdf) ) {
                        $pdf->page_script('
                            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                            $pdf->text(370, 570, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
                        ');
                    }
                    </script>

    </main>


</body>

</html>
