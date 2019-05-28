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
        <link href="{{ URL::asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/datatables.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/datatables-responsive.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/fileinput.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/jquery-ui.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/admin.css') }}" rel="stylesheet">
    </head>
    <body >
        <div class="container" >
            <div id="login-container">
                <div id="login-box">
                    <img class="login-logo" src="{{ URL::asset('img/logo-name.png') }}"/>
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
                    <div id="form-login" class="">
                        <form class="form-horizontal clearfix row" role="form" method="post" action="{{route('login')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="col-8">
                                <div class="form-group">
                                    <input type="text" placeholder="{{__('admin.email')}}" class="form-control" name="email"/>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <input placeholder="{{__('admin.password')}}" type="password" class="form-control" name="password" />
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="form-group">

                                    <label class="form-check-label" for="remember" style="color:white; margin-left: 2em;">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        {{ __('admin.remember') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-danger">{{__('admin.access')}}</button>
                                </div>
                            </div>
                            <a class="resetPass">{{__('admin.resetPass')}}</a>
                        </form>
                    </div>
                    <div id="password-reset" class="hidden">
                        <form method="POST" class="form-horizontal clearfix row" action="{{ route('password.email') }}">
                            {!! csrf_field() !!}
                            <div class="col-8">
                                <div class="form-group">
                                    <input type="email" required placeholder="{{__('admin.email')}}" class="form-control" name="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-12" style="text-align:center;">
                                    <button type="submit" class="btn btn-danger">{{__('admin.sendReset')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
        <script>
            $(function(){
                $('.resetPass').on('click', function(){
                    $('#form-login').hide();
                    $('#password-reset').removeClass('hidden');
                });
            });
        </script>
    </body>
</html>