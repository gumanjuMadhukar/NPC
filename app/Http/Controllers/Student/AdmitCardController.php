<?php 
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ExamApply;
use Illuminate\Support\Facades\Auth;

class AdmitCardController extends Controller{

    public function admitCard() 
    {
        $data['nav'] = 'admitcard';
        $data['sub_nav'] = '';
        $data['page_title'] = 'admitcard';
        $data['exam_apply'] = ExamApply::where('user_id', Auth::guard('student')->id())->orderby('id','desc')->first();
        return view('student.admitcard.index', $data);
    }
    
}