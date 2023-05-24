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
    <h5 style="display:flex; justify-content: left;" class="text-left">Sistema de Contabilidad - EMPRESA:
        '{{ $datosempresa[0]->nombrepila }}'</h5>
    <h1>Balance Completo Detallado</h1>
</head>

<body>
    <div class="tabla" style="display:flex; justify-content: left;">
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
    {{-- @if (isset(($balance->nombre = 'RESULTADO NEGATIVO')))
        RESULTADO NEGATIVO: {{ sprintf('%.2f', $balance->saldo_acumulado) }} -
        {{ sprintf('%.2f', $balance->saldo_cierre) }}
        <br>
        RESULTADO PERDIDA: {{ sprintf('%.2f', $balance->saldo_acumulado) }} -
        {{ sprintf('%.2f', $balance->saldo_cierre) }}

    @endif --}}
    @if ($balance->nombre = 'RESULTADO NEGATIVO')
        RESULTADO NEGATIVO: {{ sprintf('%.2f', $balance->saldo_acumulado) }} - {{ sprintf('%.2f', $balance->saldo_cierre) }}
        <br>
        RESULTADO PERDIDA: {{ sprintf('%.2f', $balance->saldo_acumulado) }} - {{ sprintf('%.2f', $balance->saldo_cierre) }}
    @endif
    <script type="text/php">
        if ( isset($pdf) ) {
                        $pdf->page_script('
                            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                            $pdf->text(370, 570, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
                        ');
                    }
        </script>


</body>

</html>
