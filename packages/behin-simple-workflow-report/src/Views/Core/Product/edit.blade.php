@extends('behin-layouts.app')

@section('title', 'ویرایش محصول')

@php
    $backUrl = route('simpleWorkflowReport.product.index');
    $totalBalance = 0;
@endphp


@section('content')
    <div class="card">
        <div class="card-header">
            ویرایش محصول
        </div>
        <div class="card-body table-responsive">
            <form action="{{ route('simpleWorkflowReport.product.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">نام</label>
                    <input type="text" name="name" id="" value="{{ $product->name }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">sku</label>
                    <input type="text" name="sku" id="" value="{{ $product->sku }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">واحد</label>
                    <input type="text" name="unit" id="" value="{{ $product->unit }}" class="form-control">
                </div>
                <div class="form-group d-flex align-items-end">
                    <button type="submit" class="btn btn-sm btn-primary">ویرایش</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
@endsection
