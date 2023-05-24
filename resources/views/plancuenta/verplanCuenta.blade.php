@extends('welcome')
@section('section')


    <h1 class="display-5 text-center" style="color: blue">Vista completa del PLAN DE CUENTA</h1>


    <div class="tabla" style="display:flex; justify-content: center;">
        <table class="table table-bordered" id="TablaVerCliente">
            <thead>
                <tr class="text-center ">
                    <th class="text-center  tdNombre">ID</th>
                    <th class="text-center  tdNombre">Código</th>
                    <th class="text-center  tdNombre">Nombre</th>
                    <th class="text-center  tdNombre">Imputable</th>
                    <th class="text-center  tdNombre">Nivel</th>

                </tr>
            </thead>
            <tbody>
                <tr>

                    <td class="text-center">{{ $planCuenta->id }}</td>
                    <td class="text-center">{{ $planCuenta->prefijo }}{{ $planCuenta->sufijo }}</td>
                    <td class="text-center">{{ $planCuenta->nombre }}</td>
                    <td class="text-center">{{ $planCuenta->imp }}</td>
                    <td class="text-center">{{ $planCuenta->nivel }}</td>

                </tr>

            </tbody>
        </table>



    </div>

    <a href="/editplanCuenta/{{ $planCuenta->id }}" class="btn btn-success btn-xs " style="margin: 5px">
        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>EDITAR
    </a>


{{-- 

    <td class="text-center">
        <form method="POST" action="deleteplanCuentas/{{ $planCuenta->id }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-xs " type="submit"
                onclick="return confirm('¿Seguro quiere eliminar?')">
                <span class="glyphicon glyphicon-edit" aria-hidden="true">ELIMINAR
            </button>
        </form>
    </td> --}}

@endsection
