<!DOCTYPE html>
<html lang="es">


<style>
    .tablePDF{
        font-size: 20px;
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
                        <th class="text-center  tdNombre">Nombre</th>
                        <th class="text-center  tdNombre">ID Rol</th>
                        <th class="text-center  tdNombre">Rol</th>
                        <th class="text-center  tdNombre">E-mail</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>


                            <td class="text-center">{{ $user->id }}</td>
                            <td class="text-center">{{ $user->name }}</td>
                            <td class="text-center">{{ $user->id_rol }}</td>
                            <td class="text-center">{{ $user->descripcion }}</td>
                            <td class="text-center">{{ $user->email }}</td>
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
