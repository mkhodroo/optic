@extends('behin-layouts.app')

@section('title', '')

@php
    $backUrl = route('view-builder.index');
@endphp

@section('content')
<div class="card">
    <div class="card-header">
        ایجاد نمای جدید
    </div>
    <div class="card-body">
        <form action="{{ route('view-builder.update', $viewBuilder->id) }}" method="POST" class="align-items-left" dir="ltr">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="">Route name</label>
                <input type="text" name="route_name" id="" class="form-control" value="[[ $viewBuilder->route_name ]]">
            </div>
            <div class="form-group">
                <label for="">Route url</label>
                <input type="text" name="route_path" id="" class="form-control" value="[[ $viewBuilder->route_path ]]">
            </div>
            <div class="form-group">
                <label for="">Permission name</label>
                <input type="text" name="permission_name" id="" class="form-control" value="[[ $viewBuilder->permission_name ]]">
            </div>
            <div class="form-group">
                <label for="">Middlewares</label>
                <input type="text" name="middleware" id="" class="form-control" value="[[ $viewBuilder->middleware ]]">
            </div>
            <div class="form-group">
                <label for="">Main entity</label>
                <input type="text" name="main_entity" id="" class="form-control" value="[[ $viewBuilder->main_entity ]]">
            </div>
            <div class="form-group">
                <label for="">Display columns</label>
                <input type="text" name="display_columns" id="" class="form-control" value="[[ $viewBuilder->display_columns ]]">
            </div>
            <div class="form-group">
                <label for="">Advanced search form</label>
                <input type="text" name="advanced_search_form_id" id="" class="form-control" value="[[ $viewBuilder->advanced_search_form_id ]]">
            </div>
            <div class="form-group">
                <label for="">After search script</label>
                <input type="text" name="after_search_script_id" id="" class="form-control" value="[[ $viewBuilder->after_search_script_id ]]">
            </div>
            <div class="form-group">
                <label for="">Before display script</label>
                <input type="text" name="before_display_rows_script" id="" class="form-control" value="[[ $viewBuilder->before_display_rows_script ]]">
            </div>
            <div class="form-group">
                <label for="">Detail view form</label>
                <input type="text" name="detail_view_form_id" id="" class="form-control" value="[[ $viewBuilder->detail_view_form_id ]]">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-outline-primary">ویرایش</button>
            </div>
        </form>
    </div>

</div>
@endsection