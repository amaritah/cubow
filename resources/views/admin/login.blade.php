<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{config('app.name')}} - {{__('admin.loginTitle')}}</title>

        <link href="{{ URL::asset('css/fontawesome.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/bootstrap-vue.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/admin.css') }}" rel="stylesheet">
        
    </head>
    <body>
        <div class="container" style="position:relative;">
            
        </div>
       
        <script src="{{ URL::asset('js/vue.js') }}"></script>
        <script src="{{ URL::asset('js/portal-vue.min.js') }}"></script>
        <script src="{{ URL::asset('js/bootstrap-vue.min.js') }}"></script>
        <script src="{{ URL::asset('js/admin.js') }}"></script>
        
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