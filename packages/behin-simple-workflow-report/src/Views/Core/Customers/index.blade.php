@extends('behin-layouts.app')

@section('title', 'مدیریت مشتریان')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">مدیریت مشتریان</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('simpleWorkflowReport.customers.export', array_merge($search, ['show_inactive' => $showInactive])) }}"
                        class="btn btn-success btn-sm">
                        <i class="fa fa-file-excel"></i>
                        خروجی اکسل
                    </a>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createCustomerModal">
                        <i class="fa fa-plus"></i>
                        افزودن مشتری جدید
                    </button>
                </div>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Search / Filter form --}}
                <form method="GET" action="{{ route('simpleWorkflowReport.customers.index') }}" class="mb-3">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label small mb-1">نام و نام خانوادگی</label>
                            <input type="text" name="fullname" class="form-control form-control-sm"
                                value="{{ e($search['fullname'] ?? '') }}" placeholder="جستجو بر اساس نام">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small mb-1">موبایل</label>
                            <input type="text" name="mobile" class="form-control form-control-sm"
                                value="{{ e($search['mobile'] ?? '') }}" placeholder="09xxxxxxxxx">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small mb-1">کد ملی</label>
                            <input type="text" name="national_id" class="form-control form-control-sm"
                                value="{{ e($search['national_id'] ?? '') }}" placeholder="کد ملی">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small mb-1">شغل</label>
                            <input type="text" name="customer_job" class="form-control form-control-sm"
                                value="{{ e($search['customer_job'] ?? '') }}" placeholder="شغل">
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <div class="form-check mb-2">
                                <input type="checkbox" name="show_inactive" value="1" id="show-inactive"
                                    class="form-check-input" {{ $showInactive ? 'checked' : '' }}>
                                <label for="show-inactive" class="form-check-label small">نمایش غیرفعال‌ها</label>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fa fa-search"></i>
                                جستجو
                            </button>
                            <a href="{{ route('simpleWorkflowReport.customers.index') }}"
                                class="btn btn-sm btn-outline-secondary">
                                پاک کردن
                            </a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">ردیف</th>
                                <th>نام و نام خانوادگی</th>
                                <th>کد ملی</th>
                                <th>شماره موبایل</th>
                                <th>شغل</th>
                                <th>آدرس</th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $customer)
                                <tr>
                                    <td class="text-center">{{ $customers->firstItem() + $loop->index }}</td>
                                    <td>
                                        <a href="{{ route('simpleWorkflowReport.customers.show', $customer) }}"
                                            class="text-primary font-weight-bold">
                                            {{ $customer->fullname }}
                                        </a>
                                    </td>
                                    <td dir="ltr">{{ $customer->national_id ?: '—' }}</td>
                                    <td dir="ltr">{{ $customer->mobile ?: '—' }}</td>
                                    <td>{{ $customer->customer_job ?: '—' }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($customer->address ?? '', 60, '…') ?: '—' }}</td>
                                    <td class="text-center">
                                        @if ($customer->is_active)
                                            <span class="badge badge-success">فعال</span>
                                        @else
                                            <span class="badge badge-secondary">غیرفعال</span>
                                        @endif
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <a href="{{ route('simpleWorkflowReport.customers.show', $customer) }}"
                                            class="btn btn-sm btn-outline-info" title="مشاهده جزئیات">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-secondary" data-toggle="modal"
                                            data-target="#editCustomerModal"
                                            data-action="{{ route('simpleWorkflowReport.customers.update', $customer) }}"
                                            data-fullname="{{ e($customer->fullname) }}"
                                            data-national-id="{{ e($customer->national_id) }}"
                                            data-mobile="{{ e($customer->mobile) }}"
                                            data-address="{{ e($customer->address) }}"
                                            data-customer-job="{{ e($customer->customer_job) }}">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        @if ($customer->is_active)
                                            <a href="{{ route('simpleWorkflowReport.customers.disable', $customer) }}"
                                                class="btn btn-sm btn-outline-warning" title="غیرفعال کردن"
                                                onclick="return confirm('آیا از غیرفعال کردن این مشتری مطمئن هستید؟');">
                                                <i class="fa fa-ban"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('simpleWorkflowReport.customers.enable', $customer) }}"
                                                class="btn btn-sm btn-outline-success" title="فعال کردن">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        @endif
                                        <form class="d-inline"
                                            action="{{ route('simpleWorkflowReport.customers.destroy', $customer) }}"
                                            method="POST"
                                            onsubmit="return confirm('آیا از حذف این مشتری مطمئن هستید؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                title="حذف">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        مشتری یافت نشد.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    <div class="modal fade" id="createCustomerModal" tabindex="-1" role="dialog"
        aria-labelledby="createCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCustomerModalLabel">افزودن مشتری جدید</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="بستن">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('simpleWorkflowReport.customers.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="create-fullname">نام و نام خانوادگی <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="create-fullname" name="fullname"
                                value="{{ old('fullname') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="create-national-id">کد ملی</label>
                            <input type="text" class="form-control" id="create-national-id" name="national_id"
                                value="{{ old('national_id') }}">
                        </div>
                        <div class="form-group">
                            <label for="create-mobile">شماره موبایل</label>
                            <input type="text" class="form-control" id="create-mobile" name="mobile"
                                value="{{ old('mobile') }}">
                        </div>
                        <div class="form-group">
                            <label for="create-address">آدرس</label>
                            <textarea class="form-control" id="create-address" name="address"
                                rows="3">{{ old('address') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="create-customer-job">شغل</label>
                            <textarea class="form-control" id="create-customer-job" name="customer_job"
                                rows="3" placeholder='مثال: {"title": "مهندس", "industry": "نرم‌افزار", "experience": "۵ سال"}'>{{ old('customer_job') }}</textarea>
                            <small class="text-muted">فرمت اختیاری JSON: {"title", "industry", "experience"}</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                        <button type="submit" class="btn btn-primary">ثبت مشتری</button>
                    </div>
                </form>
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
