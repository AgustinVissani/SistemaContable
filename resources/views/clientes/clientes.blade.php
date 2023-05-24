@extends('welcome')
@section('section')




    <a href="/altaCliente" class="btn btn-primary btn-lg active" role="button" aria-pressed="true"
        title="Agrega un nuevo cliente">Nuevo Cliente</a>
    <br>


    <h1 class="text-center h1tablaProvincia">Tabla Clientes</h1>



    <div class="tabla">
        <div class="container">
            <table class="table  table-bordered" id="MyTable">
                <thead>
                    <tr class="text-center ">
                        <th class="text-center  tdNombre">ID</th>
                        <th class="text-center  tdNombre">Nombre</th>
                        <th class="text-center  tdNombre">Apellido</th>
                        <th class="text-center  tdNombre">DNI</th>
                        <th class="text-center  tdNombre">Provincia</th>
                        <th class="text-center  tdNombre">Ver</th>
                        <th class="text-center tdNombre">Editar</th>
                        <th class="text-center tdNombre">Eliminar</th>
                        {{-- <th class="text-center tdNombre">Acción</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td class="text-center">{{ $cliente->id }}</td>
                            <td class="text-center">{{ $cliente->nombre }}</td>
                            <td class="text-center">{{ $cliente->apellido }}</td>
                            <td class="text-center">{{ $cliente->dni }}</td>
                            <td class="text-center">{{ $cliente->descripcion }}</td>


                            <td class="text-center">
                                <a href="verCliente/{{ $cliente->id }}" class="btn btn-info">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>VER
                                </a>
                            </td>


                            <td class="text-center">

                                <a href="editCliente/{{ $cliente->id }}" class="btn btn-success btn-xs">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>EDITAR
                                </a>
                            </td>

                            <td class="text-center">
                                <form method="POST" action="deleteCliente/{{ $cliente->id }}">
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
                    @endforeach
                    </tr>
                </tbody>
            </table>

        </div>


        <td class="text-center">
            <a href="verClientes/" class="btn btn-link botonLink">
                <span aria-hidden="true"></span>Generar listados
            </a>
        </td>

    </div>

@endsection
