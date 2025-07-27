<?php
namespace App\Services\Student;

use App\Models\ExamApply;
use App\Models\UserInfo;
use App\Models\UserQualification;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    use StoreImageTrait;
    public function savePersonal($request)
    {
        try {
            $user_info = UserInfo::where('user_id', Auth::guard('student')->id())->first();
            if (!$user_info) {
                $user_info = new UserInfo;
            }
            if (preg_match('#^data:image.*?base64,#', $request['profile_picture'])) {
                $profile_picture = $this->StoreBase64Image($request['profile_picture'], '/student/');
            } else {
                $profile_picture = ($request['profile_picture']) ? $request['profile_picture'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['citizenship_front'])) {
                $citizenship_front = $this->StoreBase64Image($request['citizenship_front'], '/student/');
            } else {
                $citizenship_front = $request['citizenship_front'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['citizenship_back'])) {
                $citizenship_back = $this->StoreBase64Image($request['citizenship_back'], '/student/');
            } else {
                $citizenship_back = $request['citizenship_back'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['signature_image'])) {
                $signature_image = $this->StoreBase64Image($request['signature_image'], '/student/');
            } else {
                $signature_image = $request['signature_image'] ?? null;
            }
            $user_info->profile_picture = $profile_picture;
            $user_info->citizenship_front = $citizenship_front;
            $user_info->citizenship_back = $citizenship_back;
            $user_info->signature_image = $signature_image;
            $user_info->first_name = $request['first_name'];
            $user_info->middle_name = $request['middle_name'];
            $user_info->last_name = $request['last_name'];
            $user_info->first_name_nep = $request['first_name_nep'];
            $user_info->middle_name_nep = $request['middle_name_nep'];
            $user_info->last_name_nep = $request['last_name_nep'];
            $user_info->dob_eng = $request['dob_eng'];
            $user_info->dob_nep = $request['dob_nep'];
            $user_info->sex = $request['sex'];
            $user_info->marital_status = $request['marital_status'];
            $user_info->ethinic = $request['ethinic'];
            $user_info->citizenship_number = $request['citizenship_number'];
            $user_info->citizenship_issue_date = $request['citizenship_issue_date'];
            $user_info->citizenship_issue_district = $request['citizenship_issue_district'];
            $user_info->province_id = $request['province'];
            $user_info->district_id = $request['district'];
            $user_info->municipality_id = $request['municipality'];
            $user_info->ward_no = $request['ward_no'];
            $user_info->level_id = $request['level'];
            $user_info->user_id = Auth::guard('student')->id();
            $user_info->save();
            $response['data'] = $user_info;
            $response['message'] = 'Profile updated successfully';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function saveForeignPersonal($request)
    {
        try {
            $user_id = Auth::guard('student')->id();
            $user_info = UserInfo::firstOrNew(['user_id' => $user_id]);

            // Handle image fields
            $image_fields = [
                'profile_picture',
                'passport_image_1',
                'passport_image_2',
                'passport_image_3',
                'visa_image_1',
                'visa_image_2',
                'visa_image_3',
                'signature_image',
            ];

            foreach ($image_fields as $field) {
                $value = $request[$field] ?? null;
                if (!empty($value) && preg_match('#^data:image.*?base64,#', $value)) {
                    $user_info->$field = $this->StoreBase64Image($value, '/student/');
                } elseif (!empty($value)) {
                    $user_info->$field = $value;
                } else {
                    $user_info->$field = null;
                }
            }

            // Handle other form fields
            $fields = [
                'level_id',
                'first_name', 'middle_name', 'last_name',
                'dob_eng', 'dob_nep', 'sex', 'marital_status',
                'passport_number', 'passport_issue_date', 'passport_issue_country',
                'country', 'state_province_region', 'city_town', 'street_name','postal_zip_code'
            ];

            foreach ($fields as $field) {
                $user_info->$field = $request[$field] ?? null;
            }

            $user_info->user_id = $user_id;
            // dd($user_info);
            $user_info->save();

            return response()->json([
                'data' => $user_info,
                'message' => 'Profile updated successfully',
                'error' => null,
                'status' => 200,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }


    public function imageDelete($request)
    {
        try {
            $field_name = $request->field_name;
            $ras = UserInfo::where('user_id', Auth::guard('student')->id())->first();
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

    public function saveGuardian($request)
    {
        try {
            $user_info = UserInfo::where('user_id', Auth::guard('student')->id())->first();
            if (!$user_info) {
                $user_info = new UserInfo;
            }
            $user_info->father_name = $request['father_name'];
            $user_info->father_name_nep = $request['father_name_nep'];
            $user_info->grandfather_name = $request['grandfather_name'];
            $user_info->grandfather_name_nep = $request['grandfather_name_nep'];
            $user_info->mother_name = $request['mother_name'];
            $user_info->mother_name_nep = $request['mother_name_nep'];
            $user_info->save();
            $response['data'] = $user_info;
            $response['message'] = 'Profile updated successfully';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function saveForeignGuardian($request)
    {
        try {
            $user_info = UserInfo::where('user_id', Auth::guard('student')->id())->first();
            if (!$user_info) {
                $user_info = new UserInfo;
            }
            $user_info->father_name = $request['father_name'];
            $user_info->grandfather_name = $request['grandfather_name'];
            $user_info->mother_name = $request['mother_name'];
            $user_info->save();
            $response['data'] = $user_info;
            $response['message'] = 'Profile with Guardian updated successfully';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function collegeImageDelete($request)
    {
        try {
            $field_name = $request->field_name;
            $ras = UserQualification::where(['user_id' =>Auth::guard('student')->id() , 'id' =>$request->id ])->first();
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

    public function saveTslc($request)
    {
        try {
            $user_qualification =  UserQualification::where(['user_id' => Auth::guard('student')->id(), 'level_id' => 4])->first();
            if (!$user_qualification) {
                $user_qualification = new UserQualification;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_image'])) {
                $transcript_image = $this->StoreBase64Image($request['transcript_image'], '/student/');
            } else {
                $transcript_image = ($request['transcript_image']) ? $request['transcript_image'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_1'])) {
                $transcript_bac_1 = $this->StoreBase64Image($request['transcript_bac_1'], '/student/');
            } else {
                $transcript_bac_1 = ($request['transcript_bac_1']) ? $request['transcript_bac_1'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_2'])) {
                $transcript_bac_2 = $this->StoreBase64Image($request['transcript_bac_2'], '/student/');
            } else {
                $transcript_bac_2 = ($request['transcript_bac_2']) ? $request['transcript_bac_2'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_3'])) {
                $transcript_bac_3 = $this->StoreBase64Image($request['transcript_bac_3'], '/student/');
            } else {
                $transcript_bac_3 = ($request['transcript_bac_3']) ? $request['transcript_bac_3'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['provisional_image'])) {
                $provisional_image = $this->StoreBase64Image($request['provisional_image'], '/student/');
            } else {
                $provisional_image = $request['provisional_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['character_image'])) {
                $character_image = $this->StoreBase64Image($request['character_image'], '/student/');
            } else {
                $character_image = $request['character_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['ojt_image'])) {
                $ojt_image = $this->StoreBase64Image($request['ojt_image'], '/student/');
            } else {
                $ojt_image = $request['ojt_image'] ?? null;
            }
            $user_qualification->level_id = $request['level_id'];
            $user_qualification->college_name = ((isset($request['college_type']) && $request['college_type'] == 'nepal') || ($request['id'] > 0)) ?  $request['college_name'] :  $request['international_college_name'];
            $user_qualification->passed_year = $request['passed_year'];
            $user_qualification->board_university = $request['board_university'];
            $user_qualification->registration_number = $request['registration_number'];
            $user_qualification->transcript_image = $transcript_image;
            $user_qualification->transcript_bac_1 = $transcript_bac_1;
            $user_qualification->transcript_bac_2 = $transcript_bac_2;
            $user_qualification->transcript_bac_3 = $transcript_bac_3;
            $user_qualification->provisional_image = $provisional_image;
            $user_qualification->character_image = $character_image;
            $user_qualification->ojt_image = $ojt_image;
            $user_qualification->user_id = Auth::guard('student')->id();
            $user_qualification->save();
            $response['data'] = null;
            $response['message'] = 'TSLC updated successfully';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function saveSlc($request)
    {
        try {
            $user_qualification =  UserQualification::where(['user_id' => Auth::guard('student')->id(), 'level_id' => 5])->first();
            if (!$user_qualification) {
                $user_qualification = new UserQualification;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_image'])) {
                $transcript_image = $this->StoreBase64Image($request['transcript_image'], '/student/');
            } else {
                $transcript_image = ($request['transcript_image']) ? $request['transcript_image'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_1'])) {
                $transcript_bac_1 = $this->StoreBase64Image($request['transcript_bac_1'], '/student/');
            } else {
                $transcript_bac_1 = ($request['transcript_bac_1']) ? $request['transcript_bac_1'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['provisional_image'])) {
                $provisional_image = $this->StoreBase64Image($request['provisional_image'], '/student/');
            } else {
                $provisional_image = $request['provisional_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['character_image'])) {
                $character_image = $this->StoreBase64Image($request['character_image'], '/student/');
            } else {
                $character_image = $request['character_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['equivalence_certificate'])) {
                $equivalence_certificate = $this->StoreBase64Image($request['equivalence_certificate'], '/student/');
            } else {
                $equivalence_certificate = $request['equivalence_certificate'] ?? null;
            }
            $user_qualification->level_id = $request['level_id'];
            $user_qualification->college_name = $request['school_name'];
            $user_qualification->passed_year = $request['passed_year'];
            $user_qualification->board_university = $request['board_university'];
            $user_qualification->transcript_image = $transcript_image;
            $user_qualification->transcript_bac_1 = $transcript_bac_1;
            $user_qualification->provisional_image = $provisional_image;
            $user_qualification->character_image = $character_image;
            $user_qualification->equivalence_certificate = $equivalence_certificate;
            $user_qualification->user_id = Auth::guard('student')->id();
            $user_qualification->save();
            $response['data'] = null;
            $response['message'] = 'SLC updated successfully';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function savePcl($request)
    {
        try {
            $user_qualification =  UserQualification::where(['user_id' => Auth::guard('student')->id(), 'level_id' => 3])->first();
            if (!$user_qualification) {
                $user_qualification = new UserQualification;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_image'])) {
                $transcript_image = $this->StoreBase64Image($request['transcript_image'], '/student/');
            } else {
                $transcript_image = ($request['transcript_image']) ? $request['transcript_image'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_1'])) {
                $transcript_bac_1 = $this->StoreBase64Image($request['transcript_bac_1'], '/student/');
            } else {
                $transcript_bac_1 = ($request['transcript_bac_1']) ? $request['transcript_bac_1'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['provisional_image'])) {
                $provisional_image = $this->StoreBase64Image($request['provisional_image'], '/student/');
            } else {
                $provisional_image = $request['provisional_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['character_image'])) {
                $character_image = $this->StoreBase64Image($request['character_image'], '/student/');
            } else {
                $character_image = $request['character_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['equivalence_certificate'])) {
                $equivalence_certificate = $this->StoreBase64Image($request['equivalence_certificate'], '/student/');
            } else {
                $equivalence_certificate = $request['equivalence_certificate'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['equivalence_certificate'])) {
                $equivalence_certificate = $this->StoreBase64Image($request['equivalence_certificate'], '/student/');
            } else {
                $equivalence_certificate = $request['equivalence_certificate'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['council_registration_certificate'])) {
                $council_registration_certificate = $this->StoreBase64Image($request['council_registration_certificate'], '/student/');
            } else {
                $council_registration_certificate = $request['council_registration_certificate'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['ojt_pcl_community_1_image'])) {
                $ojt_pcl_community_1_image = $this->StoreBase64Image($request['ojt_pcl_community_1_image'], '/student/');
            } else {
                $ojt_pcl_community_1_image = $request['ojt_pcl_community_1_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['ojt_pcl_community_2_image'])) {
                $ojt_pcl_community_2_image = $this->StoreBase64Image($request['ojt_pcl_community_2_image'], '/student/');
            } else {
                $ojt_pcl_community_2_image = $request['ojt_pcl_community_2_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['noc_image'])) {
                $noc_image = $this->StoreBase64Image($request['noc_image'], '/student/');
            } else {
                $noc_image = $request['noc_image'] ?? null;
            }
            $user_qualification->level_id = $request['level_id'];
            $user_qualification->college_name = ((isset($request['college_type']) && $request['college_type'] == 'nepal' && isset($request['board_university']) && $request['board_university'] == 'PCL') || ($request['id'] > 0)) ?  $request['college_name'] :  $request['international_college_name'];
            $user_qualification->admission_year = $request['admission_year'];
            $user_qualification->passed_year = $request['passed_year'];
            $user_qualification->board_university = $request['board_university'];
            $user_qualification->registration_number = $request['registration_number'];
            $user_qualification->transcript_image = $transcript_image;
            $user_qualification->transcript_bac_1 = $transcript_bac_1;
            $user_qualification->provisional_image = $provisional_image;
            $user_qualification->character_image = $character_image;
            $user_qualification->equivalence_certificate = $equivalence_certificate;
            $user_qualification->council_registration_certificate = $council_registration_certificate;
            $user_qualification->ojt_pcl_community_1_image = $ojt_pcl_community_1_image;
            $user_qualification->ojt_pcl_community_2_image = $ojt_pcl_community_2_image;
            $user_qualification->noc_image = $noc_image;
            $user_qualification->user_id = Auth::guard('student')->id();
            $user_qualification->save();
            $response['data'] = null;
            $response['message'] = 'PCL updated successfully';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function saveBachelor($request)
    {
        try {
            $user_qualification =  UserQualification::where(['user_id' => Auth::guard('student')->id(), 'level_id' => 2])->first();
            if (!$user_qualification) {
                $user_qualification = new UserQualification;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_1'])) {
                $transcript_bac_1 = $this->StoreBase64Image($request['transcript_bac_1'], '/student/');
            } else {
                $transcript_bac_1 = ($request['transcript_bac_1']) ? $request['transcript_bac_1'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_2'])) {
                $transcript_bac_2 = $this->StoreBase64Image($request['transcript_bac_2'], '/student/');
            } else {
                $transcript_bac_2 = ($request['transcript_bac_2']) ? $request['transcript_bac_2'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_3'])) {
                $transcript_bac_3 = $this->StoreBase64Image($request['transcript_bac_3'], '/student/');
            } else {
                $transcript_bac_3 = ($request['transcript_bac_3']) ? $request['transcript_bac_3'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_4'])) {
                $transcript_bac_4 = $this->StoreBase64Image($request['transcript_bac_4'], '/student/');
            } else {
                $transcript_bac_4 = ($request['transcript_bac_4']) ? $request['transcript_bac_4'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_5'])) {
                $transcript_bac_5 = $this->StoreBase64Image($request['transcript_bac_5'], '/student/');
            } else {
                $transcript_bac_5 = ($request['transcript_bac_5']) ? $request['transcript_bac_5'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_6'])) {
                $transcript_bac_6 = $this->StoreBase64Image($request['transcript_bac_6'], '/student/');
            } else {
                $transcript_bac_6 = ($request['transcript_bac_6']) ? $request['transcript_bac_6'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_7'])) {
                $transcript_bac_7 = $this->StoreBase64Image($request['transcript_bac_7'], '/student/');
            } else {
                $transcript_bac_7 = ($request['transcript_bac_7']) ? $request['transcript_bac_7'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_8'])) {
                $transcript_bac_8 = $this->StoreBase64Image($request['transcript_bac_8'], '/student/');
            } else {
                $transcript_bac_8 = ($request['transcript_bac_8']) ? $request['transcript_bac_8'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['equivalence_certificate'])) {
                $equivalence_certificate = $this->StoreBase64Image($request['equivalence_certificate'], '/student/');
            } else {
                $equivalence_certificate = $request['equivalence_certificate'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['provisional_image'])) {
                $provisional_image = $this->StoreBase64Image($request['provisional_image'], '/student/');
            } else {
                $provisional_image = $request['provisional_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['character_image'])) {
                $character_image = $this->StoreBase64Image($request['character_image'], '/student/');
            } else {
                $character_image = $request['character_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['intership_image'])) {
                $intership_image = $this->StoreBase64Image($request['intership_image'], '/student/');
            } else {
                $intership_image = $request['intership_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['noc_image'])) {
                $noc_image = $this->StoreBase64Image($request['noc_image'], '/student/');
            } else {
                $noc_image = $request['noc_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['visa_image'])) {
                $visa_image = $this->StoreBase64Image($request['visa_image'], '/student/');
            } else {
                $visa_image = $request['visa_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['passport_image'])) {
                $passport_image = $this->StoreBase64Image($request['passport_image'], '/student/');
            } else {
                $passport_image = $request['passport_image'] ?? null;
            }
            $user_qualification->level_id = $request['level_id'];
            $user_qualification->college_name = ((isset($request['college_type']) && $request['college_type'] == 'nepal') || ($request['id'] > 0)) ?  $request['college_name'] :  $request['international_college_name'];
            $user_qualification->admission_year = $request['admission_year'];
            $user_qualification->passed_year = $request['passed_year'];
            $user_qualification->board_university =  ((isset($request['board_university']) && $request['board_university'] != 'Other') || ($request['id'] > 0)) ?  $request['board_university'] :  $request['other_board_university'];
            $user_qualification->registration_number = $request['registration_number'];
            $user_qualification->transcript_bac_1 = $transcript_bac_1;
            $user_qualification->transcript_bac_2 = $transcript_bac_2;
            $user_qualification->transcript_bac_3 = $transcript_bac_3;
            $user_qualification->transcript_bac_4 = $transcript_bac_4;
            $user_qualification->transcript_bac_5 = $transcript_bac_5;
            $user_qualification->transcript_bac_6 = $transcript_bac_6;
            $user_qualification->transcript_bac_7 = $transcript_bac_7;
            $user_qualification->transcript_bac_8 = $transcript_bac_8;
            $user_qualification->equivalence_certificate = $equivalence_certificate;
            $user_qualification->provisional_image = $provisional_image;
            $user_qualification->character_image = $character_image;
            $user_qualification->intership_image = $intership_image;
            $user_qualification->noc_image = $noc_image;
            $user_qualification->visa_image = $visa_image;
            $user_qualification->passport_image = $passport_image;
            $user_qualification->user_id = Auth::guard('student')->id();
            $user_qualification->save();
            $response['data'] = null;
            $response['message'] = 'Bachelor updated successfully';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function saveMaster($request)
    {
        try {
            $user_qualification =  UserQualification::where(['user_id' => Auth::guard('student')->id(), 'level_id' => 1])->first();
            if (!$user_qualification) {
                $user_qualification = new UserQualification;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_mas_marksheet'])) {
                $transcript_mas_marksheet = $this->StoreBase64Image($request['transcript_mas_marksheet'], '/student/');
            } else {
                $transcript_mas_marksheet = ($request['transcript_mas_marksheet']) ? $request['transcript_mas_marksheet'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_1'])) {
                $transcript_bac_1 = $this->StoreBase64Image($request['transcript_bac_1'], '/student/');
            } else {
                $transcript_bac_1 = ($request['transcript_bac_1']) ? $request['transcript_bac_1'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_2'])) {
                $transcript_bac_2 = $this->StoreBase64Image($request['transcript_bac_2'], '/student/');
            } else {
                $transcript_bac_2 = ($request['transcript_bac_2']) ? $request['transcript_bac_2'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['transcript_bac_3'])) {
                $transcript_bac_3 = $this->StoreBase64Image($request['transcript_bac_3'], '/student/');
            } else {
                $transcript_bac_3 = ($request['transcript_bac_3']) ? $request['transcript_bac_3'] : null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['equivalence_certificate'])) {
                $equivalence_certificate = $this->StoreBase64Image($request['equivalence_certificate'], '/student/');
            } else {
                $equivalence_certificate = $request['equivalence_certificate'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['provisional_image'])) {
                $provisional_image = $this->StoreBase64Image($request['provisional_image'], '/student/');
            } else {
                $provisional_image = $request['provisional_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['character_image'])) {
                $character_image = $this->StoreBase64Image($request['character_image'], '/student/');
            } else {
                $character_image = $request['character_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['intership_image'])) {
                $intership_image = $this->StoreBase64Image($request['intership_image'], '/student/');
            } else {
                $intership_image = $request['intership_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['noc_image'])) {
                $noc_image = $this->StoreBase64Image($request['noc_image'], '/student/');
            } else {
                $noc_image = $request['noc_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['visa_image'])) {
                $visa_image = $this->StoreBase64Image($request['visa_image'], '/student/');
            } else {
                $visa_image = $request['visa_image'] ?? null;
            }
            if (preg_match('#^data:image.*?base64,#', $request['passport_image'])) {
                $passport_image = $this->StoreBase64Image($request['passport_image'], '/student/');
            } else {
                $passport_image = $request['passport_image'] ?? null;
            }
            $user_qualification->level_id = $request['level_id'];
            $user_qualification->college_name = ((isset($request['college_type']) && $request['college_type'] == 'nepal') || ($request['id'] > 0)) ?  $request['college_name'] :  $request['international_college_name'];
            $user_qualification->admission_year = $request['admission_year'];
            $user_qualification->passed_year = $request['passed_year'];
            $user_qualification->board_university =  ((isset($request['board_university']) && $request['board_university'] != 'Other') || ($request['id'] > 0)) ?  $request['board_university'] :  $request['other_board_university'];
            $user_qualification->registration_number = $request['registration_number'];
            $user_qualification->transcript_mas_marksheet = $transcript_mas_marksheet;
            $user_qualification->transcript_bac_1 = $transcript_bac_1;
            $user_qualification->transcript_bac_2 = $transcript_bac_2;
            $user_qualification->transcript_bac_3 = $transcript_bac_3;
            $user_qualification->equivalence_certificate = $equivalence_certificate;
            $user_qualification->provisional_image = $provisional_image;
            $user_qualification->character_image = $character_image;
            $user_qualification->intership_image = $intership_image;
            $user_qualification->noc_image = $noc_image;
            $user_qualification->visa_image = $visa_image;
            $user_qualification->passport_image = $passport_image;
            $user_qualification->user_id = Auth::guard('student')->id();
            $user_qualification->save();
            $response['data'] = null;
            $response['message'] = 'Master updated successfully';
            $response['error'] = null;
            $response['status'] = 200;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }



    public function saveVoucher($request)
    {
        try {
            $exam_apply = ExamApply::findOrFail($request['exam_apply_id']);
            if (preg_match('#^data:image.*?base64,#', $request['voucher_image'])) {
                $voucher_image = $this->StoreBase64Image($request['voucher_image'], '/student/');
            } else {
                $voucher_image = ($request['voucher_image']) ? $request['voucher_image'] : null;
            }
            $exam_apply->voucher_image = $voucher_image;
            $exam_apply->status = 'progress';
            $exam_apply->save();

            $response['data'] = $exam_apply;
            $response['message'] = '';
            $response['error'] = null;
            $response['status'] = 200;
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
