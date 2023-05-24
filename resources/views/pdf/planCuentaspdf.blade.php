<!DOCTYPE html>
<html lang="es">


<style>
    .tablePDF {
        font-size: 14px;
        /* text-align: left; */
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
</head>

<body>
    <div class="tabla">
        <table class="tablePDF table-bordered" id="TablaVerCliente">
            <thead>

                <tr class="text-left ">
                    <th class="text-left  tdNombre">Nro. Cuenta</th>
                    <th class="text-center  tdNombre">Código</th>
                    <th class="text-left  tdNombre">Nombre Cta. </th>
                    <th class="text-left  tdNombre">Imp.</th>
                    <th class="text-left  tdNombre">Nivel</th>


                </tr>
            </thead>
            <tbody>
                @foreach ($planCuentas as $planCuenta)
                    <tr>
                        <td class="text-left">{{ $planCuenta->id }}</td>

                        <td class="text-center"> {{  $planCuenta->codigo }}</td>
                        <td class="text-left">  {{$planCuenta->nombre}}</td>
                        <td class="text-left">{{ $planCuenta->imp }}</td>
                        <td class="text-left">{{ $planCuenta->nivel }}</td>



                    </tr>
                @endforeach



            </tbody>
        </table>
    </div>

    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(270, 790, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
	</script>


</body>

</html>
