<?php

namespace App\Exports\Officer;

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

class ApplicantProgramExport implements FromQuery, ShouldAutoSize, WithMapping, WithHeadings, WithTitle, WithEvents
{

    protected $request;
    protected $title;
    protected $exam;
    protected $index = 0;
    public function __construct($request)
    {
        $this->request = $request;
        $this->exam = Exam::where('id', $this->request['exam_id'])->first();
        $this->title = $this->exam->name ?? 'TSLC' . ' -  Applicant List';
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function query()
    {
        $exam_id = $this->request['exam_id'];
        $data = ExamApply::selectRaw('count(*) as count, programs.name as name')
            ->leftJoin('programs', 'exam_applies.program_id', '=', 'programs.id')
            ->groupBy('program_id')
            ->orderBy('exam_applies.level_id')->orderBy('program_id');
        if ($exam_id) {
            if ($exam_id == 'tslc') {
                $data->whereNull('exam_id');
            } else {
                $data->where('exam_id', $exam_id);
            }
        }
        return $data;
    }

    public function map($data): array
    {
        return [
            ++$this->index,
            $this->exam->name,
            $data->name,
            $data->count
        ];
    }

    public function title(): string
    {
        return $this->title;
    }

    public function headings(): array
    {
        $header1 = [$this->title];
        $header2 = ['S.N', 'Exam', 'Program', 'Count'];
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
