@extends('behin-layouts.app')

@section('title', '')

@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{ route('view-builder.create') }}" class="btn btn-sm btn-outline-primary">
            ایجاد
        </a>
    </div>

</div>
<div class="card">
    <div class="card-header">

    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام روت</th>
                    <th>روت</th>
                    <th>تاریخ ایجاد</th>
                    <th>اقدامات</th>
                </tr>
            </thead>
            @foreach ($rows as $row)
                <tr>
                    <td>[[ $loop->iteration ]]</td>
                    <td>[[ $row->route_name ]]</td>
                    <td>[[ $row->route_path ]]</td>
                    <td>[[ toJalali($row->created_at) ]]</td>
                    <td>
                        <a href="{{ route('view-builder.edit', $row->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection