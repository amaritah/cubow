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
                <div id="floors"></div>
                <div id="scoring" class="row">
                    <h4 class="scoring-title col-12 ">{{__('public.scoringTitle')}}</h4>
                    <h4 class="hidden scoring-response col-12" >{{__('public.scoringResp')}}</h4>
                    <div class="row col-8">
                        <i class="far fa-frown-open col-3 fa-2x" data-score="1"></i>
                        <i class="far fa-meh fa-2x col-5"  data-score="2"></i>
                        <i class="far fa-smile fa-2x col-3"  data-score="3"></i>
                    </div>
                </div>
                <div id="map-scheme">
                    <svg viewBox="0 0 720 210">
                        <defs></defs>
                        <g> </g>
                    </svg>
                </div>
                <div id="main-content"></div>
                <div id="images" class="hidden">
                    
                </div>
            </div>
        </div>
        
        <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('js/popper.js') }}"></script>
        <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::asset('js/jquery-ui.min.js') }}"></script>
        <script src="{{ URL::asset('js/public.js') }}"></script>
        
    </body>
</html>