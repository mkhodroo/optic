@extends('behin-layouts.app')

@section('title', 'جزئیات مشتری')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">
                <a href="{{ route('simpleWorkflowReport.customers.index') }}"
                    class="btn btn-sm btn-outline-secondary ml-2">
                    <i class="fa fa-arrow-right"></i>
                    بازگشت به لیست
                </a>
                جزئیات مشتری
            </h4>
            <div class="d-flex gap-2">
                @if ($customer->is_active)
                    <a href="{{ route('simpleWorkflowReport.customers.disable', $customer) }}"
                        class="btn btn-sm btn-outline-warning"
                        onclick="return confirm('آیا از غیرفعال کردن این مشتری مطمئن هستید؟');">
                        <i class="fa fa-ban"></i>
                        غیرفعال کردن
                    </a>
                @else
                    <a href="{{ route('simpleWorkflowReport.customers.enable', $customer) }}"
                        class="btn btn-sm btn-outline-success">
                        <i class="fa fa-check"></i>
                        فعال کردن
                    </a>
                @endif
                <button class="btn btn-sm btn-outline-secondary" data-toggle="modal"
                    data-target="#editCustomerModal"
                    data-action="{{ route('simpleWorkflowReport.customers.update', $customer) }}"
                    data-fullname="{{ e($customer->fullname) }}"
                    data-national-id="{{ e($customer->national_id) }}"
                    data-mobile="{{ e($customer->mobile) }}"
                    data-address="{{ e($customer->address) }}"
                    data-customer-job="{{ e($customer->customer_job) }}">
                    <i class="fa fa-pencil"></i>
                    ویرایش
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Customer info card --}}
        <div class="card mb-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">اطلاعات تماس</h5>
                @if ($customer->is_active)
                    <span class="badge badge-success">فعال</span>
                @else
                    <span class="badge badge-secondary">غیرفعال</span>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>نام و نام خانوادگی:</strong> {{ $customer->fullname }}</p>
                        <p><strong>کد ملی:</strong> <span dir="ltr">{{ $customer->national_id ?: '—' }}</span></p>
                        <p><strong>شماره موبایل:</strong> <span dir="ltr">{{ $customer->mobile ?: '—' }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>شغل:</strong> {{ $customer->customer_job ?: '—' }}</p>
                        <p><strong>تاریخ ثبت:</strong>
                            {{ optional($customer->created_at)->format('Y-m-d H:i') ?: '—' }}
                        </p>
                        <p><strong>آخرین به‌روزرسانی:</strong>
                            {{ optional($customer->updated_at)->format('Y-m-d H:i') ?: '—' }}
                        </p>
                    </div>
                    <div class="col-12">
                        <hr>
                        <p><strong>آدرس:</strong></p>
                        <p class="text-muted">{!! nl2br(e($customer->address ?? '—')) !!}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats cards --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center border-primary">
                    <div class="card-body">
                        <h2 class="text-primary">{{ $stats['total_cases'] }}</h2>
                        <p class="mb-0 text-muted">کل پرونده‌ها</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center border-warning">
                    <div class="card-body">
                        <h2 class="text-warning">{{ $stats['open_cases'] }}</h2>
                        <p class="mb-0 text-muted">پرونده‌های در دست اقدام</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center border-success">
                    <div class="card-body">
                        <h2 class="text-success">{{ $stats['done_cases'] }}</h2>
                        <p class="mb-0 text-muted">پرونده‌های تکمیل‌شده</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Case history table --}}
        <div class="card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">تاریخچه پرونده‌ها</h5>
                <span class="badge badge-secondary">{{ $cases->count() }} پرونده</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0" id="case-history-table">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">ردیف</th>
                                <th>شماره پرونده</th>
                                <th>وضعیت</th>
                                <th>کد پستی</th>
                                <th>شماره اقتصادی</th>
                                <th>آدرس</th>
                                <th>تاریخ ثبت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cases as $case)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($case->case_number)
                                            <a href="{{ route('simpleWorkflow.inbox.caseHistoryView', $case->case_number) }}"
                                                class="text-primary" target="_blank">
                                                {{ $case->case_number }}
                                            </a>
                                        @else
                                            <span class="text-muted">#{{ $case->case_id }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusLabel = match($case->status) {
                                                'done' => '<span class="badge badge-success">تکمیل‌شده</span>',
                                                'canceled' => '<span class="badge badge-danger">لغو‌شده</span>',
                                                'inProgress' => '<span class="badge badge-warning">در دست اقدام</span>',
                                                default => '<span class="badge badge-secondary">' . e($case->status ?? 'نامشخص') . '</span>'
                                            };
                                        @endphp
                                        {!! $statusLabel !!}
                                    </td>
                                    <td dir="ltr">{{ $case->postal_code ?: '—' }}</td>
                                    <td dir="ltr">{{ $case->eco_number ?: '—' }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($case->address ?? '', 50, '…') ?: '—' }}</td>
                                    <td>{{ optional(\Illuminate\Support\Carbon::parse($case->created_at))->format('Y-m-d H:i') ?: '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        این مشتری هنوز پرونده‌ای ندارد.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editCustomerModal" tabindex="-1" role="dialog"
        aria-labelledby="editCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCustomerModalLabel">ویرایش مشتری</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="بستن">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="#" id="edit-customer-form">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit-fullname">نام و نام خانوادگی <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit-fullname" name="fullname" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-national-id">کد ملی</label>
                            <input type="text" class="form-control" id="edit-national-id" name="national_id">
                        </div>
                        <div class="form-group">
                            <label for="edit-mobile">شماره موبایل</label>
                            <input type="text" class="form-control" id="edit-mobile" name="mobile">
                        </div>
                        <div class="form-group">
                            <label for="edit-address">آدرس</label>
                            <textarea class="form-control" id="edit-address" name="address" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit-customer-job">شغل</label>
                            <textarea class="form-control" id="edit-customer-job" name="customer_job"
                                rows="3" placeholder='مثال: {"title": "مهندس", "industry": "نرم‌افزار", "experience": "۵ سال"}'>
                            </textarea>
                            <small class="text-muted">فرمت اختیاری JSON: {"title", "industry", "experience"}</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                        <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#case-history-table').DataTable({
                paging: false,
                searching: false,
                ordering: true,
                info: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/fa.json'
                },
                order: []
            });

            $('#editCustomerModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const action = button.data('action');
                const fullname = button.data('fullname') || '';
                const nationalId = button.data('nationalId') || '';
                const mobile = button.data('mobile') || '';
                const address = button.data('address') || '';
                const customerJob = button.data('customerJob') || '';

                const modal = $(this);
                const form = modal.find('form');

                form.attr('action', action);
                form.find('input[name="fullname"]').val(fullname);
                form.find('input[name="national_id"]').val(nationalId);
                form.find('input[name="mobile"]').val(mobile);
                form.find('textarea[name="address"]').val(address);
                form.find('textarea[name="customer_job"]').val(customerJob);
            });
        });
    </script>
@endsection
