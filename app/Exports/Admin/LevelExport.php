<?php

namespace App\Exports\Admin;

use App\Models\Level;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class LevelExport implements FromArray, ShouldAutoSize, WithHeadings, WithTitle, WithEvents
{

    protected $index = 0;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function array(): array
    {

        $data = array();
        $levels = Level::select('*')->get();
        if ($levels->count() > 0) {
            foreach ($levels as $level) {
                array_push($data, array('level_id' => $level->id, 'name' => $level->name, 'status' => $level->status));
            }
        }
        return $data;

    }

    public function title(): string
    {
        return 'Level';
    }

    public function headings(): array
    {
        $header = ['LEVEL_ID', 'NAME', 'STATUS'];
        return [$header];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:C1')->applyFromArray([
                    'font' => [
                        'size' => '12px',
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
