@extends('welcome')
@section('section')


    <h1 class="display-5 text-center" style="color: blue">Vista completa del Cliente</h1>


    <div class="tabla" style="display:flex; justify-content: center;">
        <table class="table table-bordered" id="TablaVerCliente">
            <thead>
                <tr class="text-center ">
                    <th class="text-center  tdNombre">ID</th>
                    <th class="text-center  tdNombre">Nombre</th>
                    <th class="text-center  tdNombre">Apellido</th>
                    <th class="text-center  tdNombre">DNI</th>
                    <th class="text-center  tdNombre">E-mail</th>
                    <th class="text-center  tdNombre">Dirección</th>
                    <th class="text-center  tdNombre">Teléfono</th>
                    <th class="text-center  tdNombre">ID Sexo</th>
                    <th class="text-center  tdNombre">Sexo</th>
                    <th class="text-center  tdNombre">ID Provincia</th>
                    <th class="text-center  tdNombre">Provincia</th>


                </tr>
            </thead>
            <tbody>
                <tr>

                    <td class="text-center">{{ $cliente->id }}</td>
                    <td class="text-center">{{ $cliente->nombre }}</td>
                    <td class="text-center">{{ $cliente->apellido }}</td>
                    <td class="text-center">{{ $cliente->dni }}</td>
                    <td class="text-center">{{ $cliente->mail }}</td>
                    <td class="text-center">{{ $cliente->direccion }}</td>
                    <td class="text-center">{{ $cliente->telefono }}</td>
                    <td class="text-center">{{ $cliente->sexo }}</td>
                    <td class="text-center">{{ $sexo }}</td>
                    <td class="text-center">{{ $cliente->id_provincia }}</td>
                    <td class="text-center">{{ $provincia }}</td>


                </tr>




            </tbody>
        </table>



    </div>

    <a href="/editCliente/{{ $cliente->id }}" class="btn btn-success btn-xs " style="margin: 5px">
        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>EDITAR
    </a>



    <form method="POST" action="/deleteCliente/{{ $cliente->id }} ">
        @csrf
        @method('DELETE')
        <button style="margin: 5px" class="btn btn-danger btn-xs " type="submit"
            onclick="return confirm('¿Seguro quiere eliminar?')">
            <span class="glyphicon glyphicon-edit" aria-hidden="true">ELIMINAR
        </button>
    </form>

@endsection
