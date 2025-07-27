<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\Exam\ApplyRequest;
use App\Models\ExamApply;
use App\Models\Level;
use App\Models\Program;
use App\Models\User;
use App\Models\UserInfo;
use App\Services\Student\ExamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExamController extends Controller
{

    public function __construct(protected ExamService $service)
    {
    }
    public function index()
    {
        $data['nav']        = 'exam';
        $data['sub_nav']    = '';
        $data['page_title'] = "Apply Exam";
        $data['user'] = User::where('id', Auth::guard('student')->id())->first();

        $data['result']     = $this->service->list();
        return view('student.exam.index', $data);
    }

    public function history()
    {
        $data['nav']        = 'examhistory';
        $data['sub_nav']    = '';
        $data['page_title'] = "Exam History";

        $exams = ExamApply::where('user_id', Auth::guard('student')->id())
            ->with(['exam', 'exam_logs'])
            ->orderBy('id', 'desc')
            ->get();

        $processedExams = $exams->map(function ($exam) {
            $states   = ['operator', 'officer', 'registrar', 'subject_committee', 'exam_committee', 'council'];
            $status   = 'accepted';
            $timeline = [];

            $resultStatus = optional($exam->exam)->result_status;

            foreach ($states as $state) {
                $stateStatus = $status;

                if ($exam->state === $state) {
                    $stateStatus = $exam->status;
                }

                $stateIndex        = array_search($state, $states);
                $currentStateIndex = array_search($exam->state, $states);

                if (
                    $resultStatus == 0 &&
                    in_array($state, ['exam_committee', 'council'])
                ) {
                    $stateStatus = 'progress';
                }

                $logs = collect();
                $shouldHideLogs = ($resultStatus == 0 && in_array($state, ['exam_committee', 'council']));

                if (! $shouldHideLogs) {
                    $logs = $exam->exam_logs->where('state', $state)->map(function ($log) {
                        return [
                            'timestamp' => $log->created_at->format('F j, Y H:i:s'),
                            'remarks'   => $log->remarks,
                        ];
                    });
                }

                // Show "Under Review" message for operator if status is progress
                if ($logs->isEmpty() && $state === 'operator' && $stateStatus === 'progress') {
                    $logs = collect([['timestamp' => null, 'remarks' => 'Under Review']]);
                }

                $timeline[] = [
                    'state'  => $state,
                    'status' => $stateStatus,
                    'logs'   => $logs,
                ];

                if ($exam->state === $state) {
                    $status = '';
                }
            }

            return [
                'exam_name'    => optional($exam->exam)->name ?? 'Exam',
                'applied_date' => $exam->created_at->format('F j, Y'),
                'timeline'     => $timeline,
            ];
        });

        $data['exams']     = $processedExams;
        $data['has_exams'] = $processedExams->isNotEmpty();

        return view('student.exam.history', $data);
    }


    public function apply(Request $request)
    {
        $data['nav']        = 'exam';
        $data['sub_nav']    = '';
        $data['page_title'] = "License Application Form";
        $isF                = $request->isForeign;
        // dd($isF,'shkabd');
        $data['user'] = UserInfo::where('user_id', Auth::  guard('student')->id())->first();
        if (! $data['user']) {
            return redirect()->route('student-profile-personal')->with('message', 'Please fill you profile first then only you can aply exam.');
        }
        $data['exam_id']  = $request->id ?? null;
        $data['level_id'] = ($data['exam_id']) ? Auth::guard('student')->user()->info->level_id : 4;
        if ($data['exam_id'] == null) {
            $data['programs'] = Program::where(['status' => 1, 'level_id' => $data['level_id']])->get();
            $data['levels']   = Level::where(['status' => 1, 'id' => 4])->get();
        } else {
            $data['programs'] = Program::where('status', 1)->where('level_id', '<>', 4)->get();
            $data['levels']   = Level::where('status', 1)->whereNotIn('id', [4, 5])->get();
        }
        return view('student.exam.apply', $data);
    }

    public function saveApply(ApplyRequest $request)
    {
        return $this->service->saveApply($request->validated());
    }

    public function voucherImageDelete(Request $request)
    {
        return $this->service->voucherImageDelete($request);
    }


    public function status()
    {
        $data['nav']        = 'status';
        $data['sub_nav']    = '';
        $data['page_title'] = "Exam Status";
        $data['user']       = User::where('id', Auth::guard('student')->id())->first();
        $data['exam_apply'] = ExamApply::where('user_id', Auth::guard('student')->id())->orderBy('id', 'desc')->first();
        return view("student.exam.status", $data);
    }
}
