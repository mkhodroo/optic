<?php

namespace Behin\SimpleWorkflowReport\Controllers\Core;

use App\Http\Controllers\Controller;
use Behin\SimpleWorkflow\Models\Entities\Customers;
use Behin\SimpleWorkflowReport\Exports\CustomersExport;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CustomersReportController extends Controller
{
    /**
     * List customers with optional search/filter.
     * Inactive customers are hidden by default unless show_inactive is set.
     */
    public function index(Request $request): View
    {
        $search = $this->buildSearchQuery($request);
        $showInactive = $request->boolean('show_inactive');

        $customers = Customers::query()
            ->when(!$showInactive, fn($q) => $q->where('is_active', true))
            ->when($search['fullname'], fn($q, $v) => $q->where('fullname', 'like', "%{$v}%"))
            ->when($search['mobile'], fn($q, $v) => $q->where('mobile', 'like', "%{$v}%"))
            ->when($search['national_id'], fn($q, $v) => $q->where('national_id', 'like', "%{$v}%"))
            ->when($search['customer_job'], fn($q, $v) => $q->where('customer_job', 'like', "%{$v}%"))
            ->orderByDesc('created_at')
            ->paginate(25)
            ->appends($request->except('page'));

        return view('SimpleWorkflowReportView::Core.Customers.index', compact('customers', 'search', 'showInactive'));
    }

    /**
     * Show a single customer with their case history.
     */
    public function show(Customers $customer): View
    {
        $cases = DB::table('wf_entity_case_customer as cc')
            ->leftJoin('wf_cases as cases', 'cases.id', '=', 'cc.case_id')
            ->select(
                'cc.case_id',
                'cc.case_number',
                'cases.status',
                'cc.address',
                'cc.postal_code',
                'cc.eco_number',
                'cc.created_at'
            )
            ->where('cc.customer_id', $customer->id)
            ->whereNull('cc.deleted_at')
            ->orderByDesc('cc.created_at')
            ->get();

        $stats = [
            'total_cases' => $cases->count(),
            'open_cases'  => $cases->where('status', '!=', 'canceled')->where('status', '!=', 'done')->count(),
            'done_cases'  => $cases->where('status', 'done')->count(),
        ];

        return view('SimpleWorkflowReportView::Core.Customers.show', compact('customer', 'cases', 'stats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateCustomer($request);

        Customers::create($data);

        return redirect()
            ->route('simpleWorkflowReport.customers.index')
            ->with('success', 'مشتری با موفقیت ثبت شد.');
    }

    public function update(Request $request, Customers $customer): RedirectResponse
    {
        $data = $this->validateCustomer($request);

        $customer->update($data);

        return redirect()
            ->route('simpleWorkflowReport.customers.index')
            ->with('success', 'اطلاعات مشتری با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Customers $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()
            ->route('simpleWorkflowReport.customers.index')
            ->with('success', 'مشتری با موفقیت حذف شد.');
    }

    /**
     * Deactivate a customer without deleting the record.
     * Uses forceFill because is_active is not in the Customers model's fillable
     * (the model lives in the separate behin-simple-workflow package).
     */
    public function disable(Customers $customer): RedirectResponse
    {
        $customer->forceFill(['is_active' => false])->save();

        return redirect()
            ->back()
            ->with('success', 'مشتری غیرفعال شد.');
    }

    /**
     * Reactivate a previously disabled customer.
     */
    public function enable(Customers $customer): RedirectResponse
    {
        $customer->forceFill(['is_active' => true])->save();

        return redirect()
            ->back()
            ->with('success', 'مشتری فعال شد.');
    }

    public function export(Request $request): BinaryFileResponse
    {
        $showInactive = $request->boolean('show_inactive');

        $customers = Customers::query()
            ->when(!$showInactive, fn($q) => $q->where('is_active', true))
            ->when($request->input('fullname'), fn($q, $v) => $q->where('fullname', 'like', "%{$v}%"))
            ->when($request->input('mobile'), fn($q, $v) => $q->where('mobile', 'like', "%{$v}%"))
            ->when($request->input('national_id'), fn($q, $v) => $q->where('national_id', 'like', "%{$v}%"))
            ->when($request->input('customer_job'), fn($q, $v) => $q->where('customer_job', 'like', "%{$v}%"))
            ->orderBy('fullname')
            ->get();

        return Excel::download(new CustomersExport($customers), 'customers.xlsx');
    }

    /**
     * Validate customer data including customer_job.
     */
    protected function validateCustomer(Request $request): array
    {
        return $request->validate([
            'fullname'      => ['required', 'string', 'max:255'],
            'national_id'   => ['nullable', 'string', 'max:50'],
            'mobile'        => ['nullable', 'string', 'max:50'],
            'address'       => ['nullable', 'string'],
            'customer_job'  => ['nullable', 'string'],
        ], [], [
            'fullname'      => 'نام و نام خانوادگی',
            'national_id'   => 'کد ملی',
            'mobile'        => 'شماره موبایل',
            'address'       => 'آدرس',
            'customer_job'  => 'شغل',
        ]);
    }

    /**
     * Build the search filters array from request.
     */
    private function buildSearchQuery(Request $request): array
    {
        return [
            'fullname'     => trim((string) $request->input('fullname', '')),
            'mobile'       => trim((string) $request->input('mobile', '')),
            'national_id'  => trim((string) $request->input('national_id', '')),
            'customer_job' => trim((string) $request->input('customer_job', '')),
        ];
    }
}
