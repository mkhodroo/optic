<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use Behin\SimpleWorkflow\Models\Entities\Repair_incomes;
use Behin\SimpleWorkflowReport\Exports\ExcelExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Behin\SimpleWorkflowReport\Exports\MonthlyRequestsReportExport;
use Behin\SimpleWorkflowReport\Models\Core\Cases;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Log;
use Morilog\Jalali\Jalalian;

class MonthlyRequestsReportController extends AllRequestsReportController
{
    /**
     * گزارش تجمیعی ماهانه
     */
    public function baseQuery1()
    {
        $query = Cases::query();
        $query = $query->with([
            'repairIncomes',
            'caseCustomer',
            'repair',
            'repairCategory'
        ])->where('process_id', '879e001c-59d5-4afb-958c-15ec7ff269d1');

        // $query = $query->whereHas('repairIncomes',function($q){
        //     $q->where('payment_amount', '180,000,000');
        // });
        return $query;
    }


    public function report(Request $request)
    {
        $year  = $request->input('year') ? $request->input('year') : Jalalian::now()->format('Y');   // مثلا 1403
        $month = $request->input('month') ? $request->input('month') : Jalalian::now()->format('m');  // مثلا 05

        if (!$year || !$month) {
            return response()->json([
                'message' => 'سال و ماه الزامی است'
            ], 422);
        }
        $date = $year . '-' . $month . '-01';
        $from = Jalalian::fromFormat('Y-m-d', $date)->getFirstDayOfMonth()->toCarbon();
        $to = Jalalian::fromFormat('Y-m-d', $date)->getEndDayOfMonth()->toCarbon();

        $query = $this->baseQuery1();
        $query->whereBetween('created_at', [$from, $to]);
        $query->whereNot('status', config('workflow.caseStatus.canceled.key'));

        // $rows = $this->prepareRows($query->get());
        // return $query->get();
        $itemsQuery =  clone $query;
        $rows = $query->orderBy('number', 'desc')->get();
        foreach ($rows as $row) {
            if (isset($row->repair->repair_start_date)) {
                $startDateAlt = convertPersianDateToTimestamp($row->repair->repair_start_date, 'miliseconds');
                $row->repair->repair_start_date_alt = $startDateAlt;
                $row->repair->save();
            }
            if (isset($row->repair->repair_end_date)) {
                $endDateAlt = convertPersianDateToTimestamp($row->repair->repair_end_date, 'miliseconds');
                $row->repair->repair_end_date_alt = $endDateAlt;
                $row->repair->save();
            }
        }

        return view('SimpleWorkflowReportView::Core.MonthlyRequest.index')->with([
            'year' => $year,
            'month' => $month,
            'rows' => $rows,
            'total' => $rows->count(),
            'electronic' => (clone $itemsQuery)->whereHas('repairCategory', function($query){
                $query->where('value', 'الکترونیک');
            })->count(),
            'optic' => (clone $itemsQuery)->whereHas('repairCategory', function($query){
                $query->where('value', 'اپتیک');
            })->count(),
            'optic_electronic' => (clone $itemsQuery)->whereHas('repairCategory', function($query){
                $query->where('value', 'اپتیک و الکترونیک');
            })->count(),
            'others' => (clone $itemsQuery)->whereHas('repairCategory', function($query){
                $query->where('value', 'سایر');
            })->count(),
            'no_category' => (clone $itemsQuery)->whereHas('repairCategory', function($query){
                $query->whereNull('value');
            })->count(),
            'total_incomes' => $rows->sum('total_received')
        ]);
    }

    /**
     * خروجی اکسل گزارش ماهانه
     */
    public function export(Request $request): BinaryFileResponse
    {
        $year  = $request->input('year') ? $request->input('year') : Jalalian::now()->format('Y');   // مثلا 1403
        $month = $request->input('month') ? $request->input('month') : Jalalian::now()->format('m');  // مثلا 05

        $date = $year . '-' . $month . '-01';
        $from = Jalalian::fromFormat('Y-m-d', $date)->getFirstDayOfMonth()->toCarbon();
        $to = Jalalian::fromFormat('Y-m-d', $date)->getEndDayOfMonth()->toCarbon();

        $query = $this->baseQuery1();
        $query->whereBetween('created_at', [$from, $to]);
        $query->whereNot('status', config('workflow.caseStatus.canceled.key'));

        // $rows = $this->prepareRows($query->get());
        // return $query->get();
        $rows = $query->orderBy('number', 'desc')->get();

        $filename = "monthly_report_{$year}_{$month}.xlsx";

        $columns = [
            ['label' => 'شماره پرونده', 'key' => 'number'],
            ['label' => 'تاریخ ایجاد', 'key' => 'created_at'],
            ['label' => 'مشتری', 'key' => 'caseCustomer.fullname'],
            ['label' => 'دسته بندی', 'key' => 'repair_category'],
            ['label' => 'نوع تعمیر', 'key' => 'repair.repair_type'],
            ['label' => 'جزئیات نوع تعمیر', 'key' => 'repair.repair_subtype'],
            ['label' => 'تعمیرکار', 'key' => 'repairman_name'],
            ['label' => 'شروع', 'key' => 'repair_start_date'],
            ['label' => 'پایان', 'key' => 'repair_end_date'],
            ['label' => 'مدت تعمیرات', 'key' => 'duration'],

        ];

        $formattedRows = collect();
        foreach ($rows as $row) {
            $rowData = $row->toArray(); 
            $types = json_decode($row->repair?->repair_type);
            $subtypes = json_decode($row->repair?->repair_subtype);

            $rowData['created_at'] = $row->created_at ? toJalali($row->created_at) : '';
            $rowData['caseCustomer.fullname'] = $row->caseCustomer?->fullname ?? '';
            $rowData['repair_category'] = $row->repairCategory?->value ?? '';
            $rowData['repair.repair_type'] = $types ? implode(',', $types) : '';
            $rowData['repair.repair_subtype'] = $subtypes ? implode(',', $subtypes) : '';
            $rowData['repairman_name'] = $row->repair?->repairman()?->name ?? '';
            $rowData['repair_start_date'] = convertPersianToEnglish($row->repair?->repair_start_date) ?? '';
            $rowData['repair_end_date'] = convertPersianToEnglish($row->repair?->repair_end_date) ?? '';
            $rowData['duration'] = $row->repair?->totalRepairDuration() ?? '';
            Log::info($rowData);
            $formattedRows->push($rowData);
        }
        

        return Excel::download(
            new ExcelExport($formattedRows, $columns),
            $filename
        );
    }
}
