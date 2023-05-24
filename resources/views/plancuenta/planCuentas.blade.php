@extends('welcome')
@section('section')




    <a href="/altaplanCuenta" class="btn btn-primary btn-lg active" role="button" aria-pressed="true"
        title="Agrega un nuevo plan de cuenta">Nuevo registro en Plan de Cuentas</a>
    <br>


    <h1 class="text-center h1tablaProvincia">Tabla PLAN de CUENTAS</h1>



    <div class="tabla">
        <div class="container">
            <table class="table  table-bordered" id="MyTable">
                <thead>
                    <tr class="text-center ">
                        <th class="text-center  tdNombre">ID</th>
                        <th class="text-center  tdNombre">Código</th>
                        <th class="text-center  tdNombre">Nombre</th>
                        <th class="text-center  tdNombre">Imputable</th>
                        <th class="text-center  tdNombre">Nivel</th>
                        <th class="text-center  tdNombre">Ver</th>
                        <th class="text-center tdNombre">Editar</th>
                        <th class="text-center tdNombre">Eliminar</th>
                        {{-- <th class="text-center tdNombre">Acción</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($planCuentas as $planCuenta)
                        @if ($planCuenta->id != 1)
                            <tr>
                                <td class="text-center">{{ $planCuenta->id }}</td>
                                <td class="text-center">{{ $planCuenta->prefijo }}{{ $planCuenta->sufijo }}</td>
                                <td class="text-center">{{ $planCuenta->nombre }}</td>
                                <td class="text-center">{{ $planCuenta->imp }}</td>
                                <td class="text-center">{{ $planCuenta->nivel }}</td>


                                <td class="text-center">
                                    <a href="verplanCuenta/{{ $planCuenta->id }}" class="btn btn-info">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>VER
                                    </a>
                                </td>


                                <td class="text-center">

                                    <a href="editplanCuenta/{{ $planCuenta->id }}" class="btn btn-success btn-xs">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>EDITAR
                                    </a>
                                </td>

                                <td class="text-center">
                                    <form method="POST" action="deleteplanCuentas/{{ $planCuenta->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-xs " type="submit"
                                            onclick="return confirm('¿Seguro quiere eliminar?')">
                                            <span class="glyphicon glyphicon-edit" aria-hidden="true">ELIMINAR
                                        </button>
                                    </form>
                                </td>


                                {{-- PARA ACHICAR LOS BOTONES CON UN DROP
                                <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Acción
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2" style="width: 0%">

                                        <form method="POST" action="deleteCliente/{{ $cliente->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-xs dropdown-item  " type="submit"
                                                onclick="return confirm('¿Seguro quiere eliminar?')" >
                                                <span title='Eliminar' class="glyphicon glyphicon-edit"
                                                    aria-hidden="true"><i class="fas fa-trash-alt" style="color: red"></i>
                                            </button>
                                        </form>


                                        <button  class=" dropdown-item">
                                            <a href="editCliente/{{ $cliente->id }}" class="">
                                            <span title='Editar' class="glyphicon glyphicon-edit"
                                                aria-hidden="true"></span><i class="fas fa-edit" style="color:green"></i>
                                            </a>
                                        </button> --}}
                        @endif
                    @endforeach
                    </tr>
                </tbody>
            </table>

        </div>


        <td class="text-center">
            <a href="verplanCuentas/" class="btn btn-link botonLink">
                <span aria-hidden="true"></span>Generar listados
            </a>
        </td>

    </div>

@endsection
