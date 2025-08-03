<?php
namespace App\Services\Student;

use App\Models\Exam;
use App\Models\ExamApply;
use App\Models\ForeignCertificateRequest;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ExamService
{
    use StoreImageTrait;
    public function list()
    {
        try {
            $current_date  = Carbon::now('UTC')->format("Y-m-d");
            $data['exams'] = Exam::select('*')->where('status', 1)->where('opening_date', '<=', $current_date)->where('closing_date', '>=', $current_date)->get();
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // public function saveApply($request)
    // {
    //     try {
    //         $exam_apply = ExamApply::where(['user_id' => Auth::guard('student')->id(), 'exam_id' => $request['exam_id']])->first();
    //         if ($exam_apply) {
    //             $response['data'] = $exam_apply;
    //             $response['message'] = null;
    //             $response['error'] = 'You have already applied for this program.';
    //             $response['status'] = 406;
    //             return response()->json($response, $response['status']);
    //         }
    //         $user_id = Auth::Guard('student')->id();

    //         $exam_status = ExamApply::where(['user_id' => $user_id, 'is_passed' => '0', 'is_admit_card_generate' => 1])->orderBy('created_at', 'desc')->first();

    //         $exam_apply = new ExamApply();
    //         if (preg_match('#^data:image.*?base64,#', $request['voucher_image'])) {
    //             $voucher_image = $this->StoreBase64Image($request['voucher_image'], '/student/');
    //         } else {
    //             $voucher_image = ($request['voucher_image']) ? $request['voucher_image'] : null;
    //         }
    //         $exam_apply->user_id = $user_id;
    //         $exam_apply->exam_id = $request['exam_id'];
    //         $exam_apply->level_id = $request['level'];
    //         $exam_apply->program_id = $request['program'];
    //         $exam_apply->voucher_image = $voucher_image;
    //         if ($exam_status) {
    //             $exam_apply->status = 're-exam';
    //             $exam_apply->state = 'operator';
    //             $exam_apply->attempt = $exam_status->attempt + 1;
    //         } else {
    //             $exam_apply->status = 'progress';
    //             $exam_apply->state = 'operator';
    //             $exam_apply->attempt = 1;
    //         }
    //         $exam_apply->save();
    //         $response['data'] = $exam_apply;
    //         $response['message'] = 'Exam Applied successfully';
    //         $response['error'] = null;
    //         $response['status'] = 200;
    //         return response()->json($response, $response['status']);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 400);
    //     }
    // }

    public function saveApply($request)
    {
        try {
            $user_id = Auth::Guard('student')->id();

            $exam_apply = ExamApply::where(['user_id' => $user_id, 'exam_id' => $request['exam_id']])->first();
            if ($exam_apply) {
                $response['data']    = $exam_apply;
                $response['message'] = null;
                $response['error']   = 'You have already applied for this program.';
                $response['status']  = 406;
                return response()->json($response, $response['status']);
            }

            // $voucher_image = null;
            // dd( $request['voucher_image'] );

            $exam_apply = new ExamApply();
            // Check if a new file was uploaded
            if (preg_match('#^data:image.*?base64,#', $request['voucher_image'])) {
                $voucher_image = $this->StoreBase64Image($request['voucher_image'], '/student/');
            } else {
                $voucher_image = ($request['voucher_image']) ? $request['voucher_image'] : null;
            }
            // The previous code had a base64 check for $request['voucher_image'].
            // If you are sending base64, ensure the frontend converts the new image to base64 and puts it in 'voucher_image' or a new field.
            // However, directly uploading the file (as suggested with `name="uploaded_voucher_image"`) is generally cleaner for files.

            $exam_apply->user_id       = $user_id;
            $exam_apply->exam_id       = $request['exam_id'];
            $exam_apply->level_id      = $request['level'];
            $exam_apply->program_id    = $request['program'];
            $exam_apply->voucher_image = $voucher_image; // Assign the determined image path

            $exam_status = ExamApply::where(['user_id' => $user_id, 'is_passed' => '0', 'is_admit_card_generate' => 1])->orderBy('created_at', 'desc')->first();

            if ($exam_status) {
                $exam_apply->status  = 're-exam';
                $exam_apply->state   = 'office_admin';
                $exam_apply->attempt = $exam_status->attempt + 1;
            } else {
                $exam_apply->status  = 'progress';
                $exam_apply->state   = 'office_admin';
                $exam_apply->attempt = 1;
            }
            $exam_apply->save();

            $response['data']    = $exam_apply;
            $response['message'] = 'Exam Applied successfully';
            $response['error']   = null;
            $response['success'] = true;
            $response['status']  = 200;
            return response()->json($response, $response['status']);

        } catch (\Exception $e) {
            Log::error("Error applying for exam: " . $e->getMessage());                                                          // Log the error
            return response()->json(['error' => 'An error occurred while applying for the exam. Please try again later.'], 400); // Generic error for user
        }
    }

    // public function saveForeignApply($request)
    // {
    //     try {
    //         $user_id = Auth::Guard('student')->id();
    //         $foreignApply = new ForeignCertificateRequest();
    //         if (preg_match('#^data:image.*?base64,#', $request['voucher_image'])) {
    //             $voucher_image = $this->StoreBase64Image($request['voucher_image'], '/student/');
    //         } else {
    //             $voucher_image = ($request['voucher_image']) ? $request['voucher_image'] : null;
    //         }
    //         $foreignApply->user_id = $user_id;
    //         $foreignApply->level_id = $request['level'];
    //         $foreignApply->program_id = $request['program'];
    //         $foreignApply->voucher_image = $voucher_image;

    //         $foreignApply->save();
    //         $response['data'] = $foreignApply;
    //         $response['message'] = 'Foreign Liscence Applied successfully';
    //         $response['error'] = null;
    //         $response['status'] = 200;
    //         return response()->json($response, $response['status']);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 400);
    //     }
    // }
    public function saveForeignApply($request)
    {
        try {
            $user_id = Auth::Guard('student')->id();

            // Check if the user has already applied
            $existingApplication = ForeignCertificateRequest::where('user_id', $user_id)
                ->where('level_id', $request['level'])
                ->where('program_id', $request['program'])
                ->first();

            if ($existingApplication) {
                return response()->json([
                    'message' => 'You have already applied for certificate request.',
                    'error'   => null,
                    'status'  => 406,
                ], 406);
            }

            $foreignApply = new ForeignCertificateRequest();
            if (preg_match('#^data:image.*?base64,#', $request['voucher_image'])) {
                $voucher_image = $this->StoreBase64Image($request['voucher_image'], '/student/');
            } else {
                $voucher_image = ($request['voucher_image']) ? $request['voucher_image'] : null;
            }
            $foreignApply->user_id       = $user_id;
            $foreignApply->level_id      = $request['level'];
            $foreignApply->program_id    = $request['program'];
            $foreignApply->voucher_image = $voucher_image;

            $foreignApply->save();

            $response['data']    = $foreignApply;
            $response['message'] = 'Foreign License Applied successfully';
            $response['error']   = null;
            $response['status']  = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function voucherImageDelete($request)
    {
        try {
            $field_name = $request->field_name;
            $ras = ExamApply::where(['user_id' =>Auth::guard('student')->id() , 'id' =>$request->id ])->first();
            if ($ras) {
                Storage::disk('public')->delete('/student/' . $ras->$field_name);
                $ras->$field_name = '';
                $ras->save();
            }
            $response['message'] = 'Image deleted successfully.';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

}
