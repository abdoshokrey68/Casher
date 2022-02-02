<?php

namespace App\Exports;

use App\Models\invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoiceExport implements FromCollection, WithHeadings
{
    public $store_id;
    public $getfrom;
    public $getto;

    public function __construct($store_id, $getfrom, $getto)
    {
        $this->store_id = $store_id;
        $this->getfrom  = $getfrom;
        $this->getto    = $getto;
    }

    public function headings(): array
    {
        return [
            'Invoice NO.', 'store_id', 'discount', 'total', 'UserName', 'table_id', 'Date'
        ];
    }

    public function collection()
    {
        return collect(invoice::getInvoice($this->store_id, $this->getfrom, $this->getto));
    }
}
