<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{config('app.name')}}</title>

        <link href="{{ URL::asset('css/fontawesome.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/jquery-ui.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/public.css') }}" rel="stylesheet">
        
        
    </head>
    <body>
        <div class="container">
            <div id="loader">
                <div class="wrap">
                    <img class="logo" src="{{ URL::asset('img/logo-icon.png') }}"/>
                    <div class="loading">
                        <div class="bounceball"></div>
                        <div class="loading-text">{{__('public.loading')}}</div>
                    </div>
                </div>
            </div>
            
            <div id="content" class="hidden">
                poner PISOS arriba izquierda.
                Poner caritas arriba CENTRO
                CENTRO planos
                ABAJO es para las salas.
            </div>
        </div>
        
        <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('js/popper.js') }}"></script>
        <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::asset('js/jquery-ui.min.js') }}"></script>
        <script src="{{ URL::asset('js/public.js') }}"></script>
        
    </body>
</html>