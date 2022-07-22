<?php

namespace App\Exports;

use App\Models\PaymentExcel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PaymentExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PaymentExcel::all();
    }

    public function headings(): array
    {
        return ["Date", "Ref", "Acc", "Names/ID", "Amount", "Deb/Cred"];
    }
}
