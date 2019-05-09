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
        <div class="container">
            <header>
                
                <div class=" nav">
                    <nav class="navbar navbar-expand-lg navbar-dark">
                        <a class="navbar-brand logo float-left" href="{{route('admin')}}"><img class="logo" src="{{ URL::asset('img/logo-icon.png') }}"/></a>
                        
                        <!-- AQUI DEBERIA IR EL USUARIO LOGGEADO-->
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse order-last" id="navbarSupportedContent">
                            <ul class="navbar-nav ">
                                @include('admin.nav')
                            </ul>
                        </div>
                    </nav>
                </div>
            </header>
            <div id="content">
                @yield('contentTitle')
                
                @if(Session::has('message'))
                <div class="alert alert-primary alert-dismissible" role="alert">
                    {{Session::get('message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                </div>
                @endif
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{Session::get('success')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    {{Session::get('error')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible" role="alert">
                    @foreach($errors->all() as $index => $error)
                        @if ($index > 0) <br> @endif
                        {{$error}}
                    @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                @yield('content')
            </div> 
            <footer>
               <img class="logo" src="{{ URL::asset('img/logo.png') }}"/>
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
        
    </body>
</html>