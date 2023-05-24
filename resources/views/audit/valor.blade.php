@extends('welcome')
@section('section')


    <h1 class="display-5 text-center" style="color: blue">Vista completa de datos</h1>
    <style>
        .tabla {
            font-size: 25px;
            text-align: center;
            width: 100%;
            /* border: 1px solid #000000; */
        }

    </style>
    <input style="margin: 10px; width: 10%;" type="button" class="btn btn-primary" value="MOSTRAR" onclick="texto();" />
    <div class="tabla" style="display:flex; justify-content: center;">
        <table class="table table-bordered" id="TablaVerCliente">
            <thead>


            </thead>
            <tbody>


                <tr class="text-center ">
                    <th class="text-center  " style="font-size: 25px; width: 20%;">Registro ID</th>
                    <th class="text-center">{{ $audit->auditable_id }}</th>
                </tr>
                <tr class="text-center ">
                    <th class="text-center  " style="font-size: 25px; width: 20%;">Datos nuevos</th>
                    <th><textarea style="font-size: 20px; width: 100%" id="valoresNuevos"></textarea></th>
                </tr>
                <tr>
                    <th class="text-center  " style="font-size: 25px; width: 20%;">Datos viejos</th>
                    <th><textarea style="font-size: 20px; width: 100%" id="valoresViejos"></textarea></th>
                </tr>
                <tr>
                    <th class="text-center  " style="font-size: 25px; width: 20%;">Usuario</th>
                    <th class="text-center">{{ $nombreUsuario }}</th>
                </tr>
                <tr>
                    <th class="text-center  " style="font-size: 25px; width: 20%;">Acción</th>
                    <th class="text-center">{{ $audit->event }}</th>
                    {{-- <th class="text-center" id="valoresAccion" ></th> --}}
                </tr>
                <tr>
                    <th class="text-center" style="font-size: 25px; width: 20%;">Tabla</th>
                    <th class="text-center" id="valoresTabla" ></th>
                </tr>


            </tbody>
        </table>

    </div>

    <script type="text/javascript">
        function texto() {
            let vNuevos = ("{{ $newValues }}").substring(1, ("{{ $newValues }}").length - 1);
            let valoresN = (vNuevos).replace(/&quot;/g, ' ');
            document.getElementById("valoresNuevos").innerHTML = valoresN;

            let vViejos = ("{{ $oldValues }}").substring(1, ("{{ $oldValues }}").length - 1);
            let valoresV = (vViejos).replace(/&quot;/g, ' ');
            document.getElementById("valoresViejos").innerHTML = valoresV;

            let vTabla = ("{{$audit->auditable_type}}").substring(9, ("{{$audit->auditable_type}}").length - 0);
            let tablaV = (vTabla).replace(/-/g, '');
            document.getElementById("valoresTabla").innerHTML = tablaV;

            // let vAccion = ("{{$audit->event}}").substring(9, ("{{$audit->event}}").length - 0);
            // let accionV = (vAccion).replace(/ /g, 'HOLAAAA');
            // document.getElementById("valoresAccion").innerHTML = accionV;

        }

    </script>


@endsection
