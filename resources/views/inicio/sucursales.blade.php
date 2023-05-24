@extends('welcome')
@section('section')




    <a href="/altaSucursal" class="btn btn-primary btn-lg active" role="button" aria-pressed="true"
        title="Agrega una nueva sucursal">Nueva Sucursal</a>
    <br>


    <h1 class="text-center h1tablaProvincia">Tabla Sucursales</h1>




        <div class="tabla">
            <div class="container">
                <table class="table  table-bordered" id="MyTable">
                    <thead>
                        <tr class="text-center ">
                            <th class="text-center  tdNombre">ID</th>
                            <th class="text-center  tdNombre">Sucursal</th>
                            <th class="text-center  tdNombre">ID Provincia</th>
                            <th class="text-center  tdNombre">CP</th>
                            <th class="text-center  tdNombre">ID Localidad</th>
                            <th class="text-center  tdNombre">Calle</th>
                            <th class="text-center  tdNombre">Número</th>
                            <th class="text-center  tdNombre">Piso</th>
                            <th class="text-center  tdNombre">Editar</th>
                            <th class="text-center  tdNombre">Eliminar</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sucursales as $sucursal)
                            <tr>
                                <td class="text-center">{{ $sucursal->id }}</td>
                                <td class="text-center">{{ $sucursal->denominacion }}</td>
                                <td class="text-center">{{ $sucursal->id_provincia }}</td>
                                <td class="text-center">{{ $sucursal->cp }}</td>
                                <td class="text-center">{{ $sucursal->id_localidad }}</td>
                                <td class="text-center">{{ $sucursal->calle }}</td>
                                <td class="text-center">{{ $sucursal->numero }}</td>
                                <td class="text-center">{{ $sucursal->piso }}</td>


                            <td class="text-center">

                                <a href="editSucursal/{{ $sucursal->id }}" class="btn btn-success btn-xs">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>EDITAR
                                </a>
                            </td>

                            <td class="text-center">
                                <form method="POST" action="deleteSucursal/{{ $sucursal->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-xs " type="submit"
                                        onclick="return confirm('¿Seguro quiere eliminar?')">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true">ELIMINAR
                                    </button>
                                </form>
                            </td>

                        @endforeach
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>




@endsection
