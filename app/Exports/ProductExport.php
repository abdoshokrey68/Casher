<?php

namespace App\Exports;

use App\Models\product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    public $store_id;

    public function __construct($store_id)
    {
        $this->store_id = $store_id;
    }

    public function headings(): array
    {
        return [
            'Product Name', 'Description', 'Price', 'Stock', 'Section'
        ];
    }

    public function collection()
    {
        return collect(product::getProducts($this->store_id));
    }
}
