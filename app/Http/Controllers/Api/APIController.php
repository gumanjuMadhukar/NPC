<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Certificate\CertificateRenewStoreRequest;
use App\Models\Certificate;
use App\Models\Level;
use App\Models\Program;
use App\Services\Api\APIService;
use Illuminate\Http\Request;

class APIController extends Controller
{
    protected APIService $service;

    public function __construct(APIService $service)
    {
        $this->service = $service;
    }

    public function test()
    {
        return response()->json('test_success');
    }

    public function fetchUser(Request $request)
    {
        $cert_check = Certificate::where('cert_registration_number', $request['cert_registration_number'])->first();
        $programs = Program::select('id','name')->get();
        $levels = Level::select('id','name')->get();
        if ($cert_check) {
            return response()->json([
                'data' => ['user_data' => $cert_check,'programs'=>$programs, 'levels' => $levels],
                'message' => '',
                'error' => null,
                'status' => 400,
            ], 400);
        }else{
            return response()->json('Data Not Found');
        }
    }
    public function certificateRenewStore(CertificateRenewStoreRequest $request)
    {
        return $this->service->certificateRenewStore($request->validated());
    }

    
}
