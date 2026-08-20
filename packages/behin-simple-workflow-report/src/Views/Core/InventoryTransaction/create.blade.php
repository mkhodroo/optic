@extends('behin-layouts.app')

@section('title', 'افزودن تراکنش محصول')

@php
    $totalBalance = 0;
@endphp


@section('content')
    <div class="card">
        <div class="card-header">
            افزودن تراکنش انبار محصول {{ $product->name }}
        </div>
        <div class="card-body table-responsive">
            <form action="{{ route('simpleWorkflowReport.inventory-transaction.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="form-group">
                    <label for="">تعداد</label>
                    <input type="text" name="quantity" id="" value="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">قیمت</label>
                    <input type="text" name="purchase_price" id="" value="" class="form-control formatted-digit">
                </div>
                <div class="form-group">
                    <label for="">واحد</label>
                    <input type="text" name="unit" id="" value="{{ $product->unit }}" class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label for="">واحد</label>
                    <input type="text" name="inventory_transaction_type" id="" value="{{ request('inventory_transaction_type') == 'افزایش' ? 'افزایش' : 'کاهش' }}" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="">توضیحات</label>
                    <textarea name="note" id="" rows="10" class="form-control"></textarea>
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
