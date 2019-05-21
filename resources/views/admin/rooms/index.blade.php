@extends('admin.admin-layout')

@section('title', ' - '.__('admin.listing').__('admin.rooms'))

@section('contentTitle')
<h1>{{__('admin.listing')}}{{__('admin.rooms')}}
</h1>
@endsection

@section('content')
<div class="col-12">
    <table id="datatable" class="table table-striped table-bordered display responsive" width="100%">
        <thead>
            <tr>
                <th class="all">{{__('admin.name')}}</th>
                <th>{{__('admin.floor')}}</th>
                <th>{{__('admin.owner')}}</th>
                <th>{{__('admin.category')}}</th>
                <th>{{__('admin.created_at')}}</th>
                <th>{{__('admin.updated_at')}}</th>
                <th data-sortable="false">{{__('admin.edit')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rooms as $room)
            <tr>
                <td>{{ $room->name }}</td>
                <td>{{ $room->floor->abbreviation }}</td>
                <td>{{ $room->user->name }}</td>
                <td>{{ $room->category->name }}</td>
                <td>{{ date('d/m/Y',strtotime($room->created_at)) }}</td>
                <td>{{ date('d/m/Y',strtotime($room->updated_at)) }}</td>
                <td class="print-hide">
                    <a href="{{route('admin.rooms.edit', $room->id)}}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

