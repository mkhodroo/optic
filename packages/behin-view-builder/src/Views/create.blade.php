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
        <form action="{{ route('view-builder.store') }}" method="POST" class="align-items-left" dir="ltr">
            @csrf
            <div class="form-group">
                <label for="">Route name</label>
                <input type="text" name="route_name" id="" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Route url</label>
                <input type="text" name="route_path" id="" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Permission name</label>
                <input type="text" name="permission_name" id="" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Middlewares</label>
                <input type="text" name="middleware" id="" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Main entity</label>
                <input type="text" name="main_entity" id="" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Display columns</label>
                <input type="text" name="display_columns" id="" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Advanced search form</label>
                <input type="text" name="advanced_search_form_id" id="" class="form-control">
            </div>
            <div class="form-group">
                <label for="">After search script</label>
                <input type="text" name="after_search_script_id" id="" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Before display script</label>
                <input type="text" name="before_display_rows_script" id="" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Detail view form</label>
                <input type="text" name="detail_view_form_id" id="" class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-outline-primary">ذخیره</button>
            </div>
        </form>
    </div>

</div>
@endsection