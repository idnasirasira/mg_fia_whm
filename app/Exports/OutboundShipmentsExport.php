<?php

namespace App\Exports;

use App\Models\OutboundShipment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OutboundShipmentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return OutboundShipment::with(['customer', 'shippingZone'])->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Tracking Number',
            'Customer',
            'Shipping Date',
            'Destination Country',
            'Carrier',
            'Status',
            'Customs Value',
            'Shipping Cost',
            'Shipping Zone',
            'Created At',
        ];
    }

    /**
     * @param OutboundShipment $shipment
     * @return array
     */
    public function map($shipment): array
    {
        return [
            $shipment->tracking_number,
            $shipment->customer->name,
            $shipment->shipping_date->format('Y-m-d'),
            config('countries.countries')[$shipment->destination_country] ?? $shipment->destination_country,
            $shipment->carrier ?? '-',
            ucfirst(str_replace('_', ' ', $shipment->status)),
            $shipment->customs_value,
            $shipment->shipping_cost,
            $shipment->shippingZone ? $shipment->shippingZone->name : '-',
            $shipment->created_at->format('Y-m-d H:i:s'),
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
