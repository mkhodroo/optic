@extends('behin-layouts.app')

@section('title', 'لیست تراکنش های انبار محصول')

@php
    $backUrl = route('simpleWorkflowReport.product.index');
    $totalBalance = 0;
@endphp


@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{ route('simpleWorkflowReport.inventory-transaction.create', [ 
            "product" => request('product_id'),
            "inventory_transaction_type" => 'افزایش'
        ] ) }}" class="btn btn-sm btn-outline-primary">
            ورود کالا به انبار
        </a>
        <a href="{{ route('simpleWorkflowReport.inventory-transaction.create', request('product_id') ) }}" class="btn btn-sm btn-outline-warning">
            خروج کالا از انبار
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
                        <th>نوع تراکنش</th>
                        <th>تعداد</th>
                        <th>قیمت</th>
                        <th>اقدامات</th>
                    </tr>
                </thead>
                @foreach ($rows as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->product?->name ?? '' }}</td>
                        <td>[[ $row->inventory_transaction_type ]]
                            @if ($row->inventory_transaction_type == 'کاهش')
                                (فروش)
                            @else
                                (خرید)
                            @endif
                        </td>
                        <td dir="ltr">[[ number_format($row->quantity) ]]</td>
                        <td dir="ltr">[[ number_format($row->purchase_price) ]]</td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteRow('{{ $row->id }}')">
                                <i class="fa fa-trash"></i>
                            </button>
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
        
        function deleteRow(id){
            var fd = new FormData();
            fd.append('_method', 'delete')
            var url = '{{ route('simpleWorkflowReport.inventory-transaction.delete', 'inventory_id') }}';
            url = url.replace('inventory_id', id);
            send_ajax_formdata_request_with_confirm(
                url,
                fd,
                function(response){
                    show_message(response.message);
                }
            )
        }
    </script>

@endsection