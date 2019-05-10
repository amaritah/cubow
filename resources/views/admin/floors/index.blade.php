@extends('admin.admin-layout')

@section('title', ' - '.__('admin.listing').__('admin.floors'))

@section('contentTitle')
<h1>{{__('admin.listing')}}{{__('admin.floors')}}
    <a href="{{route('admin.floors.new')}}" class="btn btn-success btn-md float-right">
        <i class="fa fa-plus-circle"></i> {{__('admin.new')}} {{__('admin.floor')}}
    </a>
</h1>
@endsection

@section('content')
<div class="col-12">
    <table id="datatable" class="table table-striped table-bordered display responsive" width="100%">
        <thead>
            <tr>
                <th class="all">{{__('admin.abbv')}}</th>
                <th>{{__('admin.name')}}</th>
                <th>{{__('admin.created_at')}}</th>
                <th>{{__('admin.updated_at')}}</th>
                <th data-sortable="false">{{__('admin.edit')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($floors as $floor)
            <tr>
                <td>{{ $floor->abbreviation }}</td>
                <td>{{ $floor->name }}</td>
                <td>{{ date('d/m/Y',strtotime($floor->created_at)) }}</td>
                <td>{{ date('d/m/Y',strtotime($floor->updated_at)) }}</td>
                <td class="print-hide">
                    <a href="{{route('admin.floors.edit', $floor->id)}}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

