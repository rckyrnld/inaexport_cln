<?php

namespace App\Exports;

use App\Models\MasterCity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class CityExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MasterCity::leftjoin('mst_country as a', 'a.id','=','mst_city.id_mst_country')
					      ->orderby('a.country', 'asc')
					      ->orderby('mst_city.city', 'asc')
					      ->select('a.country', 'mst_city.city')
					      ->get();
    }

    public function headings(): array
    {
        return [
        	'Country',
        	'City'
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
