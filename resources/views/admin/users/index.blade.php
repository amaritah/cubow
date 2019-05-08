@extends('admin.admin-layout')

@section('title', ' - Listado de Usuarios')

@section('content')
<h1 class="pull-left">{{__('admin.listing')}} {{__('admin.users')}}
    <a href="{{route('admin.users.new')}}" class="btn btn-success btn-md float-right">
        <i class="fa fa-plus-circle"></i> {{__('admin.new')}} {{__('admin.user')}}
    </a>
</h1>
<div class="col-12">
    <table id="users-table" class="table table-striped table-bordered display responsive" width="100%">
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
                <td>{{ $user->role }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->role }}</td>
                <td class="print-hide">
                    <a href="/admin/user/{{ $user->id }}/edit" class="btn btn-xs btn-info"><i class="fa fa-edit"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    $(function () {
        $("#users-table").DataTable({
            "pageLength": 10,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json"
            }
        });
    });
</script>
@stop
