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
        <br>
    </header>
    <main>
        <div>
            <table class="tablePDF table-bordered">


                <tr class="text-left">
                    <th class="text-left "
                        style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;  border-left-style: solid; ">
                        ID Asiento</th>
                    <th class="text-left"
                        style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">ID Renglon
                    </th>
                    <th class="text-left "
                        style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">CÓDIGO /
                        NOMBRE Cuenta</th>
                    <th class="text-left  "
                        style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">F.Op</th>
                    <th class="text-left  "
                        style="border:  0.3px #000000;border-top-style: solid; border-bottom-style:solid;">F.vto</th>
                    <th class="text-left  "
                        style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">Compro</th>
                    <th class="text-left  "
                        style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">SU</th>
                    <th class="text-left  "
                        style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">SE</th>
                    <th class="text-left  "
                        style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">Leyenda</th>
                    <th class="text-left  "
                        style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">Debe</th>
                    <th class="text-left  "
                        style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;  border-right-style: solid; ">
                        Haber</th>
                </tr>
                <thead>

                </thead>
                <tbody>
                    @foreach ($asientos as $asiento)

                    <tr class="text-left">
                        <th class="text-left"  style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;  border-left-style: solid; " >ID</th>
                        <th class="text-left"  style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">Fecha del asiento</th>
                        <th class="text-left"  style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">Tipo de asiento</th>
                        <th class="text-left"  style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;">Registrado</th>
                        <th class="text-left" style="border: 0.3px #000000;border-top-style: solid; border-bottom-style:solid;  border-right-style: solid; " >Carga</th>

                    </tr>

                        <tr>
                            <td class="text-left">{{ $asiento->id }}</td>

                            <td class="text-left">
                                {{ date_format(date_create_from_format('Y-m-d H:i:s', $asiento->fecha), 'd-m-y') }}
                            </td>
                            @if ($asiento->tipo_asiento == 1)
                                <td class="text-left">Apertura</td>
                            @elseif ($asiento->tipo_asiento == 5)
                                <td class="text-left">Normal</td>
                            @elseif ($asiento->tipo_asiento == 9)
                                <td class="text-left">Cierre</td>
                            @endif
                            @if ($asiento->registrado == 0)
                                <td class="text-left">No</td>
                            @else
                                <td class="text-left">Sí</td>
                            @endif
                            @if ($asiento->ok_carga == 0)
                                <td class="text-left">Mal cargado</td>
                            @else
                                <td class="text-left">Bien cargado</td>
                            @endif
                        </tr>

                        @foreach ($renglones as $renglon)
                            @if ($renglon->id_asiento == $asiento->id)


                                <tr>
                                    <td>
                                        {{ $asiento->id }}

                                    </td>

                                    <td>
                                        {{ $renglon->id }}
                                    </td>

                                    <td>
                                        {{ $renglon->CodigoCuenta }} {{ $renglon->NombreCuenta }}</a>
                                    </td>
                                    <td>

                                        {{ date_format(date_create_from_format('Y-m-d H:i:s', $renglon->fecha_oper), 'd-m-y') }}</a>
                                    </td>

                                    <td>
                                        {{ date_format(date_create_from_format('Y-m-d H:i:s', $renglon->fecha_vencimiento), 'd-m-y') }}
                                    </td>

                                    <td>
                                        {{ $renglon->comprobante }}</a>
                                    </td>


                                    <td>
                                        {{ $renglon->sucursal }}
                                    </td>

                                    <td>
                                        {{ $renglon->seccion }}
                                    </td>


                                    <td>
                                        {{ $renglon->leyenda }}</a>
                                    </td>

                                    @if ($renglon->debe_haber == 0)
                                        <td >
                                            <a href="#" class="xedit"
                                                data-pk="{{ $renglon->id }}-{{ $asiento->id }}"
                                                data-name="importe">
                                                {{ sprintf('%.2f', $renglon->importe) }}</a>
                                        </td>
                                        <td>
                                            <a href="#" class="xedit"
                                                data-pk="{{ $renglon->id }}-{{ $asiento->id }}"
                                                data-name="importe">
                                            </a>
                                        </td>

                                    @else
                                        <td>
                                            <a href="#" class="xedit"
                                                data-pk="{{ $renglon->id }}-{{ $asiento->id }}"
                                                data-name="importe">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" class="xedit"
                                                data-pk="{{ $renglon->id }}-{{ $asiento->id }}"
                                                data-name="importe">
                                                {{ sprintf('%.2f', $renglon->importe) }}</a>
                                        </td>
                                    @endif
                                    {{-- end del for renglon --}}


                            @endif
                        @endforeach
                        {{-- end del for asiento --}}

                    @endforeach


                    {{-- <script type="text/php">
                    if (isset($pdf))
                      {
                        $font = Font_Metrics::get_font("Arial", "bold");
                        $pdf->page_text(765, 550, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 9, array(0, 0, 0));
                      }
                  </script> --}}




                </tbody>
            </table>
        </div>

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
