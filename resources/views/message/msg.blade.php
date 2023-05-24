@if (\Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 20px">
        {!! \Session::get('success') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


@if (session('mensaje'))
    <div class="alert alert-info alert-dismissible fade show" role="alert" style="font-size: 20px">
        {{ session('mensaje') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif



@if (session('mensajeError'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 20px">
        {{ session('mensajeError') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


