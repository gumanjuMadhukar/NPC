<?php

namespace App\Exports\ExamCommittee;

use App\Models\Exam;
use App\Models\ExamApply;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ApplicantExport implements FromQuery, ShouldAutoSize, WithMapping, WithHeadings, WithTitle, WithEvents
{

    protected $request;
    protected $title;
    protected $index = 0;
    public function __construct($request)
    {
        $this->request = $request;
        $exam = Exam::where('id', $this->request['exam_id'])->first();
        $this->title = $exam->name . ' -  Applicant List';
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function query()
    {
        $exam_id = $this->request['exam_id'];
        $data = ExamApply::select('exam_applies.*')
            ->where('exam_applies.is_admit_card_generate',1);
        if ($exam_id) {
            $data->where('exam_id', $exam_id);
        }
        return $data;
    }

    public function map($data): array
    {
        // return [
        //     ++$this->index,
        //     $data->user_info->first_name,
        //     $data->user_info->middle_name,
        //     $data->user_info->last_name,
        //     $data->user_info->dob_nep,
        //     $data->admit_card->symbol_number,
        //     $data->program->name,
        //     $data->user_info->profile_picture,
        //     $data->user->email,
        //     $data->user->phone,
        // ];
        return [
            ++$this->index,
            $data->admit_card->id,
            $data->user_id,
            $data->admit_card->symbol_number,
            $data->id,
            $data->user_info->sex,
            $data->user_info->citizenship_number,
            $data->user_info->first_name,
            $data->user_info->middle_name,
            $data->user_info->last_name,
            $data->user_info->dob_nep,
            $data->user_info->profile_picture,
            $data->user_info->citizenship_front,
            $data->user->email,
            $data->user->phone,
            $data->level_id,
            $data->level->short_name_english,
            $data->program_id,
            $data->program->name,
        ];
    }

    public function title(): string
    {
        return $this->title;
    }

    public function headings(): array
    {
        $header1 = [$this->title];
        // $header2 = [
        //     'S.N',
        //     'fname',
        //     'mname',
        //     'lname',
        //     'dob_bs',
        //     'roll_num',
        //     'course',
        //     'photo',
        //     'email',
        //     'mobile'
        //  ];
        $header2 = [
            'S.N',
            'Admit Card ID',
            'Profile ID',
            'Symbol Number',
            'Exam Processing Id',
            'Gender',
            'Citizenship No.',
            'Firstname',
            'Middlename',
            'Lastname',
            'DOB (nep)',
            'Profile Picture',
            'Citizenship Front',
            'email',
            'phone',
            'Level ID',
            'Level',
            'Program ID',
            'Program'
         ];
        return [$header1, $header2];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->mergeCells('A1:L1');
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'size' => '14px',
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $event->sheet->getStyle('A2:L1')->applyFromArray([
                    'font' => [
                        'size' => '12px',
                        'bold' => true,
                    ],
                ]);
            },
        ];
    }
}
