<?php

namespace App\Exports;

use App\Models\EventDetail;
use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

class EventParticipantsExport extends DefaultValueBinder implements FromArray, WithHeadings, ShouldAutoSize, WithEvents, WithCustomValueBinder
{
    function __construct($event_id)
    {
        $this->event_id = $event_id;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function array(): array
    {
        $dataEvent = EventDetail::with('participants', 'participants.supplier', 'participants.buyer', 'participants.supplier.profile', 'participants.buyer.profile_buyer')->whereId($this->event_id)->first();
        
        $data = [];
        foreach ($dataEvent->participants as $key => $value) {
            $data[$key][] = $key + 1;
            if ($value->supplier != '') {
                $data[$key][] = $value->supplier->profile->company;
                $data[$key][] = $value->supplier->email;
                $data[$key][] = $value->supplier->profile->phone;
                $data[$key][] = date('d M Y H:i:s', strtotime($value->created_at));
                if (count($value->supplier->profile->contact_person) > 0) {
                    $array_cp = array_column($value->supplier->profile->contact_person->toArray(), 'name');
                    $data[$key][] = implode(', ', $array_cp);
                } else {
                    $data[$key][] = '';
                }
            } elseif ($value->buyer != '') {
                $data[$key][] = $value->buyer->profile_buyer->company;
                $data[$key][] = $value->buyer->email;
                $data[$key][] = $value->buyer->profile_buyer->phone;
                $data[$key][] = date('d M Y H:i:s', strtotime($value->created_at));
                $data[$key][] = '';
            } else {
                $data[$key][] = '';
                $data[$key][] = '';
                $data[$key][] = '';
                $data[$key][] = date('d M Y H:i:s', strtotime(now()));
                $data[$key][] = '';
            }
        }
        return $data;

    }

    public function headings(): array
    {
        return [
            'No',
            'Company',
            'Email',
            'Phone',
            'Register At',
            'Contact Person'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:W1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(13);
            },

        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }
}
