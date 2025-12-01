<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Product::with(['category', 'location'])->get();
    }

    public function headings(): array
    {
        return [
            'SKU',
            'Name',
            'Category',
            'Description',
            'Stock Quantity',
            'Value',
            'Location',
            'Status',
            'Created At',
        ];
    }

    /**
     * @param  Product  $product
     */
    public function map($product): array
    {
        return [
            $product->sku,
            $product->name,
            $product->category ? $product->category->name : '-',
            $product->description ?? '-',
            $product->stock_quantity,
            $product->value,
            $product->location ? $product->location->name : '-',
            $product->status,
            $product->created_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
