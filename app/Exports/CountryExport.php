<?php

namespace App\Exports;

use App\Models\MasterCountry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class CountryExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MasterCountry::leftjoin('mst_group_country as a','a.id','=','mst_country.mst_country_group_id')
      						  ->orderby('mst_country.country', 'asc')
      						  ->select('mst_country.kode_bps','mst_country.country','a.group_country')
      						  ->get();
    }

    public function headings(): array
    {
        return [
        	'Kode BPS', 
        	'Country',
        	'Group'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(13);
            },

        ];
    }
}
