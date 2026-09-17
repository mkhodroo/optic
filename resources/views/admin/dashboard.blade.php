@extends('behin-layouts.app')

@section('content')

    <style>
        .dashboard-wrapper {
            padding: 10px 5px 30px;
            direction: rtl;
        }

        /* Header */
        .dashboard-header {
            margin-bottom: 24px;
        }

        .dashboard-header h4 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            color: #263238;
        }

        .dashboard-header p {
            margin: 7px 0 0;
            color: #78909c;
            font-size: 13px;
        }

        /* Material Card */
        .material-card {
            position: relative;
            min-height: 175px;
            margin-bottom: 22px;
            padding: 22px;
            background: #fff;
            border-radius: 16px;
            border: 1px solid #edf0f2;
            box-shadow: 0 3px 12px rgba(0, 0, 0, .055);
            overflow: hidden;
            transition: all .25s ease;
            cursor: pointer;
        }

        .material-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(0, 0, 0, .11);
        }

        /* top accent */
        .material-card::before {
            content: "";
            position: absolute;
            right: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: var(--card-color);
        }

        .material-card-content {
            position: relative;
            z-index: 2;
        }

        .material-icon {
            width: 52px;
            height: 52px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 17px;
            background: var(--card-bg);
            color: var(--card-color);
            font-size: 22px;
        }

        .material-card h3 {
            margin: 0 0 7px;
            color: #263238;
            font-size: 18px;
            font-weight: 700;
        }

        .material-card p {
            margin: 0;
            color: #90a4ae;
            font-size: 13px;
            line-height: 1.7;
        }

        .material-card-link {
            position: absolute;
            left: 20px;
            bottom: 18px;
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--card-color);
            font-size: 12px;
            font-weight: 600;
            text-decoration: none !important;
            z-index: 5;
        }

        .material-card-link i {
            font-size: 11px;
            transition: transform .2s ease;
        }

        .material-card:hover .material-card-link i {
            transform: translateX(-4px);
        }

        /* Decorative circle */
        .material-card::after {
            content: "";
            position: absolute;
            left: -35px;
            bottom: -55px;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: var(--card-bg);
            opacity: .45;
        }

        /* Colors */
        .card-blue {
            --card-color: #1976d2;
            --card-bg: #e3f2fd;
        }

        .card-purple {
            --card-color: #7e57c2;
            --card-bg: #ede7f6;
        }

        .card-red {
            --card-color: #e53935;
            --card-bg: #ffebee;
        }

        .card-cyan {
            --card-color: #0097a7;
            --card-bg: #e0f7fa;
        }

        .card-green {
            --card-color: #43a047;
            --card-bg: #e8f5e9;
        }

        .card-orange {
            --card-color: #fb8c00;
            --card-bg: #fff3e0;
        }

        /* Payment card */
        .payment-card {
            cursor: default;
        }

        .payment-value {
            min-height: 31px;
            display: flex;
            align-items: center;
        }

        .payment-value .show-btn {
            border: 0;
            border-radius: 8px;
            padding: 6px 15px;
            background: #ffebee;
            color: #e53935;
            font-size: 12px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .payment-value .show-btn:hover {
            background: #e53935;
            color: #fff;
        }

        .payment-result {
            color: #263238;
            font-size: 16px;
            font-weight: 700;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .material-card {
                min-height: 165px;
            }
        }

        @media (max-width: 576px) {
            .dashboard-wrapper {
                padding: 5px 0 20px;
            }

            .dashboard-header h4 {
                font-size: 19px;
            }

            .material-card {
                min-height: 155px;
                padding: 18px;
                border-radius: 14px;
            }

            .material-icon {
                width: 45px;
                height: 45px;
                font-size: 19px;
            }

            .material-card h3 {
                font-size: 16px;
            }
        }
    </style>


    <div class="dashboard-wrapper">

        {{-- Header --}}
        <div class="dashboard-header">
            <h4>داشبورد</h4>
            <p>دسترسی سریع به بخش‌ها و عملیات سامانه</p>
        </div>


        <div class="row">

            {{-- مجموع دریافتی‌ها --}}
            @if (auth()->user()->access('مجموع دریافتی ها'))
                <div class="col-lg-3 col-md-4 col-sm-6">

                    <div class="material-card payment-card card-purple">

                        <div class="material-card-content">

                            <div class="material-icon">
                                <i class="ion ion-social-usd"></i>
                            </div>

                            <h3>{{ trans('مجموع دریافتی ها') }}</h3>

                            <p class="payment-value" id="total-receivables">
                                <button
                                    type="button"
                                    class="show-btn"
                                    onclick="showtotalPayment()">
                                    نمایش مبلغ
                                </button>
                            </p>

                        </div>

                    </div>

                </div>
            @endif


            {{-- پذیرش دستگاه --}}
            @if (auth()->user()->access('منو >>کارتابل>>فرایند جدید'))
                <div class="col-lg-3 col-md-4 col-sm-6">

                    <div class="material-card card-blue"
                         onclick="window.location='{{ route('simpleWorkflow.process.start', [
                            'taskId' => '7434396b-54ec-4624-840e-e7b24db73eaf',
                            'inDraft' => 0,
                            'force' => 1,
                            'redirect' => true,
                        ]) }}'">

                        <div class="material-card-content">

                            <div class="material-icon">
                                <i class="ion ion-ios-cart"></i>
                            </div>

                            <h3>{{ trans('پذیرش دستگاه') }}</h3>

                            <p>{{ trans('ثبت پذیرش دستگاه جدید') }}</p>

                        </div>

                        <a href="{{ route('simpleWorkflow.process.start', [
                            'taskId' => '7434396b-54ec-4624-840e-e7b24db73eaf',
                            'inDraft' => 0,
                            'force' => 1,
                            'redirect' => true,
                        ]) }}"
                           class="material-card-link">

                            {{ trans('شروع فرایند') }}
                            <i class="fa fa-arrow-left"></i>

                        </a>

                    </div>

                </div>
            @endif


            {{-- پذیرش دستگاه برگشتی --}}
            @if (auth()->user()->access('پذیرش دستگاه برگشتی'))
                <div class="col-lg-3 col-md-4 col-sm-6">

                    <div class="material-card card-orange"
                         onclick="window.location='{{ route('simpleWorkflow.process.start', [
                            'taskId' => '3629b18d-703b-49fa-b4f2-f55436a887cb',
                            'inDraft' => true,
                            'force' => 1,
                            'redirect' => true,
                        ]) }}'">

                        <div class="material-card-content">

                            <div class="material-icon">
                                <i class="ion ion-ios-undo"></i>
                            </div>

                            <h3>{{ trans('پذیرش دستگاه برگشتی') }}</h3>

                            <p>{{ trans('پذیرش دستگاه برگشتی') }}</p>

                        </div>

                        <a href="{{ route('simpleWorkflow.process.start', [
                            'taskId' => '3629b18d-703b-49fa-b4f2-f55436a887cb',
                            'inDraft' => true,
                            'force' => 1,
                            'redirect' => true,
                        ]) }}"
                           class="material-card-link">

                            {{ trans('شروع فرایند') }}
                            <i class="fa fa-arrow-left"></i>

                        </a>

                    </div>

                </div>
            @endif


            {{-- مرخصی --}}
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="material-card card-red"
                     onclick="if(confirm('شروع؟')) {
                        window.location='{{ route('simpleWorkflow.process.start', [
                            'taskId' => '227ae234-0cbb-450f-b238-52a98667a9e4',
                            'inDraft' => 0,
                            'force' => 1,
                            'redirect' => true,
                        ]) }}';
                     }">

                    <div class="material-card-content">

                        <div class="material-icon">
                            <i class="ion ion-ios-calendar-outline"></i>
                        </div>

                        <h3>{{ trans('مرخصی') }}</h3>

                        <p>{{ trans('ثبت مرخصی') }}</p>

                    </div>

                    <a href="{{ route('simpleWorkflow.process.start', [
                        'taskId' => '227ae234-0cbb-450f-b238-52a98667a9e4',
                        'inDraft' => 0,
                        'force' => 1,
                        'redirect' => true,
                    ]) }}"
                       onclick="return confirm('شروع؟')"
                       class="material-card-link">

                        {{ trans('ثبت درخواست') }}
                        <i class="fa fa-arrow-left"></i>

                    </a>

                </div>

            </div>


            {{-- کارتابل --}}
            @if (auth()->user()->access('منو >>کارتابل>>کارتابل'))
                <div class="col-lg-3 col-md-4 col-sm-6">

                    <div class="material-card card-cyan"
                         onclick="window.location='{{ route('simpleWorkflow.inbox.index') }}'">

                        <div class="material-card-content">

                            <div class="material-icon">
                                <i class="ion ion-android-inbox"></i>
                            </div>

                            <h3>{{ trans('کارتابل من') }}</h3>

                            <p>{{ trans('لیست پرونده هایی که باید انجام دهید') }}</p>

                        </div>

                        <a href="{{ route('simpleWorkflow.inbox.index') }}"
                           class="material-card-link">

                            {{ trans('مشاهده کارتابل') }}
                            <i class="fa fa-arrow-left"></i>

                        </a>

                    </div>

                </div>
            @endif


            {{-- لیست کارها --}}
            @if (auth()->user()->access('لیست کارها'))
                <div class="col-lg-3 col-md-4 col-sm-6">

                    <div class="material-card card-green"
                         onclick="window.location='{{ route('todoList.index') }}'">

                        <div class="material-card-content">

                            <div class="material-icon">
                                <i class="ion ion-android-checkbox-outline"></i>
                            </div>

                            <h3>{{ trans('لیست کارها') }}</h3>

                            <p>{{ trans('لیست کارهایی که ابلاغ شده است') }}</p>

                        </div>

                        <a href="{{ route('todoList.index') }}"
                           class="material-card-link">

                            {{ trans('مشاهده کارها') }}
                            <i class="fa fa-arrow-left"></i>

                        </a>

                    </div>

                </div>
            @endif


            {{-- گزارش پرونده‌ها --}}
            @if (auth()->user()->access('گزارش پرونده ها'))
                <div class="col-lg-3 col-md-4 col-sm-6">

                    <div class="material-card card-orange"
                         onclick="window.location='{{ route('simpleWorkflowReport.summary-report.index') }}'">

                        <div class="material-card-content">

                            <div class="material-icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>

                            <h3>{{ trans('گزارش پرونده ها') }}</h3>

                            <p>{{ trans('گزارش پرونده ها بر اساس وضعیت') }}</p>

                        </div>

                        <a href="{{ route('simpleWorkflowReport.summary-report.index') }}"
                           class="material-card-link">

                            {{ trans('مشاهده گزارش') }}
                            <i class="fa fa-arrow-left"></i>

                        </a>

                    </div>

                </div>
            @endif

        </div>

    </div>


@endsection


@section('script')

    <script>
        function showtotalPayment() {

            const resultElement = $('#total-receivables');

            resultElement.html(
                '<span class="payment-result">در حال دریافت...</span>'
            );

            send_ajax_get_request(
                "{{ route('simpleWorkflowReport.totalPayment') }}",
                function(response) {

                    const value = parseInt(
                        response.replace(/,/g, '')
                    ).toLocaleString();

                    resultElement.html(
                        '<span class="payment-result">' +
                        value +
                        ' ریال' +
                        '</span>'
                    );

                }
            );
        }
    </script>

@endsection