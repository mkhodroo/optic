@extends('behin-layouts.app')

@php
    use Illuminate\Support\Str;
    use Morilog\Jalali\Jalalian;

    $now = Jalalian::now();
    $thisYear = (int) $now->format('Y');
    $yearOptions = [];
    for ($thisYear; $thisYear >= 1403; $thisYear--) {
        $yearOptions[] = $thisYear;
    }

    $monthOptions = [];
    $now = Jalalian::now();
    for ($i = 0; $i < 12; $i++) {
        $date = clone $now;
        if ($i > 0) {
            $date = $date->subMonths($i);
        }

        $monthOptions[] = [
            'value' => $date->format('m'),
            'label' => $date->format('%B'),
            'from' => $date->getFirstDayOfMonth()->format('Y-m-d'),
            'to' => $date->getEndDayOfMonth()->format('Y-m-d'),
        ];
    }

    $electronic = $optic = $optic_electronic = $other = $noCategory = $unrepairable = 0;
    $electronicIncomes = $opticIncomes = $optic_electronicIncomes = $otherIncomes = $noCategoryIncomes = $unrepairableIncomes = $totalIncomes = 0;
@endphp

@section('title', 'لیست درخواست های ماهانه')

@section('content')
    <div class="alert alert-warning">
        <strong>{{ $casesWithoutCost }}</strong>
        پرونده هنوز هزینه دریافت نکرده‌اند
        ({{ $casesWithoutCostPercent }}%)
    </div>
    <div class="card mt-3">
        <div class="card-header">
            وضعیت تعیین هزینه در ۶ ماه اخیر
        </div>

        <div class="card-body">
            <div id="costChart"></div>
        </div>
    </div>
    <div class="card">
        <form action="{{ route('fin-report.monthly-requests.index') }}" method="GET">
            <div class="card-body row">
                <div class="form-group col-sm-3">
                    <label for="">سال</label>
                    <select name="year" id="" class="form-select form-control">
                        @foreach ($yearOptions as $item)
                            <option value="{{ $item }}" {{ $year == $item ? 'selected' : '' }}>{{ $item }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="">ماه</label>
                    <select name="month" id="month-filter" class="form-select form-control">
                        @foreach ($monthOptions as $option)
                            <option value="{{ $option['value'] }}" data-from="{{ $option['from'] }}"
                                data-to="{{ $option['to'] }}" {{ $month === $option['value'] ? 'selected' : '' }}>
                                {{ $option['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">فیلتر</button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>دسته بندی</th>
                        <th>تعداد</th>
                        <th>درصد از کل</th>
                        <th>مجموع درآمد</th>
                    </tr>
                </thead>
                <tr>
                    <td>الکترونیک</td>
                    <td id="electronic"></td>
                    <td id="electronic_percentage"></td>
                    <td id="electronic_incomes"></td>
                </tr>
                <tr>
                    <td>اپتیک</td>
                    <td id="optic"></td>
                    <td id="optic_percentage"></td>
                    <td id="optic_incomes"></td>

                </tr>
                <tr>
                    <td>اپتیک و الکترونیک</td>
                    <td id="optic_electronic"></td>
                    <td id="optic_electronic_percentage"></td>
                    <td id="optic_electronic_incomes"></td>

                </tr>
                <tr>
                    <td>سایر</td>
                    <td id="others"></td>
                    <td id="others_percentage"></td>
                    <td id="others_incomes"></td>
                </tr>
                <tr>
                    <td>غیرقابل تعمیر</td>
                    <td id="unrepairable"></td>
                    <td id="unrepairable_percentage"></td>
                    <td id="unrepairable_incomes"></td>
                </tr>
                <tr>
                    <td>بدون دسته بندی</td>
                    <td id="no_category"></td>
                    <td id="no_category_percentage"></td>
                    <td id="no_category_incomes"></td>
                </tr>
                <tr>
                    <td>تعداد کل درخواست ها</td>
                    <td>{{ $total }}</td>
                    <td>{{ $total ? round(($total / $total) * 100, 2) : 0 }} %</td>
                    <td id="total_incomes"></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <form method="GET" action="{{ route('simpleWorkflowReport.monthly-requests.export') }}">
                    <button type="submit" class="btn btn-sm btn-light text-primary fw-semibold">
                        خروجی اکسل
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>شماره پرونده</th>
                            <th dir="ltr">تاریخ پذیرش</th>
                            <th>نام مشتری</th>
                            <th>تعمیرکار</th>
                            <th>هزینه‌های دریافت شده</th>
                            <th>آخرین وضعیت</th>
                            <th class="text-center">جزئیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $row)
                            @php
                                $rowIncomes = 0;

                                switch ($row->repairCategory?->value) {
                                    case 'الکترونیک':
                                        $electronic++;
                                        foreach ($row->repairIncomes as $income) {
                                            $rowIncomes += (int) $income?->payment_amount;
                                            $electronicIncomes += $rowIncomes;
                                            $totalIncomes += $rowIncomes;
                                        }
                                        break;
                                    case 'اپتیک':
                                        $optic++;
                                        foreach ($row->repairIncomes as $income) {
                                            $rowIncomes += (int) $income?->payment_amount;
                                            $opticIncomes += $rowIncomes;
                                            $totalIncomes += $rowIncomes;
                                        }
                                        break;
                                    case 'اپتیک و الکترونیک':
                                        $optic_electronic++;
                                        foreach ($row->repairIncomes as $income) {
                                            $rowIncomes += (int) $income?->payment_amount;
                                            $optic_electronicIncomes += $rowIncomes;
                                            $totalIncomes += $rowIncomes;
                                        }
                                        break;
                                    case 'سایر':
                                        $other++;
                                        foreach ($row->repairIncomes as $income) {
                                            $rowIncomes += (int) $income?->payment_amount;
                                            $otherIncomes += $rowIncomes;
                                            $totalIncomes += $rowIncomes;
                                        }
                                        break;
                                    case 'غیرقابل تعمیر':
                                        $unrepairable++;
                                        foreach ($row->repairIncomes as $income) {
                                            $rowIncomes += (int) $income?->payment_amount;
                                            $unrepairableIncomes += $rowIncomes;
                                            $totalIncomes += $rowIncomes;
                                        }
                                        break;
                                    default:
                                        $noCategory++;
                                        foreach ($row->repairIncomes as $income) {
                                            $rowIncomes += (int) $income?->payment_amount;
                                            $noCategoryIncomes += $rowIncomes;
                                            $totalIncomes += $rowIncomes;
                                        }
                                        break;
                                }

                            @endphp
                            @php
                                $background = 'white';
                                if ($rowIncomes) {
                                    $background = '#a8f7bb';
                                } else {
                                    $background = '#ff6647';
                                }
                            @endphp

                            <tr style="background: [[ $background ]]">
                                <td>{{ $loop->iteration }}
                                    @if (!empty($row->number))
                                        <a href="{{ route('simpleWorkflow.inbox.caseHistoryView', ['caseNumber' => $row->number]) }}"
                                            target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fa fa-history"></i>
                                            تاریخچه
                                        </a>
                                        <a href="{{ route('simpleWorkflowReport.all-requests.show', $row->number) }}"
                                            target="_blank" class="btn btn-sm btn-outline-primary px-3">
                                            <i class="fa fa-eye"></i>
                                            مشاهده جزئیات
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{ $row->number ?? '---' }}
                                </td>
                                <td dir="ltr">{{ toJalali($row->created_at)->format('Y-m-d H:i') }}</td>
                                <td>{{ $row->caseCustomer?->fullname ?? '---' }}</td>
                                <td>{{ $row->repair?->repairman()?->name ?? '---' }}</td>
                                <td>
                                    [[ number_format($rowIncomes) ]]
                                </td>
                                <td>
                                    @forelse($row->openInboxes as $inbox)
                                        <div class="mb-1">
                                            <strong>[[ $inbox->task?->name ]]</strong>
                                            <small>[[ getUserInfo($inbox->actor)?->name ]]</small>
                                        </div>
                                    @empty
                                        -
                                    @endforelse
                                </td>
                                <td class="text-center">
                                    @if (!empty($row->case_number))
                                        <a href="{{ route('simpleWorkflow.inbox.caseHistoryView', ['caseNumber' => $row->case_number]) }}"
                                            target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fa fa-history"></i>
                                            تاریخچه
                                        </a>
                                        <a href="{{ route('simpleWorkflowReport.all-requests.show', $row->case_number) }}"
                                            target="_blank" class="btn btn-sm btn-outline-primary px-3">
                                            <i class="fa fa-eye"></i>
                                            مشاهده جزئیات
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="19" class="text-center text-muted">رکوردی یافت نشد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#electronic').html('{{ $electronic }}')
        $('#electronic_percentage').html('{{ $total ? round(($electronic / $total) * 100, 2) : 0 }} %')
        $('#electronic_incomes').html('{{ number_format($electronicIncomes) }}')

        $('#optic').html('{{ $optic }}')
        $('#optic_percentage').html('{{ $total ? round(($optic / $total) * 100, 2) : 0 }} %')
        $('#optic_incomes').html('{{ number_format($opticIncomes) }}')

        $('#optic_electronic').html('{{ $optic_electronic }}')
        $('#optic_electronic_percentage').html('{{ $total ? round(($optic_electronic / $total) * 100, 2) : 0 }} %')
        $('#optic_electronic_incomes').html('{{ number_format($optic_electronicIncomes) }}')

        $('#others').html('{{ $other }}')
        $('#others_percentage').html('{{ $total ? round(($other / $total) * 100, 2) : 0 }} %')
        $('#others_incomes').html('{{ number_format($otherIncomes) }}')

        $('#no_category').html('{{ $noCategory }}')
        $('#no_category_percentage').html('{{ $total ? round(($noCategory / $total) * 100, 2) : 0 }} %')
        $('#no_category_incomes').html('{{ number_format($noCategoryIncomes) }}')

        $('#unrepairable').html('{{ $unrepairable }}')
        $('#unrepairable_percentage').html('{{ $total ? round(($unrepairable / $total) * 100, 2) : 0 }} %')
        $('#unrepairable_incomes').html('{{ number_format($unrepairableIncomes) }}')

        $('#total_incomes').html('{{ number_format($totalIncomes) }}')
    </script>
    <script>
        let chartData = @json($monthlyChart);

        let options = {
            chart: {
                type: 'bar',
                height: 380
            },

            series: [{
                    name: 'کل پرونده ها',
                    data: chartData.map(x => x.total)
                },
                {
                    name: 'بدون هزینه',
                    data: chartData.map(x => x.without_cost)
                }
            ],

            xaxis: {
                categories: chartData.map(x => x.month)
            },

            colors: ['#008FFB', '#FF4560'],

            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '45%'
                }
            }
        };

        new ApexCharts(document.querySelector("#costChart"), options).render();
    </script>
@endsection
