@extends('admin.admin-layout', ['selectedMenu' => 'rooms'])

@section('contentTitle')
<h1>
    @if ($id) 
    {{__('admin.detail').$name}}
    @section('title', ' - '.__('admin.detail').$name)
    @else 
    {{__('admin.new2').' '.__('admin.room')}}
    @section('title', ' - '.__('admin.new2').' '.__('admin.room'))
    @endif
</h1>
@endsection

@section('content')
<div class="col-12 form-container">
    <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="@if($id) {{route('admin.rooms.update', $id)}} @else {{route('admin.rooms.store')}} @endif">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="form-group col-xl-6 col-sm-12 col-xs-12 col-lg-6 col-md-6">
                <label for="title" class=" control-label">
                    {{__('admin.name')}}
                </label>
                <div class="">
                    <input type="text" class="form-control" name="name" id="name" value="{{ $name }}">
                </div>
            </div>

            <div class="form-group @if($disabled) hidden @endif col-xl-4 col-sm-12 col-xs-12 col-lg-4 col-md-4">
                <label for="user_id" class=" control-label">
                    {{__('admin.owner')}}
                </label>
                <div class=" ">
                    <select name="user_id" @if($disabled) disabled @endif class="form-control selectpicker" name="user_id" id="user_id" data-live-search="true">
                        <option value=""></option>
                        @foreach($users as $user)
                        <option value="{{$user->id}}" @if($user->id == $user_id)selected="selected" @endif>{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-group col-xl-2 @if($disabled) hidden @endif col-sm-12 col-xs-12 col-lg-2 col-md-2">
                <label for="floor_id" class=" control-label">
                    {{__('admin.floor')}}
                </label>
                <div class=" ">
                    <select name="floor_id" @if($disabled) disabled @endif class="form-control selectpicker" name="floor_id" id="floor_id" data-live-search="true">
                        @foreach($floors as $floor)
                        <option value="{{$floor->id}}" @if($floor->id == $floor_id)selected="selected" @endif>{{$floor->abbreviation}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-xl-6 col-sm-12 col-xs-12 col-lg-6 col-md-6">
                <label for="title" class=" control-label">
                    {{__('admin.email')}}
                </label>
                <div class="">
                    <input type="text" class="form-control" name="email" id="email" value="{{ $email }}">
                </div>
            </div>
            <div class="form-group col-xl-6 col-sm-12 col-xs-12 col-lg-6 col-md-6">
                <label for="title" class=" control-label">
                    {{__('admin.phone')}}
                </label>
                <div class="">
                    <input type="text" class="form-control" name="phone" id="phone" value="{{ $phone }}">
                </div>
            </div>
            <div class="form-group col-xl-12 col-sm-12 col-xs-12 col-lg-12 col-md-12">
                <label for="description" class=" control-label">
                    {{__('admin.description')}}
                </label>
                <div class="">
                    <textarea class="form-control ckeditor" name="description" name="description" id="description">{{$description}}</textarea>
                </div>
            </div>

            <div class="form-group @if($disabled) hidden @endif col-xl-6 col-sm-12 col-xs-12 col-lg-6 col-md-6">
                <label for="scheme" class=" control-label">
                    {{__('admin.scheme')}}
                </label>
                <div class="">
                    <textarea  @if($disabled) disabled @endif class="form-control" name="scheme" name="scheme" id="scheme">{!! $scheme !!}</textarea>
                </div>
            </div>
            <div class="form-group col-xl-6 @if($disabled) hidden @endif col-sm-12 col-xs-12 col-lg-6 col-md-6">
                <label for="scheme" class=" control-label">
                    {{__('admin.preview')}}
                </label>
                <div id="preview">
                    <svg style="width:100%; height: 300px;">
                        <defs></defs>
                        <g >
                            {!! $scheme !!}
                        </g>
                    </svg>
                    
                </div>
            </div>
            
        </div>
        <div class="col-12 buttons-container">
            <button type="submit" class="btn btn-success btn-md">
                <i class="fa fa-plus-circle"></i>
                {{__('admin.save')}}
            </button>
            @if($id)
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
    <form method="POST" action="{{ route('admin.rooms.destroy',$id) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="DELETE">
        <p  class="text-center">
            {{__('admin.askDelete')}} {{__('admin.room')}}?
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


@section('scripts')
<script src="{{ URL::asset('ckeditor/ckeditor.js') }}"></script>
<script >
$(function () {
    $('#scheme').on('change', function(){
        $('#preview svg g').html($(this).val());
    });
});
</script>
@endsection 
