<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamApply;
use App\Models\ExamLog;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data['nav'] = 'dashboard';
        $data['sub_nav'] = '';
        $data['page_title'] = "Dashboard";
        $data['lastest_apply'] = ExamApply::where('user_id', Auth::Guard('student')->id())->whereHas('exam', function($qry) { $qry->where('status', 1);})->orderBy('id', 'desc')->first();
        if(!$data['lastest_apply']) {
            $data['lastest_apply'] = ExamApply::where('user_id', Auth::Guard('student')->id())->whereNull('exam_id')->orderBy('id','desc')->first();
        }
        $data['exam_logs'] = ExamLog::select('*')->where(['user_id' => Auth::guard('student')->id(), 'exam_apply_id' => $data['lastest_apply']?->id])->get();
        return view('student.dashboard.index', $data);
    }
}
