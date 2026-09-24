@extends('behin-layouts.app')

@section('content')



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