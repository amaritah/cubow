@extends('admin.admin-layout', ['selectedMenu' => $selectedMenu])

@section('contentTitle')
<h1>
    @if ($id) 
    {{__('admin.detail').$name}}
    @section('title', ' - '.__('admin.detail').$name)
    @else 
    {{__('admin.new').' '.__('admin.user')}}
    @section('title', ' - '.__('admin.new').' '.__('admin.user'))
    @endif
    @if ($selectedMenu != 'profile')
    <a href="{{route('admin.users')}}" class="btn btn-success btn-md float-right">
        <i class="fa fa-angle-left"></i> {{__('admin.goBack')}}
    </a>
    @endif
</h1>
@endsection

@section('content')
<div class="col-12 form-container">
    <form class="form-horizontal" role="form" method="POST" action="@if($id) {{route('admin.users.update', $id)}} @else {{route('admin.users.store')}} @endif">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="form-group col-xl-6 col-sm-12 col-xs-12 col-lg-6 col-md-6">
                <label for="title" class=" control-label">
                    {{__('admin.name')}}
                </label>
                <div class=" ">
                    <input type="text" class="form-control" name="name" id="name" value="{{ $name }}">
                </div>
            </div>


            <div class="form-group col-xl-6 col-sm-12 col-xs-12 col-lg-6 col-md-6">
                <label for="email" class=" control-label">
                    {{__('admin.email')}}
                </label>
                <div class=" ">
                    <input type="text" class="form-control" name="email" id="email" value="{{ $email }}">
                </div>
            </div>
            <div class="form-group  col-xl-6 col-sm-12 col-xs-12 col-lg-6 col-md-6">
                <label for="password" class=" control-label">
                    {{__('admin.password')}}
                </label>
                <div class="">
                    <input type="password" class="form-control" name="password" id="password" value="">
                </div>
            </div>
            <div class="form-group col-xl-6 col-sm-12 col-xs-12 col-lg-6 col-md-6">
                <label for="password_confirmation" class=" control-label">
                    {{__('admin.confirmPass')}}
                </label>
                <div class=" ">
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="">
                </div>
            </div>
            <div class="form-group col-xl-6 col-sm-12 col-xs-12 col-lg-6 col-md-6 @if(Auth::user()->role_id > 1) hidden @endif">
                <label for="role" class=" control-label">
                    {{__('admin.role')}}
                </label>
                <div class=" ">
                    <select  name="role_id" class="form-control selectpicker" name="role_id" id="role_id" data-live-search="true">
                        @foreach($roles as $role)
                            @if(Auth::user()->role_id < 2 || $role->id == $role_id)
                                <option value="{{$role->id}}" @if($role->id == $role_id)selected="selected" @endif>{{$role->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-12 buttons-container">
            <button type="submit" class="btn btn-success btn-md">
                <i class="fa fa-plus-circle"></i>
                {{__('admin.save')}}
            </button>
            @if($id && $selectedMenu != 'profile')
            <button type="submit" class="btn btn-info btn-md delete-entity" data-delete="{{$id}}">
                <i class="fa fa-times-circle"></i>
                {{__('admin.delete')}}
            </button>
            @endif
        </div>
    </form>
</div>

@if($id)
<div id="delete-entity" class="hidden">
    <form method="POST" action="{{ route('admin.users.destroy',$id) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="DELETE">
        <p  class="text-center">
            {{__('admin.askDelete')}} {{__('admin.user')}}?
        </p>
        <div class="buttons-container">
            <button type="button" class="btn btn-success close-modal" data-dismiss="modal">{{__('admin.cancel')}}</button>
            <button type="submit" class="btn btn-info">{{__('admin.confirmDelete')}}
            </button>
        </div>
    </form>
</div>
@endif
@endsection

