<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomersExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Customer::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Address',
            'Country',
            'Tax ID',
            'Created At',
        ];
    }

    /**
     * @param Customer $customer
     * @return array
     */
    public function map($customer): array
    {
        return [
            $customer->name,
            $customer->email ?? '-',
            $customer->phone ?? '-',
            $customer->address,
            config('countries.countries')[$customer->country] ?? $customer->country,
            $customer->tax_id ?? '-',
            $customer->created_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
