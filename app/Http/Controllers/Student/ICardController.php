<?php 
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\ExamApply;
use Illuminate\Support\Facades\Auth;

class ICardController extends Controller{

    public function idCard() 
    {
        $data['nav'] = 'idcard';
        $data['sub_nav'] = '';
        $data['page_title'] = 'idcard';
        // $data['exam_apply'] = ExamApply::where('user_id', Auth::guard('student')->id())->orderby('id','desc')->first();
        $data['certificate'] = Certificate::where('user_id', Auth::guard('student')->id())->where('is_printed',1)->first();
        
        return view('student.idcard.index', $data);
    }
    
}