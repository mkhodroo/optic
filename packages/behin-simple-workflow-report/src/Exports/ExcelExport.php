<?php

namespace Behin\SimpleWorkflowReport\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class ExcelExport implements FromCollection, WithHeadings, WithMapping
{
    protected Collection $rows;
    protected array $columns;

    public function __construct(Collection $rows, array $columns)
    {
        $this->rows = $rows;
        $this->columns = $columns;
    }

    public function collection(): Collection
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return array_column($this->columns, 'label');
    }

    public function map($row): array
    {
        // اطمینان از تبدیل هر نوع داده به آرایه نرمال
        if ($row instanceof Collection) {
            $row = $row->toArray();
        } elseif (is_object($row) && method_exists($row, 'toArray')) {
            $row = $row->toArray();
        } elseif (is_object($row)) {
            $row = json_decode(json_encode($row), true);
        }

        $mapped = [];
        foreach ($this->columns as $col) {
            $mapped[] = $row[$col['key']] ?? '';
        }

        return $mapped;
    }

}
