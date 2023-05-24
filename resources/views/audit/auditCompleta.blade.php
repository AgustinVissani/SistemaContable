@extends('welcome')
@section('section')

    <h1 class="text-center" style="color: blue">Auditoría</h1>




    <div class="tablaAudit">
        <div class="container">
            <table class="table td  table-bordered" id="MyTable">
                <thead>
                    <tr class="text-center ">
                        <th class="text-center  tdNombre">ID</th>
                        <th class="text-center  tdNombre">Usuario ID</th>
                        <th class="text-center  tdNombre">Acción</th>
                        <th class="text-center  tdNombre">Tabla</th>
                        <th class="text-center  tdNombre">Registro ID </th>
                        {{-- <th class="text-center  tdNombre">Valores </th> --}}
                        <th class="text-center  tdNombre">URL</th>
                        <th class="text-center  tdNombre">Dirección IP</th>
                        <th class="text-center  tdNombre">Fecha/Horario</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($audits as $audit)
                        <tr>

                            <td class="text-center">{{ $audit->id }}</td>
                            <td class="text-center">{{ $audit->user_id }}</td>
                            <td class="text-center">{{ $audit->event }}</td>
                            <td class="text-center">{{ $audit->auditable_type }}</td>
                            <td class="text-center">{{ $audit->auditable_id }}</td>
                            {{-- <td class="text-center">
                                <a href="valor/{{ $audit->id }}" class="btn btn-info">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>VER
                                </a>
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


        </div>
    </div>






@endsection
