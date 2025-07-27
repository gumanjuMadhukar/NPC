<?php
namespace App\Services\Student;

use App\Models\Kyc;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class KycService
{
    use StoreImageTrait;
    public function list()
    {
        try {
            $data['exams'] = Kyc::select('*')->get();
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function saveApply($request)
    {
        try {
            $kyc = Kyc::where(['user_id' => Auth::guard('student')->id()])->first();
            if ($kyc) {
                $response['data'] = $kyc;
                $response['message'] = null;
                $response['error'] = 'You have already filled your kyc.';
                $response['status'] = 406;
                return response()->json($response, $response['status']);
            }
            $user_id = Auth::Guard('student')->id();

            $kyc = new Kyc();
            if (preg_match('#^data:image.*?base64,#', $request['profile_img'])) {
                $profile_img = $this->StoreBase64Image($request['profile_img'], '/student/');
            } else {
                $profile_img = ($request['profile_img']) ? $request['profile_img'] : null;
            }
            $kyc->user_id = $user_id;
            $kyc->name = $request['name'];
            $kyc->dob = $request['dob'];
            $kyc->symbol_number = $request['symbol_number'];
            $kyc->profile_img = $profile_img;
            $kyc->save();
            $response['data'] = $kyc;
            $response['message'] = 'Kyc updated successfully';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

}
