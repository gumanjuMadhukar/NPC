<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\Kyc\KycRequest;
use App\Models\Kyc;
use App\Models\Program;
use App\Models\UserInfo;
use App\Models\Level;
use App\Services\Student\KycService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KycController extends Controller
{

    public function __construct(protected KycService $service)
    {
    }
    public function index()
    {
        $data['kyc'] = Kyc::where('user_id', Auth::guard('student')->id())->first();
        $data['nav'] = 'kyc';
        $data['sub_nav'] = '';
        $data['page_title'] = "KYC Form";
        return view('student.kyc.form', $data);
    }


    public function saveKyc(KycRequest $request)
    {
        return $this->service->saveApply($request->validated());
    }
}
