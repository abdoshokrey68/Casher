<?php

namespace App\Exports;

use App\Models\product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'ID',
            'Name',
        ];
    }

    public function collection()
    {
        return collect(product::getproducts());
    }
}
