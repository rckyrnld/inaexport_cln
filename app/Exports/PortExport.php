<?php

namespace App\Exports;

use App\Models\MasterPort;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PortExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MasterPort::leftjoin('mst_province as a', 'a.id','=','mst_port.id_mst_province')
					      ->orderby('mst_port.name_port', 'asc')
					      ->select('mst_port.name_port', 'a.province_en')
					      ->get();
    }

    public function headings(): array
    {
        return [
        	'Port',
        	'Province'
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
