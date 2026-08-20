@extends('behin-layouts.app')

@section('title', 'افزودن محصول')

@php
    $backUrl = route('simpleWorkflowReport.product.index');
    $totalBalance = 0;
@endphp


@section('content')
    <div class="card">
        <div class="card-header">
            افزودن محصول
        </div>
        <div class="card-body table-responsive">
            <form action="{{ route('simpleWorkflowReport.product.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">نام</label>
                    <input type="text" name="name" id="" value="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">sku</label>
                    <input type="text" name="sku" id="" value="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">واحد</label>
                    <input type="text" name="unit" id="" value="" class="form-control">
                </div>
                <div class="form-group d-flex align-items-end">
                    <button type="submit" class="btn btn-sm btn-primary">افزودن</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
@endsection
