@extends('welcome')
@section('section')


    {{-- <h1 class="text-center h1tablaCliente">Vista completas de los Clientes</h1> --}}
    <h1 class="display-5 text-center" style="color: blue">Vista completas de los Usuarios</h1>

    <div class="container p-4">
        <a href="{{ route('users.pdf') }}" class="botonPDF" title="Descarga listado de clientes PDF">
            <i class="far fa-file-pdf fa-3x " style="color: black;"></i>
        </a>

        <a href="{{ route('users.xlsx') }}" class="botonPDF" title="Descarga listado de clientes XLSX">
            <i class="far fa-file-excel fa-3x " style="color: black;"></i>
        </a>
    </div>
    {{-- <br>
    <br>
    <br> --}}
    <div class="container p-4">
        <div class="" style="display:flex; justify-content: center; overflow: scroll; height:700px;">
            <table class="table table-bordered" id="TablaVerCliente">
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
    </div>


@endsection
