@extends('admin.admin-layout')

@section('title', ' - '.__('admin.listing').__('admin.promotions'))

@section('contentTitle')
<h1>{{__('admin.listing')}}{{__('admin.promotions')}}
    <a href="{{route('admin.promotions.new')}}" class="btn btn-success btn-md float-right">
        <i class="fa fa-plus-circle"></i> {{__('admin.new2')}} {{__('admin.promotion')}}
    </a>
</h1>
@endsection

@section('content')
<div class="col-12">
    <table id="datatable" class="table table-striped table-bordered display responsive" width="100%">
        <thead>
            <tr>
                <th class="all">{{__('admin.name')}}</th>
                <th>{{__('admin.room')}}</th>
                <th>{{__('admin.uses')}}</th>
                <th>{{__('admin.start_date')}}</th>
                <th>{{__('admin.end_date')}}</th>
                <th data-sortable="false">{{__('admin.edit')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($promotions as $promotion)
            <tr>
                <td>{{ $promotion->name }}</td>
                <td>{{ $promotion->room->name }}</td>
                <td>{{ $promotion->uses }}</td>
                <td> @if ($promotion->start) {{ date('d/m/Y',strtotime($promotion->start)) }} @endif</td>
                <td> @if ($promotion->end) {{ date('d/m/Y',strtotime($promotion->end)) }} @endif</td>
                <td class="print-hide">
                    <a href="{{route('admin.promotions.edit', $promotion->id)}}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

