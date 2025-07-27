<?php

namespace App\Exports\Admin;

use App\Models\ExamApply;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class ApplicantExport implements FromArray, ShouldAutoSize, WithHeadings, WithTitle, WithEvents
{

    protected $index = 0;
    /**
     * @return \Illuminate\Support\Collection
     */

     protected $exam_id;

     public function __construct($exam_id)
     {
         $this->exam_id = $exam_id;
     }

    public function array(): array
    {

        $data = array();
        $exam_applies = ExamApply::select('*')->where(['is_admit_card_generate' => 1, 'exam_id' =>$this->exam_id])->get();
        if ($exam_applies->count() > 0) {
            foreach ($exam_applies as $exam_apply) {
                array_push($data, array('id' => $exam_apply->user->id, 'level_id' => $exam_apply->user->info->level_id, 'program_id' => $exam_apply->user->info->program_id, 'name' => $exam_apply->user->name, 'email' => $exam_apply->user->email, 'phone' => $exam_apply->user->phone, 'symbol_number' => $exam_apply->admit_card->symbol_number ?? '', 'date_of_birth' => $exam_apply->user->info->dob_eng, 'photo' => $exam_apply->user->info->full_profile_picture));
            }
        }
        return $data;

    }

    public function title(): string
    {
        return 'Applicants';
    }

    public function headings(): array
    {

        
        $header = ['id', 'level_id', 'program_id', 'name', 'email', 'phone', 'symbol_number', 'date_of_birth', 'photo' ];
        return [$header];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:I1')->applyFromArray([
                    'font' => [
                        'size' => '12px',
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
