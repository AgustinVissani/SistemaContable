@extends('welcome')
@section('section')

    <div class="container justify-content-center align-items-center text-center p-4">
        <div class="container text-center">
            <h1 class="p-3 text-center h1tablaProvincia">BACKUP EMPRESA</h1>
        </div>
        <form action="backup" method="POST" class="p-4">
            @csrf
            <button style="margin: 10px" type="submit" class="btn-lg btn-success">Generar backup <i class="fas fa-database"></i></button>
        </form>

        <div class="container text-center">
            <h1 class="p-3 text-center h1tablaProvincia">RESTAURAR EMPRESA</h1>
        </div>
        <form action="restore" style="color:rgb(255, 38, 0);" method="POST" class="p-4" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 row justify-content-center align-items-center text-center">
                <div class="col-md-8 justify-content-center align-items-center text-center">
                    <input type="file" class="form-control-file" id="filesql" name="filesql" style="font-size: 20px">
                </div>
                <div class="col-md-3 justify-content-center align-items-center text-center">
                    <button style="margin: 10px" type="submit" class="btn-lg btn-success">Restaurar backup <i class="fas fa-undo-alt"></i></button>
                </div>
            </div>
        </form>
    </div>




    {{-- ----------------------------------------------------------------------------------- --}}


    {{-- @if ($backups)
        <table class="table table-striped table-bordered ">
            <thead class="thead-dark">
                <tr>
                    <th>Archivo</th>
                    <th>Tamaño</th>
                    <th>Fecha</th>
                    <th>Año</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($backups as $backup)
                    <tr>
                        <td>{{ $backup['file_name'] }}</td>
                        <td>{{ $backup['file_size'] }}</td>
                        <td>
                            {{ date('d/M/Y, g:ia', strtotime($backup['last_modified'])) }}
                        </td>
                        <td>
                            {{ date('Y', strtotime($backup['last_modified'])) }}
                        </td>
                        <td class="text-center">
                            <a class="btn btn-primary"
                                href="{{ url('downloadBackup/' . $backup['file_name']) }}">DESCARGAR</a>
                            <form method="POST" action="deleteBackup/{{ $backup['file_name'] }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-xs " type="submit"
                                    onclick="return confirm('¿Seguro quiere eliminar?')">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true">ELIMINAR
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-5">
            <h4 class="text-muted">No existen backups</h4>
        </div>
    @endif --}}

@endsection
