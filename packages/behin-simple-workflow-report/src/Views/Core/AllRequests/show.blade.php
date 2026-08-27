@extends('behin-layouts.app')

@section('title', 'جزئیات درخواست')

@section('content')
    <input type="hidden" id="caseId" value="[[ $case->id ]]">
    @include('SimpleWorkflowView::Core.Form.field-generator', [
        'fieldName' => 'نماینده یا نمایندگان مشتری',
        'fieldId' => 'case_customers',
        'fieldClass' => 'col-sm-12',
        'readOnly' => false,
        'required' => false,
        'fieldValue' => null,
        'fieldValueAlt' => null ?? '',
    ])
    <div class="card row">
        <div class="card-header">
            اطلاعات مشتری با شماره پرونده: [[ $case->number ]]
        </div>
        <div class="card-body row">

            <div class="col-sm-3">
                <label for="">نام مشتری</label>
                <p>[[ $case->customer?->fullname ]]</p>
            </div>
            <div class="col-sm-3">
                <label for="">موبایل مشتری</label>
                <p>[[ $case->customer?->mobile ]]</p>
            </div>
            <div class="col-sm-12">
                <label for="">آدرس مشتری</label>
                <p>[[ $case->customer?->address ]]</p>
            </div>
            <div class="col-sm-12">
                <label for="">لینک کوتاه مشاهده جزئیات پرونده توسط مشتری</label>
                @if ($case->getVariable('tracking_url'))
                    <a href="[[ $case->getVariable('tracking_url') ]]" target="_blank">
                        [[ $case->getVariable('tracking_url') ]]
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            اطلاعات پذیرش اولیه
        </div>
        <div class="card-body row">
            <div class="col-sm-3">
                <label for="">تاریخ پذیرش</label>
                <p>[[ $case->getVariable('receive_date') ]]</p>
            </div>
            <div class="col-sm-3">
                <label for="">نوع بسته بندی</label>
                <p>[[ $case->getVariable('device_packaging_type') ]]</p>
            </div>
            <div class="col-sm-3">
                <label for="">لوازم همراه دستگاه</label>
                <p>[[ $case->getVariable('device_accessories') ]]</p>
            </div>
            <div class="col-sm-3">
                <label for="">توضیحات اولیه مشتری</label>
                <p>[[ $case->getVariable('customer_description') ]]</p>
            </div>
            <div class="col-sm-3">
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
        <div class="card-header">
            اطلاعات تعمیرات
        </div>
        <div class="card-body row">
            <div class="col-sm-3">
                <label for="">نام تعمیرکار</label>
                <p>[[ getUserInfo($case->deviceRepair?->repairman)?->name ?? $case->deviceRepair?->repairman ]]</p>
            </div>
            <div class="col-sm-3">
                <label for="">نوع تعمیر</label>
                <p>
                    @if ($case->deviceRepair?->repair_type)
                        @php
                            $repairType = normalizeList($case->deviceRepair?->repair_type);
                        @endphp
                        @foreach ($repairType as $type)
                            <span class="badge bg-primary">[[ $type ]]</span>
                        @endforeach
                    @endif
                </p>
            </div>
            <div class="col-sm-3">
                <label for="">جزئیات نوع تعمیر</label>
                <p>
                    @php
                        $repairSubtype = normalizeList($case->deviceRepair?->repair_subtype);
                    @endphp
                    @foreach ($repairSubtype as $subtype)
                        <span class="badge bg-primary">[[ $subtype ]]</span>
                    @endforeach
                </p>
            </div>
            <div class="col-sm-3">
                <label for="">تاریخ شروع تعمیر</label>
                <p>[[ $case->deviceRepair?->repair_start_date ]]</p>
            </div>
            <div class="col-sm-3">
                <label for="">نام دستیار تعمیرکار</label>
                <p>
                    @if ($assistants)
                        @foreach ($assistants as $assitant)
                            [[ $assitant?->name ]]
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                        {{-- @if (gettype($case->deviceRepair?->repairman_assitant) == 'string')
                            string
                        @elseif(gettype($case->deviceRepair?->repairman_assitant) == 'array')
                            @foreach ($case->deviceRepair?->repairman_assitant as $assitant)
                                array
                            @endforeach
                        @else
                            @foreach ($case->deviceRepair?->repairman_assitant as $assitant)
                                [[ getUserInfo($assitant)?->name ]]
                @if (!$loop->last)
                ,
                @endif
                @endforeach
                @endif --}}
                    @endif
                </p>
            </div>
            <div class="col-sm-3">
                <label for="">تاریخ پایان تعمیر</label>
                <p>[[ $case->deviceRepair?->repair_end_date ]]</p>
            </div>
            <div class="col-sm-12">
                <label for="">گزارش تعمیر</label>
                <p>[[ $case->deviceRepair?->repair_report ]]</p>
            </div>
        </div>
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
