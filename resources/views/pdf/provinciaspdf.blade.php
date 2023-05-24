<!DOCTYPE html>
<html lang="es">


<style>
    .tablePDF{
        font-size: 15px;
        text-align: center;
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
    <div class="tabla" style="display:flex; justify-content: center;">
        <table class="tablePDF table-bordered" id="TablaVerCliente">
            <thead>

                <tr class="text-center ">
                    <th class="text-center  tdNombre">ID</th>
                    <th class="text-center  tdNombre">Descripción</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($provincias as $provincia)
                    <tr>
                        <td class="text-center">{{ $provincia->id }}</td>
                        <td class="text-center">{{ $provincia->descripcion }}</td>


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
