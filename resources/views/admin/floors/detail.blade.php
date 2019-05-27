@extends('admin.admin-layout', ['selectedMenu' => 'floors'])

@section('contentTitle')
<h1>
    @if ($id) 
    {{__('admin.detail').$name}}
    @section('title', ' - '.__('admin.detail').$name)
    @else 
    {{__('admin.new').' '.__('admin.floor')}}
    @section('title', ' - '.__('admin.new').' '.__('admin.floor'))
    @endif
</h1>
@endsection

@section('content')
<div class="col-12 form-container">
    <form class="form-horizontal" role="form" method="POST" action="@if($id) {{route('admin.floors.update', $id)}} @else {{route('admin.floors.store')}} @endif">
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
                <label for="abbreviation" class=" control-label">
                    {{__('admin.abbv')}}
                </label>
                <div class=" ">
                    <input type="text" class="form-control" name="abbreviation" id="abbreviation" value="{{ $abbreviation }}">
                </div>
            </div>
        </div>
        <div class="col-12 buttons-container">
            <button type="submit" class="btn btn-success btn-md">
                <i class="fa fa-plus-circle"></i>
                {{__('admin.save')}}
            </button>
            @if($id && false)
            <button type="submit" class="btn btn-info btn-md delete-entity" data-delete="{{$id}}">
                <i class="fa fa-times-circle"></i>
                {{__('admin.delete')}}
            </button>
            @endif
        </div>
    </form>
</div>

@if($id && false)
<div id="delete-entity" class="hidden">
    <form method="POST" action="{{ route('admin.floors.destroy',$id) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="DELETE">
        <p  class="text-center">
            {{__('admin.askDelete')}} {{__('admin.floor')}}?
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

