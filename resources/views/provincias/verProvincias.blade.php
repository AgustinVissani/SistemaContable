@extends('welcome')
@section('section')


    {{-- <h1 class="text-center h1tablaCliente">Vista completas de los Clientes</h1> --}}
    <h1 class="display-5 text-center" style="color: blue">Vista completas de los Provincias</h1>

    <a href="{{ route('provincia.pdf') }}" class="botonPDF" title="Descarga listado de provincias">
        <i class="far fa-file-pdf fa-3x" style="color: black"></i>
    </a>

    <a href="{{ route('provincia.xlsx') }}" class="botonPDF" title="Descarga listado de provincia XLSX">
        <i class="far fa-file-excel fa-3x " style="color: black;"></i>
    </a>

    {{-- <br>
    <br>
    <br> --}}
    <div class="container p-4">
        <div class="" style="display:flex; justify-content: center; overflow: scroll; height:700px;">
            <table class="table table-bordered" id="TablaVerCliente">
                <thead>
                    <tr class="text-center ">
                        {{-- <th class="text-center  "> checkbox</th> --}}
                        <th class="text-center  tdNombre">ID</th>
                        <th class="text-center  tdNombre">Provincias</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($provincias as $provincia)
                        <tr>

                            <td class="text-center">{{ $provincia->id }}</td>
                            <td class="text-center">{{ $provincia->descripcion }}</td>


                        </tr>
                    @endforeach



                </tbody>
            </table>
        </div>




    </div>


@endsection
