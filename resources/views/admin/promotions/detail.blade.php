@extends('admin.admin-layout', ['selectedMenu' => 'promotions'])

@section('contentTitle')
<h1>
    @if ($id) 
    {{__('admin.detail').$name}}
    @section('title', ' - '.__('admin.detail').$name)
    @else 
    {{__('admin.new2').' '.__('admin.promotion')}}
    @section('title', ' - '.__('admin.new2').' '.__('admin.promotion'))
    @endif
</h1>
@endsection

@section('content')
<div class="col-12 form-container">
    @if ($id)
    <form method="post" action="{{route('admin.promotions.imageUpload', $id)}}" enctype="multipart/form-data" style="margin: 2em 0;" class="dropzone" id="myAwesomeDropzone">
    <h3 style="margin-bottom: 2em;">{{__('admin.promotion_img')}}</h3>
        @csrf
    </form> 
    @endif
    <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="@if($id) {{route('admin.promotions.update', $id)}} @else {{route('admin.promotions.store')}} @endif">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="form-group col-xl-6 col-sm-12 col-xs-12 col-lg-6 col-md-6">
                <label for="name" class=" control-label">
                    {{__('admin.name')}}
                </label>
                <div class="">
                    <input type="text" class="form-control" name="name" id="name" value="{{ $name }}">
                </div>
            </div>

            <div class="form-group col-xl-4 col-sm-12 col-xs-12 col-lg-4 col-md-4">
                <label for="room_id" class=" control-label">
                    {{__('admin.room')}}
                </label>
                <div class=" ">
                    <select name="room_id" class="form-control selectpicker" name="room_id" id="room_id" data-live-search="true">
                        <option value=""></option>
                        @foreach($rooms as $room)
                        <option value="{{$room->id}}" @if($room->id == $room_id)selected="selected" @endif>{{$room->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-xl-2 col-sm-12 col-xs-12 col-lg-2 col-md-2">
                <label for="qr" class=" control-label">
                    {{__('admin.QR')}}
                </label>
                <div class=" ">
                    <select name="qr" class="form-control selectpicker" name="qr" id="qr" data-live-search="true">
                        <option value="0" @if (!$qr) selected @endif>{{__('admin.no')}}</option>
                        <option value="1" @if ($qr) selected @endif>{{__('admin.yes')}}</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-xl-6 col-sm-12 col-xs-12 col-lg-6 col-md-6">
                <label for="start" class=" control-label">
                    {{__('admin.start_date')}}
                </label>
                <div class="">
                    <input type="text" class="form-control datetimepicker-input" id="start" data-toggle="datetimepicker" data-target="#start" name="start">
                </div>
            </div>
            <div class="form-group col-xl-6 col-sm-12 col-xs-12 col-lg-6 col-md-6">
                <label for="end" class=" control-label">
                    {{__('admin.end_date')}}
                </label>
                <div class="">
                    <input type="text" class="form-control datetimepicker-input" id="end" data-toggle="datetimepicker" data-target="#end"  name="end">
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

@if($id && false)
<div id="delete-entity" class="hidden">
    <form method="POST" action="{{ route('admin.promotions.destroy',$id) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="DELETE">
        <p  class="text-center">
            {{__('admin.askDelete')}} {{__('admin.promotion')}}?
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
<script>
$(function () {
    $('#start').datetimepicker({
        locale: 'es',
        format: 'L',
        @if ($start)
        viewDate: moment('{{$start}}', 'DD/MM/YYYY'),
        date: moment('{{$start}}', 'DD/MM/YYYY'),
        @endif
    });
    $('#end').datetimepicker({
        locale: 'es',
        format: 'L',
        @if ($end)
        viewDate: moment("{{$end}}", 'DD/MM/YYYY'),
        date: moment('{{$end}}', 'DD/MM/YYYY'),
        @endif
    });
});
</script>
@if ($id)
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
<script>
var myDropZone = Dropzone.options.myAwesomeDropzone = {
   maxFilesize: 12,
   maxFiles: 1,
   renameFile: function(file) {
       var dt = new Date();
       var time = dt.getTime();
      return time+file.name;
   },
   acceptedFiles: ".jpeg,.jpg,.png,.gif",
   timeout: 50000,
   dictDefaultMessage: "{{__('admin.dropzone')}}",
   dictRemoveFile: "{{__('admin.delete')}}",
   dictCancelUpload: "{{__('admin.cancel')}}",
   addRemoveLinks: true,
   removedfile: function(file) 
   {
       var name = (typeof(file.upload) == 'undefined')?file.name: file.upload.filename;
       $.ajax({
           headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
           },
           type: 'POST',
           url: '{{ route("admin.rooms.imageDelete") }}',
           data: {filename: name},
           success: function (data){
               console.log("Archivo eliminado.");
           },
           error: function(e) {
               console.log(e);
           }});
           var fileRef;
           return (fileRef = file.previewElement) != null ? 
           fileRef.parentNode.removeChild(file.previewElement) : void 0;
   },
   success: function(file, response) 
   {
       console.log(response);
   },
   error: function(file, response)
   {
      return false;
   },
    init: function () {
        
        @if($img_path)
            var mockFile = { name: "{{str_replace('/images/rooms/', '', $img_path)}}"};     
            this.options.addedfile.call(this, mockFile);
            this.files.push(mockFile); // here you add them into the files array
            this.options.thumbnail.call(this, mockFile, "{{$img_path}}");
            mockFile.previewElement.classList.add('dz-success');
            mockFile.previewElement.classList.add('dz-complete');
        @endif
    }
};
</script>
@endif
@endsection 

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
@endsection