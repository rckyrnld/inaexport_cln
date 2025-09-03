<?php

namespace App\Exports;

use App\Models\MasterProvince;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ProvinceExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MasterProvince::orderby('province_en', 'asc')
        					->select('id','province_en','province_in','province_chn')
        					->get();
    }

    public function headings(): array
    {
        return [
            'ID',
        	'Province (EN)',
        	'Province (IN)',
        	'Province (CHN)'
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
