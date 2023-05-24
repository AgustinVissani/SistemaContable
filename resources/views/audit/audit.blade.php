@extends('welcome')
@section('section')

{{-- <div class="row">
    <div class="col-md-10">
        <div class="panel panel-defaul">
            <div class="panel-body">

              <ul>
               @forelse ($audits as $audit)
                 <li>
                     @lang('article.updated.metadata', $audit->getMetadata())

                     @foreach ($audit->getModified() as $attribute => $modified)
                        <ul>
                             <li>@lang('article.'.$audit->event.'.modified.'.$attribute, $modified)</li>
                        </ul>
                      @endforeach
               </li>
                 @empty
                <p>@lang('article.unavailable_audits')</p>
               @endforelse
             </ul>
            </div>
        </div>
    </div>
</div> --}}

        <div class="container p-4">
        <a href="{{ route('audit.pdf') }}" class="botonPDF" title="Descarga listado de auditoria PDF" >
            <i class="far fa-file-pdf fa-3x " style="color: black;"></i>
        </a>



        <a href="{{ route('audit.xlsx') }}" class="botonPDF" title="Descarga listado de auditoria XLSX">
            <i class="far fa-file-excel fa-3x " style="color: black;"></i>
        </a>
    </div>

    <br>
    <br>

    <h1 class="text-center" style="color: blue">Auditoría</h1>




    <div class="tablaAudit">
        <div class="container">
            <table class="table td  table-bordered" id="MyTable">
                <thead>
                    <tr class="text-center ">
                        {{-- <th class="text-center  tdNombre">ID</th> --}}
                        {{-- <th class="text-center  tdNombre">Usuario</th> --}}
                        {{-- <th class="text-center  tdNombre">Usuario ID</th> --}}
                        <th class="text-center  tdNombre">Nombre Usuario</th>
                        <th class="text-center  tdNombre">Acción</th>
                        <th class="text-center  tdNombre">Tabla</th>
                        <th class="text-center  tdNombre">Registro ID </th>
                        <th class="text-center  tdNombre">Valores </th>
                        {{-- <th class="text-center  tdNombre">Valores nuevos</th> --}}
                        <th class="text-center  tdNombre">URL</th>
                        <th class="text-center  tdNombre">Dirección IP</th>
                        {{-- <th class="text-center  tdNombre">Buscador</th> --}}
                        {{-- <th class="text-center  tdNombre">Tags</th> --}}
                        <th class="text-center  tdNombre">Fecha/Horario</th>
                        {{-- <th class="text-center  tdNombre">Actualizado el</th> --}}

                    </tr>
                </thead>
                <tbody>
                    @foreach ($audits as $audit)
                        <tr>

                            {{-- <td class="text-center">{{ $audit->id }}</td> --}}
                            {{-- <td class="text-center">{{ $audit->user_type }}</td> --}}
                            {{-- <td class="text-center">{{ $audit->user_id }}</td> --}}
                            <td class="text-center">{{ $audit->nombreUsuario }}</td>
                            <td class="text-center">{{ $audit->event }}</td>
                            <td class="text-center">{{ $audit->auditable_type }}</td>
                            <td class="text-center">{{ $audit->auditable_id }}</td>
                            {{-- <td class="text-center">{{ $audit->old_values }}</td> --}}
                            <td class="text-center">
                                <a href="valor/{{ $audit->id }}" class="btn btn-info">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>VER
                                </a>
                            </td>


                            {{-- <td class="text-center">{{ $audit->new_values }}</td>  --}}

                            {{-- <td class="text-center">
                                <a href="valorNuevo/{{ $audit->new_values }}" class="btn btn-info">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>VER
                                </a>
                            </td> --}}


                             {{-- <!-- Vertically centered scrollable modal -->
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal">
                                    Valores viejos
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Valores viejos</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-dialog modal-dialog-scrollable">


                                              {{ $audit->old_values }}


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>



                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal">
                                    Valores nuevos
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Valores nuevos</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-dialog modal-dialog-scrollable">


                                                 {{$audit->new_values}}


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td> --}}

                            <td class="text-center">{{ $audit->url }}</td>
                            <td class="text-center">{{ $audit->ip_address }}</td>
                            {{-- <td class="text-center">{{ $audit->user_agent }}</td> --}}
                            {{-- <td class="text-center">{{ $audit->tags }}</td> --}}
                            <td class="text-center">{{ $audit->created_at }}</td>
                            {{-- <td class="text-center">{{ $audit->updated_at }}</td> --}}




                        </tr>
                    @endforeach




                </tbody>
            </table>

            <td class="text-center">
                <a href="auditCompleta/" class="btn btn-link botonLink">
                    <span aria-hidden="true"></span>Auditoría con usuarios eliminados
                </a>
            </td>

        </div>
    </div>






@endsection
