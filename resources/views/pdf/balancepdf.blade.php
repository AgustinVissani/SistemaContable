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
    <h1>Balance Completo Detallado</h1>
    <header>
        <h3 class="text-left ">Sistema de Contabilidad - EMPRESA:
            '{{ $datosempresa[0]->nombrepila }}'</h3>
            <h5>Fecha desde: {{ $fechadesde }} - fecha hasta: {{ $fechahasta }}</h5>
    </header>
    <main>
        <div class="tabla">
            <table class="tablePDF table-bordered" id="TablaVerCliente">
                <thead>

                    <tr class="text-left ">
                        <th class="text-center  tdNombre">ID Cuenta</th>
                        <th class="text-center  tdNombre">Código</th>
                        <th class="text-center  tdNombre">Nombre</th>
                        <th class="text-center  tdNombre">S.Inicial</th>
                        <th class="text-center  tdNombre">Debitos</th>
                        <th class="text-center  tdNombre">Creditos</th>
                        <th class="text-center  tdNombre">Saldo acumulado</th>
                        <th class="text-center  tdNombre">Saldo cierre</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($balances as $balance)
                        <tr>
                            <td class="text-center">{{ $balance->id_cuenta }}</td>
                            <td class="text-center">{{ $balance->codigo }}</td>
                            <td class="text-center">{{ $balance->nombre }}</td>
                            <td class="text-center">{{ sprintf('%.2f', $balance->saldo_inicial) }}</td>
                            <td class="text-center">{{ sprintf('%.2f', $balance->debitos) }}</td>
                            <td class="text-center">{{ sprintf('%.2f', $balance->creditos) }}</td>
                            <td class="text-center">{{ sprintf('%.2f', $balance->saldo_acumulado) }}</td>
                            <td class="text-center">{{ sprintf('%.2f', $balance->saldo_cierre) }}</td>



                        </tr>
                    @endforeach




                </tbody>

            </table>

        </div>
        {{-- @if ($balance->nombre = 'RESULTADO NEGATIVO')
        RESULTADO NEGATIVO: {{ $balance->saldo_acumulado }} - {{ $balance->saldo_cierre }}
        <br>
        RESULTADO PERDIDA: {{ $balance->saldo_acumulado }} -{{ $balance->saldo_cierre }}
    @endif --}}
        {{-- RESULTADO NEGATIVO: {{ sprintf('%.2f', $balance->saldo_acumulado) }} -
    {{ sprintf('%.2f', $balance->saldo_cierre) }}
    <br>
    RESULTADO PERDIDA: {{ sprintf('%.2f', $balance->saldo_acumulado) }} -
    {{ sprintf('%.2f', $balance->saldo_cierre) }} --}}

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
