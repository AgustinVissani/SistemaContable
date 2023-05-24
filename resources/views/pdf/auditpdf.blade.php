<!DOCTYPE html>
<html lang="es">

<style>
    .tablePDF {
        font-size: 13px;
        text-align: center;
        width: 100%;
        /* border: 1px solid #999999; */
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
    <div class="tablaAudit">
        <div class="container">
            <table class="tablePDF table-bordered" id="TablaVerCliente">
                <thead>
                    <tr class="text-center ">
                        <th class="text-center  tdNombre">ID</th>
                        {{-- <th class="text-center  tdNombre">Usuario</th> --}}
                        <th class="text-center  tdNombre">Usuario ID</th>
                        <th class="text-center  tdNombre">Nombre Usuario</th>
                        <th class="text-center  tdNombre">Acción</th>
                        <th class="text-center  tdNombre">Tabla</th>
                        {{-- <th class="text-center  tdNombre">Tabla ID</th> --}}
                        {{-- <th class="text-center  tdNombre">Valores viejos </th>
                        <th class="text-center  tdNombre">Valores nuevos</th> --}}
                        <th class="text-center  tdNombre">URL</th>
                        <th class="text-center  tdNombre">Dirección IP</th>
                        {{-- <th class="text-center  tdNombre">Buscador</th> --}}
                        {{-- <th class="text-center  tdNombre">Tags</th> --}}
                        <th class="text-center  tdNombre">Creado el</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($audits as $audit)
                        <tr>

                            <td class="text-center">{{ $audit->id }}</td>
                            {{-- <td class="text-center">{{ $audit->user_type }}</td> --}}
                            <td class="text-center">{{ $audit->user_id }}</td>
                            <td class="text-center">{{ $audit->nombreUsuario }}</td>
                            <td class="text-center">{{ $audit->event }}</td>
                            <td class="text-center">{{ $audit->auditable_type }}</td>
                            {{-- <td class="text-center">{{ $audit->old_values }}</td> --}}
                            {{-- <td class="text-center">{{ $audit->new_values }}</td> --}}
                            <td class="text-center">{{ $audit->url }}</td>
                            <td class="text-center">{{ $audit->ip_address }}</td>
                            <td class="text-center">{{ $audit->created_at }}</td>




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
