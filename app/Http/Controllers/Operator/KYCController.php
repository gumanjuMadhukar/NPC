<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\KYC\StoreRequest;
use App\Models\Level;
use App\Models\Certificate;
use App\Models\Program;
use App\Models\Kyc;
use App\Services\Operator\KYCService;
use App\Services\Operator\CertificateService;
use Illuminate\Http\Request;

class KYCController extends Controller
{

    public function __construct(protected KYCService $service, protected CertificateService $certificateService)
    {
    }

    public function list(Request $request)
    {
        $data['nav'] = 'kyc';
        $data['sub_nav'] = '';
        $data['page_title'] = 'KYC';
        $per_page = 200;
        $page =  $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['result'] = $this->service->list($per_page, $page, $data['q']);
        return view('operator.kyc.list', $data);
    }
    public function delete(Request $request)
    {
        // dd($request);
        return $this->service->delete($request->id);
    }

    public function certificate(Request $request){
        $data['nav'] = 'kyc/certificate';
        $data['sub_nav'] = '';
        $data['page_title'] = 'KYC Certificate Search';
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['decision_date'] = $request->decision_date ?? '';
        $data['decision_dates'] = Certificate::select('decision_date')->distinct()->orderby('decision_date', 'desc')->get();
        // dd($data['dicision_dates']);
        $data['levels'] = Level::select('*')->where('status', 1)->where('id', '<', '5')->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('name', 'desc')->get();
        $data['is_printed'] =$request->is_printed ?? "";
        $per_page = 20;
        $page =  $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['result'] = $this->service->certificate_list($per_page, $page, $data['q'],$data['is_printed'], $data['level_id'], $data['program_id'],  $data['decision_date']);
        return view('operator.kyc.certificate_list', $data);
    }

    public function allocate_form($id, $name){
        $data['id'] = $id;
        $data['name'] = $name;
        $data['nav'] = 'kyc';
        $data['sub_nav'] = '';
        $data['page_title'] = 'KYC Allocate Form';
        $data['kyc_records'] = Kyc::where('name', 'like', '%'.$name.'%')->get();
        // dd($data['kyc_records']);
        return view('operator.kyc.allocate_form', $data);
    }

    public function json_list(Request $request){
        $term = $request['term']['term'];
        $response['message'] = '';
        $response['error'] = null;
        $response['status'] = 201;
        $response['data'] = Kyc::where('name', 'like', '%'.$term.'%')->get();
        return response()->json($response['data'], $response['status']);
    }

    public function save(Request $request){
        try{
            $id = $request['id'];
            $user_id = $request['user_id'];
            if($user_id){
                $certificate = Certificate::where('id', $id)->first();
                $certificate->user_id = $user_id;
                $certificate->update();
                return redirect()->route('operator-certificate-profile', ['id' => $id]);
            }
            else{
                return response()->json(['error' => 'Please select the kyc record'], 400);
            }
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
