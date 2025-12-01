<?php

namespace App\Exports;

use App\Models\InboundShipment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InboundShipmentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return InboundShipment::with('customer')->get();
    }

    public function headings(): array
    {
        return [
            'Tracking Number',
            'Customer',
            'Received Date',
            'Status',
            'Total Items',
            'Notes',
            'Created At',
        ];
    }

    /**
     * @param  InboundShipment  $shipment
     */
    public function map($shipment): array
    {
        return [
            $shipment->tracking_number,
            $shipment->customer->name,
            $shipment->received_date->format('Y-m-d'),
            ucfirst($shipment->status),
            $shipment->total_items,
            $shipment->notes ?? '-',
            $shipment->created_at->format('Y-m-d H:i:s'),
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
