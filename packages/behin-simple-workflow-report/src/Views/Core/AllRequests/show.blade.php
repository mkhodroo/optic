@extends('behin-layouts.app')

@section('title', 'جزئیات درخواست')

@section('content')
    <input type="hidden" id="caseId" value="[[ $case->id ]]">

    <div class="card p-0 mb-3">

        <!-- Header -->
        <div class="card-header d-flex align-items-center"
            style="
            background-color: #f5f5f5;
            min-height: 50px;
            border-bottom: 1px solid rgba(0,0,0,.1);
            padding: 0 15px;
        ">

            <h5 class="mb-0 font-weight-bold" style="color: #333;">
                اطلاعات مشتری
            </h5>

            <span class="badge badge-secondary mr-2"
                style="
                font-size: 12px;
                padding: 6px 10px;
            ">
                شماره پرونده: [[ $case->number ]]
            </span>

        </div>


        <!-- Body -->
        <div class="card-body">

            <div class="row">

                <!-- نام مشتری -->
                <div class="col-sm-4 mb-3">

                    <label class="d-block mb-1 text-muted" style="font-size: 13px;">
                        نام مشتری
                    </label>

                    <div class="font-weight-bold" style="color: #333;">
                        [[ $case->customer?->fullname ?? '-' ]]
                    </div>

                </div>


                <!-- موبایل -->
                <div class="col-sm-4 mb-3">

                    <label class="d-block mb-1 text-muted" style="font-size: 13px;">
                        موبایل مشتری
                    </label>

                    <div class="font-weight-bold" style="direction: ltr; text-align: right; color: #333;">
                        [[ $case->customer?->mobile ?? '-' ]]
                    </div>

                </div>


                <!-- آدرس -->
                <div class="col-sm-12 mb-3">

                    <label class="d-block mb-1 text-muted" style="font-size: 13px;">
                        آدرس مشتری
                    </label>

                    <div class="font-weight-bold" style="color: #333;">
                        [[ $case->customer?->address ?? '-' ]]
                    </div>

                </div>


                <!-- لینک پیگیری -->
                <div class="col-sm-12">

                    <label class="d-block mb-1 text-muted" style="font-size: 13px;">
                        لینک مشاهده جزئیات پرونده توسط مشتری
                    </label>

                    @if ($case->getVariable('tracking_url'))
                        <div class="d-flex align-items-center"
                            style="
                            background-color: #f8f9fa;
                            border: 1px solid #e9ecef;
                            border-radius: 4px;
                            min-height: 40px;
                            padding: 5px 10px;
                        ">

                            <a href="[[ $case->getVariable('tracking_url') ]]" target="_blank" class="text-primary"
                                style="
                                direction: ltr;
                                text-align: left;
                                word-break: break-all;
                            ">
                                [[ $case->getVariable('tracking_url') ]]
                            </a>

                        </div>
                    @else
                        <div class="text-muted">
                            لینکی برای این پرونده ایجاد نشده است.
                        </div>
                    @endif

                </div>

            </div>

        </div>

    </div>

    <div class="card p-0 mb-3">

        <!-- Header -->
        <div class="card-header d-flex align-items-center"
            style="
            background-color: #f5f5f5;
            min-height: 50px;
            border-bottom: 1px solid rgba(0,0,0,.1);
            padding: 0 15px;
        ">

            <h5 class="mb-0 font-weight-bold" style="color: #333;">
                اطلاعات پذیرش اولیه
            </h5>

        </div>


        <!-- Body -->
        <div class="card-body">

            <div class="row">


                <!-- تاریخ پذیرش -->
                <div class="col-sm-3 mb-3">

                    <label class="d-block mb-1 text-muted" style="font-size: 13px;">
                        تاریخ پذیرش
                    </label>

                    <div class="font-weight-bold" style="color: #333;">
                        [[ $case->getVariable('receive_date') ?: '-' ]]
                    </div>

                </div>


                <!-- نوع بسته بندی -->
                <div class="col-sm-3 mb-3">

                    <label class="d-block mb-1 text-muted" style="font-size: 13px;">
                        نوع بسته بندی
                    </label>

                    <div class="font-weight-bold" style="color: #333;">
                        [[ $case->getVariable('device_packaging_type') ?: '-' ]]
                    </div>

                </div>


                <!-- لوازم همراه دستگاه -->
                <div class="col-sm-3 mb-3">

                    <label class="d-block mb-1 text-muted" style="font-size: 13px;">
                        لوازم همراه دستگاه
                    </label>

                    <div class="font-weight-bold" style="color: #333;">
                        [[ $case->getVariable('device_accessories') ?: '-' ]]
                    </div>

                </div>


                <!-- توضیحات اولیه مشتری -->
                <div class="col-sm-3 mb-3">

                    <label class="d-block mb-1 text-muted" style="font-size: 13px;">
                        توضیحات اولیه مشتری
                    </label>

                    <div class="font-weight-bold" style="color: #333;">
                        [[ $case->getVariable('customer_description') ?: '-' ]]
                    </div>

                </div>


                <!-- دسته بندی تعمیر -->
                <div class="col-sm-3 mb-3">

                    @include('SimpleWorkflowView::Core.Form.field-generator', [
                        'fieldName' => 'repair_category',
                        'fieldId' => 'repair_category',
                        'fieldClass' => 'col-sm-12',
                        'readOnly' => false,
                        'required' => false,
                        'fieldValue' => $case->getVariable('repair_category'),
                        'fieldValueAlt' => null ?? '',
                    ])

                </div>


            </div>

        </div>

    </div>

    @include('SimpleWorkflowView::Core.Form.field-generator', [
        'fieldName' => 'نماینده یا نمایندگان مشتری',
        'fieldId' => 'case_customers',
        'fieldClass' => 'col-sm-12',
        'readOnly' => false,
        'required' => false,
        'fieldValue' => null,
        'fieldValueAlt' => null ?? '',
    ])

    @include('SimpleWorkflowView::Core.Form.field-generator', [
        'fieldName' => 'توضیحات واحد فروش',
        'fieldId' => 'sale_unit_notes',
        'fieldClass' => 'col-sm-12',
        'readOnly' => true,
        'required' => false,
        'fieldValue' => null,
        'fieldValueAlt' => null,
    ])
    <div class="">
        @include('SimpleWorkflowView::Core.Form.field-generator', [
            'fieldName' => 'جدول هزینه های پیش بینی نشده',
            'fieldId' => 'unexpected_costs',
            'fieldClass' => 'col-sm-12',
            'readOnly' => true,
            'required' => false,
            'fieldValue' => null,
            'fieldValueAlt' => null,
        ])
    </div>
    <div class="">
        @include('SimpleWorkflowView::Core.Form.field-generator', [
            'fieldName' => 'device',
            'fieldId' => 'device',
            'fieldClass' => 'col-sm-12',
            'readOnly' => true,
            'required' => false,
            'fieldValue' => null,
            'fieldValueAlt' => null,
        ])
    </div>

    <div class="card row">
        <div class="card-header">
            اطلاعات دستگاه
        </div>
        <div class="card-body row">

            <div class="col-sm-3">
                <label for="">نام دستگاه</label>
                <p>[[ $case->device?->name ]]</p>
            </div>
            <div class="col-sm-3">
                <label for="">سری دستگاه</label>
                <p>[[ $case->device?->brand ]]</p>
            </div>
            <div class="col-sm-3">
                <label for="">توان دستگاه</label>
                <p>[[ $case->device?->power ]]</p>
            </div>
            <div class="col-sm-3">
                <label for="">سریال دستگاه</label>
                <p>[[ $case->device?->serial ]]</p>
            </div>
            <div class="col-sm-3">
                <label for="">تصویر اولیه دستگاه</label>
                <p>
                    @if ($case->device?->initial_pic)
                        <img src="[[ url('public/' . $case->device->initial_pic) ]]" alt="" width="100" download>
                    @endif
                </p>
            </div>
            <div class="col-sm-3">
                <label for="">تصویر پلاک دستگاه</label>
                <p>
                    @if ($case->device?->plaque_pic)
                        <img src="[[ url('public/' . $case->device->plaque_pic) ]]" alt="" width="100" download>
                    @endif
                </p>
            </div>
            <div class="col-sm-3">
                <label for="">مشخصات دستگاه</label>
                <p>[[ $case->device?->specifications ]]</p>
            </div>
        </div>
    </div>
    <div class="card">
        @include('SimpleWorkflowView::Core.Form.field-generator', [
            'fieldName' => 'اطلاعات تعمیرات',
            'fieldId' => 'repair_info',
            'fieldClass' => 'col-sm-12',
            'readOnly' => true,
            'required' => false,
            'fieldValue' => null,
            'fieldValueAlt' => null,
        ])
    </div>
    
    <div class="card">
        <div class="card-header">
            تصاویر تعمیرات
        </div>
        <div class="card-body row">
            @foreach ($case->deviceRepairPics as $pic)
                <div class="col-sm-3">
                    @if (str_contains($pic->file, 'http'))
                        <a href="[[ $pic->file ]]" download="">دانلود</a>
                    @else
                        <a href="[[ url('public/' . $pic->file) ]]" download="">دانلود</a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @include('SimpleWorkflowView::Core.Form.field-generator', [
        'fieldName' => 'جدول تعیین هزینه',
        'fieldId' => 'repair_cost',
        'fieldClass' => 'col-sm-12',
        'readOnly' => true,
        'required' => false,
        'fieldValue' => null,
        'fieldValueAlt' => null ?? '',
    ])

    @include('SimpleWorkflowView::Core.Form.field-generator', [
        'fieldName' => 'اطلاعات پیش فاکتور',
        'fieldId' => 'pre_invoice',
        'fieldClass' => 'col-sm-12',
        'readOnly' => true,
        'required' => false,
        'fieldValue' => null,
        'fieldValueAlt' => null ?? '',
    ])
    @include('SimpleWorkflowView::Core.Form.field-generator', [
        'fieldName' => 'آیتم های پیش فاکتور',
        'fieldId' => 'pre_invoice_items',
        'fieldClass' => 'col-sm-12',
        'readOnly' => true,
        'required' => false,
        'fieldValue' => null,
        'fieldValueAlt' => null,
    ])
    @include('SimpleWorkflowView::Core.Form.field-generator', [
        'fieldName' => 'ویرایش دریافت هزینه',
        'fieldId' => 'repair_incomes',
        'fieldClass' => 'col-sm-12',
        'readOnly' => true,
        'required' => false,
        'fieldValue' => null,
        'fieldValueAlt' => null ?? '',
    ])
    @include('SimpleWorkflowView::Core.Form.field-generator', [
        'fieldName' => 'اطلاعات فاکتور',
        'fieldId' => 'invoice',
        'fieldClass' => 'col-sm-12',
        'readOnly' => true,
        'required' => false,
        'fieldValue' => null,
        'fieldValueAlt' => null ?? '',
    ])

    @if (access('تفکیک هزینه ها در مشاهده جزئیات بیشتر هر پرونده'))
        <div class="card">
            <div class="card-header">
                تفکیک هزینه ها و دستمزد ها و پاداش ها
            </div>
            <div class="card-body row table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>نوع تراکنش</th>
                            <th>مبلغ</th>
                            <th>توضیحات</th>
                            <th>طرف حساب</th>
                            <th>دسته بندی</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($case->transactions as $transaction)
                            <tr>
                                <td>[[ $transaction->transaction_type ]]</td>
                                <td>[[ $transaction->amount ]]</td>
                                <td>[[ $transaction->description ]]</td>
                                <td>[[ $transaction->counterparty ]]</td>
                                <td>[[ $transaction->catagory ]]</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    @endif
    @php
        $fieldName = 'فایل های مرتبط با پرونده';
        $fieldDetails = getFieldDetailsByName($fieldName);
        $fieldValue = isset($case) ? $case->getVariable($fieldName) : null;
        $fieldValueAlt =
            (isset($case) and in_array($fieldDetails->type, ['datetime', 'date']))
                ? $case->getVariable($fieldName . '_alt')
                : null;
    @endphp
    <div class="">
        <p class="bg-warning text-center card">دقت داشته باشید این فایل های زیر به مشتری نمایش داده خواهد شد</p>
        @include('SimpleWorkflowView::Core.Form.field-generator', [
            'fieldName' => $fieldName,
            'fieldId' => $fieldName,
            'fieldClass' => 'col-sm-12',
            'readOnly' => true,
            'required' => false,
            'fieldValue' => $fieldValue,
            'fieldValueAlt' => $fieldValueAlt ?? '',
        ])
    </div>
@endsection
@section('script')
    <script>
        $('#repair_category').change(function() {
            var fd = new FormData();
            fd.append('case_number', '[[ $case->number ]]');
            fd.append('repair_category', $(this).val());
            send_ajax_formdata_request(
                '[[ route('
                simpleWorkflowReport.all - requests.update ') ]]',
                fd,
                function(response) {
                    show_message(response.message);
                }
            )
        })
    </script>
@endsection
