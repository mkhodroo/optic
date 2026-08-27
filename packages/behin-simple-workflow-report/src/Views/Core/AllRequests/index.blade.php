@extends('behin-layouts.app')

@php
    use Illuminate\Support\Str;
    $backUrl = route('simpleWorkflowReport.summary-report.index');
@endphp

@section('title', 'لیست تمام درخواست‌ها')

@section('content')

    <style>
        .requests-page {
            padding: 10px 0 25px;
        }

        .requests-card {
            border: 0 !important;
            border-radius: 16px !important;
            overflow: hidden;
            background: #fff;
        }

        /* Header */
        .requests-header {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            padding: 20px 24px;
            border: 0;
        }

        .requests-header-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .requests-header-icon {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            background: rgba(255, 255, 255, .16);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .requests-header h5 {
            font-size: 17px;
            font-weight: 700;
            margin: 0;
        }

        .requests-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 25px;
            padding: 0 8px;
            margin-right: 5px;
            border-radius: 20px;
            background: rgba(255, 255, 255, .16);
            font-size: 12px;
        }

        .excel-btn {
            border: 0 !important;
            border-radius: 9px !important;
            padding: 8px 14px !important;
            font-weight: 600 !important;
            transition: all .2s ease;
        }

        .excel-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, .12);
        }

        /* Body */
        .requests-body {
            padding: 22px !important;
        }

        /* Filter button */
        .filter-toggle {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 9px !important;
            padding: 9px 15px !important;
            font-weight: 600;
            transition: all .2s ease;
        }

        .filter-toggle:hover {
            transform: translateY(-1px);
        }

        /* Filter box */
        .filter-card {
            border: 1px solid #e8edf5 !important;
            background: #f8fafc;
            border-radius: 13px !important;
            padding: 20px !important;
        }

        .filter-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            color: #334155;
            font-size: 14px;
            font-weight: 700;
        }

        .filter-title i {
            color: #2563eb;
        }

        .filter-card .form-label {
            color: #475569;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .filter-card .form-control,
        .filter-card .form-select {
            height: 40px;
            border: 1px solid #dce3ed;
            border-radius: 8px;
            background: #fff;
            font-size: 13px;
            transition: all .2s ease;
        }

        .filter-card .form-control:focus,
        .filter-card .form-select:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .08);
        }

        .filter-actions {
            border-top: 1px solid #e7ebf1;
            padding-top: 17px;
        }

        .filter-actions .btn {
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 17px;
        }

        /* Table */
        .requests-table-wrapper {
            border: 1px solid #e8edf3;
            border-radius: 13px;
            overflow: auto;
            background: #fff;
        }

        .requests-table {
            margin: 0 !important;
            min-width: 1100px;
        }

        .requests-table thead th {
            background: #f8fafc;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
            border-top: 0;
            padding: 13px 14px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            vertical-align: middle;
        }

        .requests-table tbody td {
            padding: 12px 14px;
            border-color: #eef2f6;
            color: #334155;
            font-size: 13px;
            vertical-align: middle;
            white-space: nowrap;
        }

        .requests-table tbody tr {
            transition: background .15s ease;
        }

        .requests-table tbody tr:hover {
            background: #f8fbff !important;
        }

        .requests-table tbody tr:last-child td {
            border-bottom: 0;
        }

        /* Case number */
        .case-number {
            display: inline-flex;
            align-items: center;
            padding: 5px 9px;
            border-radius: 7px;
            background: #eff6ff;
            color: #1d4ed8;
            font-weight: 700;
            font-size: 12px;
            margin-left: 5px;
        }

        /* Action buttons */
        .case-actions {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 5px;
        }

        .case-action-btn {
            border-radius: 6px !important;
            padding: 4px 7px !important;
            font-size: 11px !important;
            line-height: 1.4;
            white-space: nowrap;
        }

        .case-action-btn i {
            margin-left: 3px;
        }

        /* Money */
        .money-value {
            color: #334155;
            font-weight: 700;
            direction: rtl;
        }

        /* Status */
        .status-value {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f1f5f9;
            color: #475569;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-value::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #64748b;
        }

        /* Empty */
        .empty-row td {
            padding: 55px 20px !important;
        }

        .empty-icon {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: #f1f5f9;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 21px;
        }

        /* Footer */
        .table-footer {
            padding-top: 17px;
        }

        .table-summary {
            color: #64748b;
            font-size: 12px;
        }

        .table-summary strong {
            color: #334155;
        }

        .pagination-wrapper .pagination {
            margin-bottom: 0;
        }

        .pagination-wrapper .page-link {
            border-radius: 7px !important;
            margin: 0 2px;
            border: 1px solid #e2e8f0;
            color: #475569;
            font-size: 12px;
            min-width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pagination-wrapper .page-item.active .page-link {
            background: #2563eb;
            border-color: #2563eb;
            color: #fff;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .requests-header {
                padding: 16px;
            }

            .requests-body {
                padding: 15px !important;
            }

            .requests-header-title {
                margin-bottom: 12px;
            }

            .requests-header {
                flex-direction: column;
                align-items: stretch !important;
            }

            .requests-header > div:last-child {
                width: 100%;
            }

            .excel-btn {
                width: 100%;
            }

            .table-footer {
                align-items: flex-start !important;
                flex-direction: column;
            }
        }
    </style>

    <div class="requests-page">
        <div class="row justify-content-center">
            <div class="col-lg-12">

                <div class="card shadow-sm requests-card">

                    {{-- Header --}}
                    <div class="requests-header text-white d-flex justify-content-between align-items-center flex-wrap">

                        <div class="requests-header-title">
                            <div class="requests-header-icon">
                                <i class="fa fa-list-alt"></i>
                            </div>

                            <div>
                                <h5>
                                    لیست تمام درخواست‌ها
                                    <span class="requests-count">
                                        {{ number_format($rows->total()) }}
                                    </span>
                                </h5>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <form method="GET" action="{{ route('simpleWorkflowReport.all-requests.export') }}">
                                @foreach ($filters ?? [] as $key => $value)
                                    @continue($value === null || $value === '')
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach

                                <button type="submit"
                                    class="btn btn-light text-primary excel-btn">
                                    <i class="fa fa-file-excel-o ml-1"></i>
                                    خروجی اکسل
                                </button>
                            </form>
                        </div>

                    </div>

                    <div class="card-body requests-body">

                        @php
                            $filters = $filters ?? [];
                            $hasActiveFilters = collect($filters)
                                ->except(['per_page'])
                                ->filter(fn($value) => $value !== null && $value !== '')
                                ->isNotEmpty();

                            $approvalOptions = [
                                '' => 'همه موارد',
                                'approved' => 'تایید شده',
                                'rejected' => 'رد شده',
                                'pending' => 'در انتظار',
                            ];
                        @endphp

                        {{-- Filter Toggle --}}
                        <div class="mb-3">
                            <button class="btn btn-outline-primary filter-toggle"
                                type="button"
                                data-toggle="collapse"
                                data-target="#advanced-filters"
                                aria-expanded="{{ $hasActiveFilters ? 'true' : 'false' }}"
                                aria-controls="advanced-filters">

                                <i class="fa fa-sliders"></i>
                                فیلتر پیشرفته

                                @if ($hasActiveFilters)
                                    <span class="badge badge-primary">
                                        فعال
                                    </span>
                                @endif

                            </button>
                        </div>

                        {{-- Filters --}}
                        <div class="collapse {{ $hasActiveFilters ? 'show' : '' }}"
                            id="advanced-filters">

                            <div class="card filter-card shadow-sm mb-4">

                                <div class="filter-title">
                                    <i class="fa fa-filter"></i>
                                    جستجو و فیلتر درخواست‌ها
                                </div>

                                <form method="GET"
                                    action="{{ route('simpleWorkflowReport.all-requests.index') }}">

                                    <div class="row g-3">

                                        <div class="col-md-3">
                                            <label class="form-label">شماره پرونده</label>
                                            <input type="text"
                                                name="case_number"
                                                value="{{ $filters['case_number'] ?? '' }}"
                                                class="form-control"
                                                placeholder="مثال: 1234">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">نام مشتری</label>
                                            <input type="text"
                                                name="customer_name"
                                                value="{{ $filters['customer_name'] ?? '' }}"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">موبایل مشتری</label>
                                            <input type="text"
                                                name="customer_mobile"
                                                value="{{ $filters['customer_mobile'] ?? '' }}"
                                                class="form-control"
                                                dir="ltr">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">نام دستگاه</label>
                                            <input type="text"
                                                name="device_name"
                                                value="{{ $filters['device_name'] ?? '' }}"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">سریال دستگاه</label>
                                            <input type="text"
                                                name="device_serial"
                                                value="{{ $filters['device_serial'] ?? '' }}"
                                                class="form-control"
                                                dir="ltr">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">نوع تعمیر</label>
                                            <input type="text"
                                                name="repair_type"
                                                value="{{ $filters['repair_type'] ?? '' }}"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">جزئیات نوع تعمیر</label>
                                            <input type="text"
                                                name="repair_subtype"
                                                value="{{ $filters['repair_subtype'] ?? '' }}"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">تعمیرکار</label>
                                            <input type="text"
                                                name="repairman"
                                                value="{{ $filters['repairman'] ?? '' }}"
                                                class="form-control">
                                        </div>

                                        {{-- فیلترهای بعدی شما بدون تغییر --}}
                                        
                                        <div class="col-md-3">
                                            <label class="form-label">
                                                تعداد نمایش در هر صفحه
                                            </label>

                                            <select name="per_page"
                                                class="form-select form-control">

                                                @foreach ([10, 15, 25, 50, 100] as $size)
                                                    <option value="{{ $size }}"
                                                        {{ ($perPage ?? 15) == $size ? 'selected' : '' }}>
                                                        {{ $size }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>

                                    </div>

                                    <div class="filter-actions d-flex justify-content-end gap-2 mt-4">

                                        <a href="{{ route('simpleWorkflowReport.all-requests.index') }}"
                                            class="btn btn-light">
                                            <i class="fa fa-refresh ml-1"></i>
                                            پاکسازی فیلتر
                                        </a>

                                        <button type="submit"
                                            class="btn btn-primary">
                                            <i class="fa fa-search ml-1"></i>
                                            اعمال فیلتر
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                        {{-- Table --}}
                        <div class="requests-table-wrapper">

                            <table class="table table-hover requests-table">

                                <thead>
                                    <tr>
                                        <th>شماره پرونده</th>
                                        <th>تاریخ پذیرش</th>
                                        <th>نام مشتری</th>
                                        <th>موبایل مشتری</th>
                                        <th>نام دستگاه</th>
                                        <th>سریال دستگاه</th>
                                        <th class="d-none">نوع تعمیر</th>
                                        <th class="d-none">جزئیات نوع تعمیر</th>
                                        <th>تعمیرکار</th>
                                        <th class="d-none">تاریخ شروع تعمیر</th>
                                        <th class="d-none">تاریخ پایان تعمیر</th>
                                        <th class="d-none">مدت تعمیر</th>
                                        <th>هزینه تعیین شده</th>
                                        <th>هزینه‌های دریافت شده</th>
                                        <th>آخرین وضعیت</th>
                                        <th class="d-none">گزارش تعمیرات</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($rows as $row)

                                        <tr>

                                            <td>

                                                @if (!empty($row->case_number))

                                                    <span class="case-number">
                                                        {{ $row->case_number }}
                                                    </span>

                                                    <div class="case-actions">

                                                        <a href="{{ route('simpleWorkflow.inbox.caseHistoryView', ['caseNumber' => $row->case_number]) }}"
                                                            target="_blank"
                                                            class="btn btn-sm btn-outline-info case-action-btn">

                                                            <i class="fa fa-history"></i>
                                                            تاریخچه

                                                        </a>

                                                        <a href="{{ route('simpleWorkflowReport.all-requests.show', $row->case_number) }}"
                                                            target="_blank"
                                                            class="btn btn-sm btn-outline-primary case-action-btn">

                                                            <i class="fa fa-eye"></i>
                                                            جزئیات

                                                        </a>

                                                    </div>

                                                @else

                                                    <span class="text-muted">---</span>

                                                @endif

                                            </td>

                                            <td>
                                                {{ toJalali($row->case_created_at) }}
                                            </td>

                                            <td>
                                                {{ $row->customer_name ?? '---' }}
                                            </td>

                                            <td dir="ltr">
                                                {{ $row->customer_mobile ?? '---' }}
                                            </td>

                                            <td>
                                                {{ $row->device_name ?? '---' }}
                                            </td>

                                            <td dir="ltr">
                                                {{ $row->device_serial ?? '---' }}
                                            </td>

                                            <td class="d-none">
                                                {{ $row->repair_type ?: '---' }}
                                            </td>

                                            <td class="d-none">
                                                {{ $row->repair_subtype ?: '---' }}
                                            </td>

                                            <td>
                                                {{ $row->repairman ?? '---' }}
                                            </td>

                                            <td class="d-none">
                                                {{ $row->repair_start_at ?? '---' }}
                                            </td>

                                            <td class="d-none">
                                                {{ $row->repair_end_at ?? '---' }}
                                            </td>

                                            <td class="d-none">
                                                {{ $row->repair_duration ?? '---' }}
                                            </td>

                                            <td>
                                                @if ($row->repair_cost_formatted)
                                                    <span class="money-value">
                                                        {{ $row->repair_cost_formatted }}
                                                    </span>
                                                @else
                                                    ---
                                                @endif
                                            </td>

                                            <td>
                                                @if ($row->received_cost_formatted)
                                                    <span class="money-value">
                                                        {{ $row->received_cost_formatted }}
                                                    </span>
                                                @else
                                                    ---
                                                @endif
                                            </td>

                                            <td>
                                                @if ($row->last_status)
                                                    <span class="status-value">
                                                        {{ $row->last_status }}
                                                    </span>
                                                @else
                                                    ---
                                                @endif
                                            </td>

                                        </tr>

                                    @empty

                                        <tr class="empty-row">

                                            <td colspan="19" class="text-center text-muted">

                                                <div class="empty-icon">
                                                    <i class="fa fa-inbox"></i>
                                                </div>

                                                <div class="font-weight-bold mb-1">
                                                    رکوردی یافت نشد
                                                </div>

                                                <small>
                                                    با تغییر فیلترها دوباره جستجو کنید.
                                                </small>

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                        {{-- Footer --}}
                        <div class="table-footer d-flex justify-content-between align-items-center flex-wrap gap-2">

                            <div class="table-summary">
                                نمایش
                                <strong>{{ $rows->firstItem() ?? 0 }}</strong>
                                تا
                                <strong>{{ $rows->lastItem() ?? 0 }}</strong>
                                از
                                <strong>{{ number_format($rows->total()) }}</strong>
                                رکورد
                            </div>

                            <div class="pagination-wrapper">
                                {{ $rows->onEachSide(1)->links('pagination::bootstrap-4') }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection