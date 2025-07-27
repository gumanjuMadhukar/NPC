<?php

namespace App\Exports\Admin;

use App\Models\Program;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class ProgramExport implements FromArray, ShouldAutoSize, WithHeadings, WithTitle, WithEvents
{

    protected $index = 0;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function array(): array
    {

        $data = array();
        $programs = Program::select('*')->get();
        if ($programs->count() > 0) {
            foreach ($programs as $program) {
                array_push($data, array('level_id' => $program->level_id, 'program_id' => $program->id, 'name' => $program->name, 'status' => $program->status));
            }
        }
        return $data;

    }

    public function title(): string
    {
        return 'Program';
    }

    public function headings(): array
    {
        $header = ['LEVEL_ID', 'PROGRAM_ID', 'NAME', 'STATUS'];
        return [$header];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:D1')->applyFromArray([
                    'font' => [
                        'size' => '12px',
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
