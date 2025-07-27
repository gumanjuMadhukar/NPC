<?php

namespace App\Services\Operator;

use App\Models\Certificate;
use App\Models\CertificateRequest;
use App\Models\ForeignCertificateRequest;
use App\Models\Program;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserQualification;
use App\Traits\StoreImageTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CertificateService
{
    use StoreImageTrait;
    public function list($per_page, $page, $q, $is_printed, $level_id = null, $program_id = null, $decision_date = null)
    {

        try {
            // $query = Certificate::select('*')->where('is_printed' , $is_printed);
            $query = Certificate::with(['user.info']) // Eager load user and their info
                ->whereHas('user.info', function ($qry) {
                    $qry->whereNotNull('first_name')
                        ->whereNotNull('last_name');
                }) // Ensure the user has associated info
                ->where('is_printed', $is_printed);
            if ($q) {
                $query->where(function ($qry) use ($q) {
                    $qry->whereHas('user', function ($userQuery) use ($q) {
                        $userQuery->whereAny(['name', 'email', 'phone'], 'LIKE', '%' . $q . '%');
                    })->orWhere('cert_registration_number', 'LIKE', '%' . $q . '%');
                });
            }
            if ($level_id) {
                $query->where('level_id', $level_id);
            }
            if ($program_id) {
                $query->where('program_id', $program_id);
            }
            // if ($is_printed) {
            //     $query->where('is_printed', $is_printed);
            // }
            if ($decision_date) {
                $query->where('decision_date', $decision_date);
            }

            $data['certificates'] = $query->orderBy('id', 'desc')->paginate($per_page);

            $data['certificates']->appends(array('q' => $q, 'level_id' => $level_id, 'program_id' => $program_id));
            if ($page != 1) {
                $data['total_data'] = $data['certificates']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['certificates']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['certificates']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['certificates']->count();
            }
            // dd($data);
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function foreignList($per_page, $page, $q, $is_printed, $level_id = null, $program_id = null, $decision_date = null)
    {

        try {
            $query = Certificate::where(['is_foreign'=> 1])->where('certificate_status','active');;
            // $query = Certificate::with(['user.info']) // Eager load user and their info
            //     ->whereHas('user.info', function ($qry) {
            //         $qry->whereNotNull('first_name')
            //             ->whereNotNull('last_name');
            //     }) // Ensure the user has associated info
            //     ->where(['is_printed'=> $is_printed, 'is_foreign'=> 1]);
            if ($q) {
                $query->whereHas('user', function ($qry) use ($q) {
                    $qry->whereAny(['name', 'email', 'phone'], 'LIKE', '%' . $q . '%');
                });
            }
            if (!is_null($is_printed)) {
                $query->where('is_printed', $is_printed);
            }
            if ($level_id) {
                $query->where('level_id', $level_id);
            }
            if ($program_id) {
                $query->where('program_id', $program_id);
            }
            if ($decision_date) {
                $query->where('decision_date', $decision_date);
            }

            $data['certificates'] = $query->orderBy('name', 'asc')->paginate($per_page);

            $data['certificates']->appends(array('q' => $q, 'is_printed' => $is_printed, 'level_id' => $level_id, 'program_id' => $program_id));
            if ($page != 1) {
                $data['total_data'] = $data['certificates']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['certificates']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['certificates']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['certificates']->count();
            }
            // dd($data);
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function foreignReqList($per_page, $page, $q, $level_id = null, $program_id = null, $is_printed = null, $decision_date = null)
    {
        try {
            $query = ForeignCertificateRequest::select('*');
            if ($q) {
                $query->whereHas('user', function ($qry) use ($q) {
                    $qry->whereAny(['name', 'email', 'phone'], 'LIKE', '%' . $q . '%');
                });
            }

            if ($level_id) {
                $query->where('level_id', $level_id);
            }

            if ($program_id) {
                $query->where('program_id', $program_id);
            }
            if ($is_printed) {
                $query->where('is_printed', $is_printed);
            }
            if ($decision_date) {
                $query->where('decision_date', $decision_date);
            }
            $data['foreign_requests'] = $query->orderBy('id', 'desc')->paginate($per_page);

            $data['foreign_requests']->appends(array('q' => $q, 'level_id' => $level_id, 'program_id' => $program_id));
            if ($page != 1) {
                $data['total_data'] = $data['foreign_requests']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['foreign_requests']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['foreign_requests']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['foreign_requests']->count();
            }
            // dd($data);
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function certificateIssuanceReqList($per_page, $page, $q, $level_id = null, $program_id = null, $is_printed = null, $decision_date = null)
    {
        // dd($q);

        try {
            $query = CertificateRequest::select('*');
            if ($q) {
                $query->whereHas('user', function ($qry) use ($q) {
                    $qry->whereAny(['name', 'email', 'phone'], 'LIKE', '%' . $q . '%');
                });
            }

            if ($level_id) {
                $query->where('level_id', $level_id);
            }

            if ($program_id) {
                $query->where('program_id', $program_id);
            }
            if ($is_printed) {
                $query->where('is_printed', $is_printed);
            }
            if ($decision_date) {
                $query->where('decision_date', $decision_date);
            }
            $data['certificate_issuance_requests'] = $query->orderBy('id', 'desc')->paginate($per_page);

            $data['certificate_issuance_requests']->appends(array('q' => $q, 'level_id' => $level_id, 'program_id' => $program_id));
            if ($page != 1) {
                $data['total_data'] = $data['certificate_issuance_requests']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['certificate_issuance_requests']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['certificate_issuance_requests']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['certificate_issuance_requests']->count();
            }
            // dd($data);
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function duplicateList($per_page, $page, $q, $level_id, $program_id, $is_printed, $decision_date)
    {
        try {
            $query = Certificate::select('*')->where('type', 'copy')->where('certificate', 'copy')->where('is_foreign', '<>', 1)->where('certificate_status','active');
            if ($q) {
                // $query->whereHas('user', function ($qry) use ($q) {
                //     $qry->whereAny(['name', 'email', 'phone'], 'LIKE', '%' . $q . '%');
                // });
                $query->whereAny(['name', 'cert_registration_number'], $q);
            }

            if ($level_id) {
                $query->where('level_id', $level_id);
            }

            if ($program_id) {
                $query->where('program_id', $program_id);
            }
            if ($is_printed) {
                $query->where('is_printed', $is_printed);
            }
            if ($decision_date) {
                $query->where('decision_date', $decision_date);
            }
            $data['certificates'] = $query->orderBy('id', 'desc')->paginate($per_page);

            $data['certificates']->appends(array('q' => $q, 'level_id' => $level_id, 'program_id' => $program_id));
            if ($page != 1) {
                $data['total_data'] = $data['certificates']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['certificates']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['certificates']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['certificates']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function searchList($per_page, $page, $q, $level_id, $program_id, $is_printed, $decision_date)
    {

        try {
            $query = Certificate::select('*');
            if ($q) {
                $query->whereHas('user', function ($qry) use ($q) {
                    $qry->whereAny(['name', 'email', 'phone'], 'LIKE', '%' . $q . '%');
                });
            }

            if ($level_id) {
                $query->where('level_id', $level_id);
            }
            if ($program_id) {
                $query->where('program_id', $program_id);
            }
            if ($decision_date) {
                $query->where('decision_date', $decision_date);
            }
            $query->where('is_printed', $is_printed);

            $data['certificates'] = $query->orderBy('id', 'desc')->paginate($per_page);

            $data['certificates']->appends(array('q' => $q, 'level_id' => $level_id, 'program_id' => $program_id, 'decision_date' => $decision_date));
            if ($page != 1) {
                $data['total_data'] = $data['certificates']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['certificates']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['certificates']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['certificates']->count();
            }
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function status($id)
    {
        $certificate = Certificate::where('id', $id)->first();
        $certificate->is_printed = 1;
        $certificate->printed_date = Date('Y-m-d');
        $certificate->printed_by = Auth::guard('operator')->id();
        $certificate->save();
    }

    public function store($request)
    {
        try {
            $certificate = Certificate::where('id', $request['id'])->first();
            list($day, $month, $year) = explode('-', $request['issued_date']);
            $certificate->cert_registration_number = $request['cert_registration_number'];
            $certificate->issued_date = $year . '-' . $month . '-' . $day;
            $certificate->registrar = $request['registrar'];
            $certificate->program_id = $request['program_id'];
            $certificate->level_id = $request['level_id'];
            $certificate->save();

            $this->info($request);
            $this->qualification($request);

            $response['message'] = 'Certificate updated successfully.';
            $response['error'] = null;
            $response['status'] = 201;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    // public function foreignStore($request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         // Fetch the user using the user_id
    //         $user = User::findOrFail($request['id']);

    //         // Update user's name if provided
    //         if (!empty($request['name'])) {
    //             $user->name = $request['name'];
    //             $user->update();
    //         }

    //         // Update UserInfo (if exists)
    //         $user_info = $user->userInfo;
    //         if ($user_info) {
    //             // Profile Picture Handling
    //             if (preg_match('#^data:image.*?base64,#', $request['profile_picture'])) {
    //                 $profile_picture = $this->StoreBase64Image($request['profile_picture'], '/student/');
    //             } else {
    //                 $profile_picture = $request['profile_picture'] ?? null;
    //             }

    //             if ($profile_picture) {
    //                 $user_info->profile_picture = $profile_picture;
    //             }

    //             // Update other user_info fields
    //             $user_info->dob_eng = $request['dob'];
    //             $user_info->level_id = $request['level_id'];
    //             $user_info->save();
    //         }

    //         // Update UserQualification (if exists)
    //         $user_qualification = $user->userQualification;
    //         if ($user_qualification) {
    //             $user_qualification->board_university = $request['board_university'];
    //             $user_qualification->passed_year = $request['passed_year'];
    //             $user_qualification->save();
    //         }

    //         // Handle Certificate Creation or Update
    //         $certificate = $request['id'] ? Certificate::find($request['id']) : new Certificate;

    //         // If certificate doesn't exist, create a new one
    //         if (!$certificate) {
    //             $certificate = new Certificate(); // Create a new instance if not found
    //             $lastRegistration = Certificate::latest('registration_id')->first();
    //             $certificate->registration_id = ($lastRegistration->registration_id ?? 0) + 1;
    //         }

    //         // Update certificate fields
    //         $certificate->decision_date = Carbon::createFromFormat('d-m-Y', $request['decision_date'])->format('Y-m-d');
    //         $certificate->name = $request['name'];
    //         $certificate->address = implode(':', [$request['province'], $request['district'], $request['municipality'], $request['ward_no']]);
    //         $certificate->date_of_birth = $request['dob'];
    //         $certificate->program_certificate_code = $request['program_id'];
    //         $certificate->level_id = $request['level_id'];
    //         $certificate->user_id = $user->id;
    //         $certificate->cert_registration_number = $request['cert_registration_number'];
    //         $certificate->duration = $request['duration'];
    //         $certificate->qualification = implode(':', [$request['program_id'], $request['board_university'], $request['passed_year']]);
    //         $certificate->registrar = $request['registrar'];
    //         $certificate->is_foreign = 1;
    //         $certificate->issued_date = $request['issued_date'];
    //         $certificate->save();

    //         // Update ForeignCertificateRequest status if exists
    //         $certificate_status = ForeignCertificateRequest::where('user_id', $request['id'])->first();

    //         if ($certificate_status) {
    //             $certificate_status->status = 1;
    //             $certificate_status->save();
    //         } else {
    //             return response()->json(['error' => 'Foreign certificate request not found.'], 404);
    //         }

    //         DB::commit();

    //         // Send appropriate response message
    //         $responseMessage = $request['id'] ? 'Certificate updated successfully.' : 'Certificate created successfully.';
    //         return response()->json([
    //             'message' => $responseMessage,
    //             'status' => 201,
    //         ], 201);
    //     } catch (\Throwable $e) {
    //         DB::rollback();
    //         return response()->json(['error' => 'An error occurred while processing your request.'], 400);
    //     }
    // }


    public function foreignStore($request)
    {
        DB::beginTransaction();
        try {
            $user_id = $request['user_id'] ?? null;
            $user = null;

            if ($user_id) {
                $user = User::find($user_id);
            }

            if (!$user) {
                $user = new User();
                $cleanedName = str_replace(' ', '', $request['name']);
                $user->email = $this->generateUniqueEmail($cleanedName);
                $user->password = Hash::make('Nepal@123');
                $user->password_reference = 'Nepal@123';
                $user->role_id = 1;
            }

            // --- START of Name Parsing Logic for UserInfo ---
            $fullName = trim($request['name']); // Get the full name from the request and trim whitespace
            $nameParts = explode(' ', $fullName); // Split the full name into parts by spaces

            $firstName = '';
            $middleName = '';
            $lastName = '';

            // Logic to determine first, middle, and last name based on the number of parts
            if (count($nameParts) >= 2) {
                $firstName = array_shift($nameParts);   // The first part is the first name
                $lastName = array_pop($nameParts);    // The last part is the last name
                $middleName = implode(' ', $nameParts); // Any remaining parts form the middle name (can be empty if only 2 words)
            } else if (count($nameParts) == 1) {
                $firstName = $nameParts[0]; // If only one part, it's considered the first name
                // middleName and lastName remain empty as initialized
            }
            // --- END of Name Parsing Logic ---

            // Assign the full name to the User model's 'name' field
            $user->name = $fullName;
            $user->save();

            // Handle UserInfo: create if not exists, otherwise update
            $userInfo = $user->userInfo;
            if (!$userInfo) {
                $userInfo = new UserInfo(['user_id' => $user->id]);
            }

            // Profile Picture Handling (existing code)
            if (!empty($request['profile_picture'])) {
                if (preg_match('#^data:image.*?base64,#', $request['profile_picture'])) {
                    $profile_picture = $this->StoreBase64Image($request['profile_picture'], '/student/');
                } else {
                    $profile_picture = $request['profile_picture'];
                }
                $userInfo->profile_picture = $profile_picture;
            }

            // --- START of Storing Parsed Names in UserInfo ---
            $userInfo->first_name = $firstName;
            $userInfo->middle_name = $middleName;
            $userInfo->last_name = $lastName;
            // --- END of Storing Parsed Names ---

            $userInfo->dob_eng = $request['dob'];
            $userInfo->level_id = $request['level_id'];
            $userInfo->program_id = $request['program_id'];
            $userInfo->save();


            // Update UserQualification (if exists)
            $user_qualification = $user->userQualification;
            if ($user_qualification) {
                $user_qualification->board_university = $request['board_university'];
                $user_qualification->passed_year = $request['passed_year'];
                $user_qualification->save();
            }

            // Handle Certificate Creation or Update
            $certificate = $request['id'] ? Certificate::find($request['id']) : new Certificate;

            // If certificate doesn't exist, create a new one
            if (!$certificate) {
                $certificate = new Certificate(); // Create a new instance if not found
                $lastRegistration = Certificate::latest('registration_id')->first();
                $certificate->registration_id = ($lastRegistration->registration_id ?? 0) + 1;
            }

            // Update certificate fields
            $certificate->decision_date = Carbon::createFromFormat('d-m-Y', $request['decision_date'])->format('Y-m-d');
            $certificate->name = $request['name'];
            $certificate->address = implode(':', [$request['province'], $request['district'], $request['municipality'], $request['ward_no']]);
            $certificate->date_of_birth = $request['dob'];
            $certificate->program_certificate_code = $request['program_id'];
            $certificate->level_id = $request['level_id'];
            $certificate->user_id = $user->id;
            $certificate->cert_registration_number = $request['cert_registration_number'];
            $certificate->duration = $request['duration'];
            $certificate->qualification = implode(':', [$request['program_id'], $request['board_university'], $request['passed_year']]);
            $certificate->registrar = $request['registrar'];
            $certificate->is_foreign = 1;
            $certificate->issued_date = $request['issued_date'];
            $certificate->save();

            // Update ForeignCertificateRequest status if exists
            $certificate_status = ForeignCertificateRequest::where('user_id', $request['id'])->first();

            if ($certificate_status) {
                $certificate_status->status = 1;
                $certificate_status->save();
            }
            DB::commit();

            $responseMessage = $user_id ? 'Foreign certificate and user data updated successfully.' : 'Foreign certificate and user data created successfully.';
            return response()->json([
                'message' => $responseMessage,
                'status' => 201,
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'An error occurred while processing your request: ' . $e->getMessage()], 400);
        }
    }

    public function duplicateStore($request)
    {
        DB::beginTransaction();
        try {
            if ($request['id']) {
                $id = $request['id'];
                $certificate = Certificate::findOrFail($id);
                $user = $certificate->user;

                if ($user->userInfo) {
                    $user_info = $user->userInfo;
                } else {
                    $user_info = new UserInfo;
                    $user_info->user_id = $user->id;
                }

                $user_qualification = $user->userQualification ?? new UserQualification;

                $response['message'] = 'Certificate updated successfully.';
                $response['error'] = null;
                $response['status'] = 202;
            } else {
                $user = new User;
                $user_info = new UserInfo;
                $user_qualification = new UserQualification;
                $certificate = new Certificate;

                $cleanedName = str_replace(' ', '', $request['name']);
                $user->email = $this->generateUniqueEmail($cleanedName);
                $user->password = Hash::make('Nepal@123');
                $user->password_reference = 'Nepal@123';
                $user->role_id = 1;

                $response['message'] = 'Certificate created successfully.';
                $response['error'] = null;
                $response['status'] = 201;
            }

            // Common fields for both create and edit modes
            $user->name = $request['name'];
            $user->save();

            $user_id = $user->id;

            // Handle profile picture
            if (preg_match('#^data:image.*?base64,#', $request['profile_picture'])) {
                $profile_picture = $this->StoreBase64Image($request['profile_picture'], '/student/');
            } else {
                $profile_picture = $request['profile_picture'] ?? null;
            }

            // Assign values to UserInfo, and associate it with the user
            $user_info->profile_picture = $profile_picture;
            $user_info->dob_nep = $request['dob'];
            $user_info->level_id = $request['level_id'];
            $user_info->user_id = $user_id;
            $user_info->save();

            // Assign values to UserQualification, and associate it with the user
            $user_qualification->level_id = $request['level_id'];
            $user_qualification->board_university = $request['board_university'];
            $user_qualification->passed_year = $request['passed_year'];
            $user_qualification->user_id = $user_id;
            $user_qualification->save();

            // Certificate handling (common for both edit and create)
            list($day, $month, $year) = explode('-', $request['decision_date']);

            if (!$request['id']) {
                // Only for creation: auto-generate registration_id
                $lastRegistration = Certificate::orderBy('registration_id', 'desc')->first();
                $certificate->registration_id = ($lastRegistration ? $lastRegistration->registration_id : 0) + 1;
            }

            $certificate->decision_date = $year . '-' . $month . '-' . $day;
            $certificate->name = $request['name'];
            $certificate->address = $request['province'] . ":" . $request['district'] . ":" . $request['municipality'] . ":" . $request['ward_no'];
            $certificate->date_of_birth = $request['dob'];
            $certificate->program_certificate_code = $request['program_code'];
            $certificate->level_id = $request['level_id'];
            $certificate->user_id = $user_id;
            $certificate->cert_registration_number = $request['cert_registration_number'];
            $certificate->duration = $request['duration'];
            // $certificate->qualification = $request[''] . ':' . $request['board_university'] . ":" . $request['passed_year'];
            $certificate->registrar = $request['registrar'];
            $certificate->qualification = ($request['program_code'] ?? '') . ':' . ($request['board_university'] ?? '') . ":" . ($request['passed_year'] ?? '');

             $certificate->type = 'copy';
            $certificate->issued_date = $request['issued_date'];
            // dd($certificate);
            $certificate->save();

            DB::commit();

            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function programStore($request)
    {
        try {
            $program = Program::where('id', $request['id'])->first();

            $program->program_id = $request['program_id'];
            $program->program_code = $request['code'];
            $program->save();

            $response['message'] = 'Certificate updated successfully.';
            $response['error'] = null;
            $response['status'] = 201;
            return response()->json($response, $response['status']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function info($request)
    {
        if (preg_match('#^data:image.*?base64,#', $request['profile_picture'])) {
            $profile_picture = $this->StoreBase64Image($request['profile_picture'], '/student/');
        } else {
            $profile_picture = ($request['profile_picture']) ? $request['profile_picture'] : null;
        }
        $user_info = UserInfo::where('id', $request['user_info_id'])->first();
        $user_info->profile_picture = $profile_picture;
        $user_info->first_name = $request['first_name'];
        $user_info->middle_name = $request['middle_name'];
        $user_info->last_name = $request['last_name'];
        $user_info->dob_nep = $request['dob_nep'];
        $user_info->ward_no = $request['ward_no'];
        $user_info->municipality_id = $request['municipality_id'];
        $user_info->district_id = $request['district_id'];
        $user_info->province_id = $request['province_id'];
        $user_info->save();
    }

    public function qualification($request)
    {
        foreach ($request['qualification'] as $qualification) {
            if (!array_key_exists('id', $qualification) && !$qualification['program_id']) {
                continue;
            }
            if (array_key_exists('id', $qualification)) {
                $user_qualification = UserQualification::where('id', $qualification['id'])->first();
            } elseif ($qualification['program_id']) {
                $user_qualification = new UserQualification;
            }
            $user_qualification->board_university = $qualification['board_university'];
            $user_qualification->passed_year = $qualification['passed_year'];
            $user_qualification->save();
        }
    }

    protected function generateUniqueEmail($name)
    {
        do {
            // Generate a random email (e.g., using the name and a random number)
            $randomNumber = rand(1000, 9999);
            $email = strtolower($name) . $randomNumber . '@gmail.com';

            // Validate that the email is unique in the 'users' table
            $emailExists = User::where('email', $email)->exists();
        } while ($emailExists); // Repeat until a unique email is found

        return $email;
    }

    public function delete($id)
    {
        try {
            $certificate = Certificate::where('id', $id)->first();
            $certificate->delete();
            $response['message'] = 'Certificate Deleted successfully';
            $response['error'] = null;
            $response['status'] = 200;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // public function status($request)
    // {
    //     try {
    //         if ($request['status'] === "accepted") {
    //             $status = 'progress';
    //             $state = 'officer';
    //             $remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Exam Applied has been accepted';
    //             $exam_log_remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Profile Verified and forwarded to Officer';
    //             $suject = 'Application Form Approval Notification';
    //         } elseif ($request['status'] === "rejected") {
    //             $status = 'rejected';
    //             $state = 'operator';
    //             $remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Rejected By Computer Operator';
    //             $exam_log_remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Rejected By Computer Operator';
    //             $suject = 'Application Form Status Update';
    //         } else {
    //             $status = 'pending';
    //             $state = 'operator';
    //             $remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Pending By Computer Operator';
    //             $exam_log_remarks = (!empty($request['remarks'])) ? $request['remarks'] : 'Pending By Computer Operator';
    //         }
    //         $exam_apply = ExamApply::where('id', $request['id'])->first();
    //         $exam_apply->rejected = $request['status'] === "rejected" ? 1 : 0;
    //         $exam_apply->status = $status;
    //         $exam_apply->state = $state;
    //         $exam_apply->remarks = $remarks;
    //         $exam_apply->save();
    //         //ExamApply::where('id', $request['id'])->update(['status' => $status, 'remarks' => $remarks]);
    //         $exam_log = new ExamLog;
    //         $exam_log->user_id = $exam_apply->user_id;
    //         $exam_log->exam_apply_id = $exam_apply->id;
    //         $exam_log->system_user_id = Auth::guard('operator')->id();
    //         $exam_log->status = $status;
    //         $exam_log->remarks = $exam_log_remarks;
    //         $exam_log->save();

    //         if ($request['status'] === "accepted" || $request['status'] === "rejected") {
    //             $email_data = [
    //                 'name' => $exam_apply->user->name,
    //                 'email' => $exam_apply->user->email,
    //                 'status' => $request['status'],
    //                 'subject' => $suject,
    //                 'remarks' => $remarks,
    //             ];
    //             $jobToDispatch = (new ExamApplyStatusJob($email_data))->delay(Carbon::now()->addSeconds(1));
    //             dispatch($jobToDispatch);
    //         }

    //         $response['message'] = 'Status updated successfully.';
    //         $response['error'] = null;
    //         $response['status'] = 201;
    //         return response()->json($response, $response['status']);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 400);
    //     }
    // }
}
