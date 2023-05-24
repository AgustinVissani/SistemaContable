<!DOCTYPE html>
<html lang="es">
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TP 4</title>

    <!-- Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@0;1&display=swap" rel="stylesheet"> --}}

    {{-- BOOSTRAP --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
    </script>

    <!-- STYLES -->
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/stylesPdf.css">
    <link rel="stylesheet" href="/css/stylesProvincia.css">
    <link rel="stylesheet" href="/css/stylesCliente.css">
    <link rel="stylesheet" href="/css/stylesInicio.css">
    <link rel="stylesheet" href="/css/stylesNavbar.css">
    <link rel="stylesheet" href="/css/stylesAudit.css">
    <link rel="stylesheet" href="/css/jqueryui-editable.css">


    {{-- CSS --}}
    <script src="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> </script>



    <!-- JQUERY  ESTA VERSION ESTABA ANTES DEL EDIT TABLE NO SE QUE CAMBIA -->
    {{-- <link href="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"> --}}


    {{-- ESTAS SON PARA EL EDIT TABLE --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap-editable/css/bootstrap-editable.css"
        rel="stylesheet" /> --}}

     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap-editable/js/bootstrap-editable.min.js">
    </script>--}}
     <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js">
    </script>

    {{-- aca termina EDIT TABLE --}}


    {{-- FONT AWESOME ICONO --}}
    <script src="https://kit.fontawesome.com/8a0c52262c.js" crossorigin="anonymous"></script>

</head>

<body class="antialiased">

    @include('navbar.navbar')
    @include('message.msg')
    <div class="container p-4">
        @yield('section')
    </div>







    {{-- JAVASCRIPT --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"> </script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"> </script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"> </script>
    <script src="/js/main.js"></script>
    <script src="/js/clientes.js"></script>
    <script src="/js/selecciones.js"></script>
    <script src="/js/inicio.js"></script>
    <script src="/js/jqueryui-editable.js"></script>
    <script src="/js/jqueryui-editable.min.js"></script>

    <script>

    </script>


</body>


</html>
