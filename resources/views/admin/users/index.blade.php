@extends('admin.admin-layout')

@section('title', ' - '.__('admin.listing').__('admin.users'))

@section('contentTitle')
<h1>{{__('admin.listing')}}{{__('admin.users')}}
    <a href="{{route('admin.users.new')}}" class="btn btn-success btn-md float-right">
        <i class="fa fa-plus-circle"></i> {{__('admin.new')}} {{__('admin.user')}}
    </a>
</h1>
@endsection

@section('content')
<div class="col-12">
    <table id="datatable" class="table table-striped table-bordered display responsive" width="100%">
        <thead>
            <tr>
                <th class="all">{{__('admin.name')}}</th>
                <th>{{__('admin.email')}}</th>
                <th>{{__('admin.role')}}</th>
                <th>{{__('admin.created_at')}}</th>
                <th>{{__('admin.updated_at')}}</th>
                <th data-sortable="false">{{__('admin.edit')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role->name }}</td>
                <td>{{ date('d/m/Y',strtotime($user->created_at)) }}</td>
                <td>{{ date('d/m/Y',strtotime($user->updated_at)) }}</td>
                <td class="print-hide">
                    <a href="{{route('admin.users.edit', $user->id)}}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

