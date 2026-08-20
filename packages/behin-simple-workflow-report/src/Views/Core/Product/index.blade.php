@extends('behin-layouts.app')

@section('title', 'لیست محصولات')

@php
    $totalBalance = 0;
@endphp


@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{ route('simpleWorkflowReport.product.create') }}" class="btn btn-sm btn-outline-primary">
            ایجاد
        </a>
    </div>
</div>
    <div class="card">
        <div class="card-header">
            بالانس کل: <span id="total-balance"></span>
        </div>
        <div class="card-body table-responsive">
            <table class="table tabel-bordered">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>محصول</th>
                        <th>sku</th>
                        <th>بالانس</th>
                        <th>مانده</th>
                        <th>واحد</th>
                        <th>اقدامات</th>
                    </tr>
                </thead>
                @foreach ($rows as $row)
                @php
                    $totalBalance += $row->balance();
                @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->name ?? '' }}</td>
                        <td>[[ $row->sku ]]</td>
                        <td dir="ltr">[[ number_format($row->balance()) ]]</td>
                        <td dir="ltr">[[ number_format($row->remainder()) ]]</td>
                        <td>[[ $row->unit ]]</td>
                        <td>
                            <a href="{{ route('simpleWorkflowReport.product.edit', $row->id) }}" class="btn btn-sm btn-outline-primary">
                                ویرایش
                            </a>
                            <a href="{{ route('simpleWorkflowReport.inventory-transaction.index') }}?product_id={{ $row->id }}" class="btn btn-sm btn-outline-warning">
                                نمایش ورود/خروج های انبار
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#total-balance').html('[[ number_format($totalBalance) ]]')
    </script>
@endsection