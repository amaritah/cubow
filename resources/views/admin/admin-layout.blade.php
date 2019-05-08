<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{config('app.name')}} @yield('title')</title>

        <link href="{{ URL::asset('css/fontawesome.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/datatables.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/datatables-responsive.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/fileinput.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/jquery-ui.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/admin.css') }}" rel="stylesheet">
        
        @yield('styles')
        
    </head>
    <body>
        <div class="container" style="position:relative;">
            <header>
                
                <div class=" nav">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand logo float-left" href="/"><img src="{{ URL::asset('assets/img/login-logo-red.png') }}"/></a>
                        
                        <!-- AQUI DEBERIA IR EL USUARIO LOGGEADO-->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse order-last" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto float-right">
                                @include('admin.nav')
                            </ul>
                        </div>
                    </nav>
                </div>
            </header>
            <div id="content">
                @yield('content')
            </div> 
            <div id="content-overlay">
            </div>
            <footer>
            </footer>
        </div>
       
        <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('js/popper.js') }}"></script>
        <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::asset('js/jquery-ui.min.js') }}"></script>
        <script src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ URL::asset('js/bootstrap-select.min.js') }}"></script>
        <script src="{{ URL::asset('js/datatables.js') }}"></script>
        <script src="{{ URL::asset('js/datatables-responsive.js') }}"></script>
        <script src="{{ URL::asset('js/admin.js') }}"></script>
        
        @yield('scripts')
        
        @if (Session::has('message') || $errors->any() || Session::has('success') || Session::has('error'))
        <script>
            var messages = [];
            @if(Session::has('message'))
                messages.push("{{Session::get('message')}}");
            @endif
            @if(Session::has('success'))
                messages.push("{{Session::get('success')}}");
            @endif
            @if(Session::has('error'))
                messages.push("{{Session::get('error')}}");
            @endif
            @if($errors->any())
                @foreach($errors->all() as $error)
                messages.push("{{$error}}");
                @endforeach
            @endif
            if (!(messages.indexOf('Usuario y/o contraseña incorrectos.') > -1 && $('#form-login').length < 1))
                console.log('revisar esto'); //muestraMensaje(messages);
        </script>
        @endif
    </body>
</html>