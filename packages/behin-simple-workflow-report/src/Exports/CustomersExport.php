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
            'تاریخ ثبت',
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->fullname,
            $customer->national_id,
            $customer->mobile,
            $this->formatJob($customer->customer_job),
            $customer->address,
            optional($customer->created_at)->format('Y-m-d H:i'),
        ];
    }

    /**
     * Convert the JSON customer_job field into a readable string for Excel.
     */
    private function formatJob(?string $job): string
    {
        if (empty($job)) {
            return '';
        }

        $decoded = json_decode($job, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $parts = array_filter([
                $decoded['title'] ?? null,
                $decoded['industry'] ?? null,
                $decoded['experience'] ?? null,
            ]);

            return $parts ? implode(' - ', $parts) : '';
        }

        return (string) $job;
    }
}
