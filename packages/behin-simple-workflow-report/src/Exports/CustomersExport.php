<?php

namespace Behin\SimpleWorkflowReport\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(protected Collection $customers)
    {
    }

    public function collection(): Collection
    {
        return $this->customers;
    }

    public function headings(): array
    {
        return [
            'نام و نام خانوادگی',
            'کد ملی',
            'شماره موبایل',
            'شغل',
            'آدرس',
            'وضعیت',
            'تاریخ ثبت',
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->fullname,
            $customer->national_id,
            $customer->mobile,
            $customer->customer_job,
            $customer->address,
            $customer->is_active ? 'فعال' : 'غیرفعال',
            optional($customer->created_at)->format('Y-m-d H:i'),
        ];
    }
}
