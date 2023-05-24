<!DOCTYPE html>
<html lang="es">


<style>
    .tablePDF{
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
</head>

<body>
    <div class="tabla" style="display:flex; justify-content: left;">
        <table class="tablePDF table-bordered" id="TablaVerCliente">
            <thead>

                <tr class="text-left ">
                    <th class="text-left  tdNombre">ID</th>
                    <th class="text-left  tdNombre">Nombre</th>
                    <th class="text-left  tdNombre">Apellido</th>
                    <th class="text-left  tdNombre">DNI</th>
                    <th class="text-left  tdNombre">E-mail</th>
                    <th class="text-left  tdNombre">Dirección</th>
                    <th class="text-left  tdNombre">Teléfono</th>
                    <th class="text-left  tdNombre">ID Sexo</th>
                    <th class="text-left  tdNombre">Sexo</th>
                    <th class="text-left  tdNombre">ID Provincia</th>
                    <th class="text-left  tdNombre">Provincia</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr>
                        <td class="text-left">{{ $cliente->id }}</td>
                        <td class="text-left">{{ $cliente->nombre }}</td>
                        <td class="text-left">{{ $cliente->apellido }}</td>
                        <td class="text-left">{{ $cliente->dni }}</td>
                        <td class="text-left">{{ $cliente->mail }}</td>
                        <td class="text-left">{{ $cliente->direccion }}</td>
                        <td class="text-left">{{ $cliente->telefono }}</td>
                        <td class="text-left">{{ $cliente->id_sexo }}</td>
                        <td class="text-left">{{ $cliente->sexo }}</td>
                        <td class="text-left">{{ $cliente->id_provincia }}</td>
                        <td class="text-left">{{ $cliente->provincia }}</td>


                    </tr>
                @endforeach



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


</body>

</html>
