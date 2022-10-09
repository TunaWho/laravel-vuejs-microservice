<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Excel;

class OrdersExport implements FromCollection, WithHeadings, WithMapping, Responsable
{
    use Exportable;

    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     *
     * @var string
     */
    private $fileName = 'orders.csv';

    /**
     * Optional Writer Type
     *
     * @var Excel
     */
    private $writerType = Excel::CSV;

    /**
     * Optional headers
     *
     * @var array<string, string>
     */
    private $headers = [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => 'attachment; filename=orders.csv',
        'Pragma'              => 'no-cache',
        'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
        'Expires'             => '0',
    ];

    /**
     * The collection function returns all orders with their order items
     *
     * @return A collection of all orders with their order items.
     */
    public function collection()
    {
        return Order::with('orderItems')->get();
    }

    /**
     * @param Order $order The order instance.
     */
    public function map($order): array
    {
        return [
            $order->id,
            $order->name,
            $order->email,
            $order->orderItems->pluck('product_title')->implode(', '),
            $order->orderItems->pluck('price')->implode(', '),
            $order->orderItems->pluck('quantity')->implode(', '),
        ];
    }

    /**
     * The headings function returns an array of the column headings for the CSV file
     *
     * @return array The headings of the table.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Product Title',
            'Price',
            'Quantity',
        ];
    }
}
