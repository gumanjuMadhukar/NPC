<?php

namespace App\Services\Council;

use App\Models\User;
use App\Models\Certificate;
use App\Models\ExamApply;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CertificateService
{
    public function generateCertificate($request){
        // try {
            $students = ExamApply::select('*')->where('state', 'council')->where('status', 'progress')->orderBy('program_id','asc')->get();
            $registration_number = Certificate::orderBy('registration_id', 'desc')->first();
            $registration_id = ($registration_number)?$registration_number['registration_id']+1:1;
            foreach ($students as $student) {
                $certificate_info = new Certificate;
                // $srn_number = Certificate::where('program_id', '=', $student['program_id'])->orderBy('srn', 'desc')->first();
                $srn_number = Certificate::where('program_certificate_code', '=', $student->program['certificate_name'])
                    ->where('level_id', $student->level_id)
                    ->orderBy('srn', 'desc')
                    ->first();
                $certificate_info->srn = ($srn_number)?$srn_number['srn'] + 1:1;
                $certificate_info->registration_id = $registration_id++;
                $certificate_info->user_id = $student['user_id'];
                $certificate_info->program_id = $student['program_id'];
                $certificate_info->program_certificate_code = $student->program['certificate_name'];
                $certificate_info->cert_registration_number = $this->certRegistrationNumber($certificate_info->srn, $student->program['certificate_name'], $student->level['code']);
                $certificate_info->registrar = 'Lila Nath Bhandari';
                $certificate_info->decision_date = $request['date'];
                $certificate_info->name = $student->user_info['first_name'] . ' ' . $student->user_info['middle_name'] . ' ' . $student->user_info['last_name'];
                $certificate_info->date_of_birth = $student->user_info['dob_nep'] ?? '0000-00-00';
                $certificate_info->address = ($student->user_info->province['name'] ?? '') . ':' . ($student->user_info->district['name'] ?? '' ) . ':' . ($student->user_info->municipality['name'] ?? '') . ':' . $student->user_info['ward_no'];
                // $certificate_info->program_name = $student['qualification'];
                $certificate_info->level_id = $student->level['id'];
                $certificate_info->qualification = $student->program['name'] . ':' . $student['board_university'] . ':'  . $student['passed_year'];
                $certificate_info->issued_year = Carbon::today()->year;
                $certificate_info->issued_date = $request['date'];
                $certificate_info->valid_till = Carbon::now()->addYears(5);
                $certificate_info->certificate = 'new';
                $certificate_info->issued_by = Auth::guard('council')->id();
                $certificate_info->certificate_status = 1;
                $certificate_info->save();
                
                $student->status = 'accepted';
                $student->is_certificate_generate = 1;
                $student->save();
                // dd($certificate_info);
            }
            redirect('/council/applicant/tslc');
            // dd($request['date']);
        // } catch (\Exception $e) {
            // return response()->json(['error' => $e->getMessage()], 400);
        // }
    }

    private function certRegistrationNumber($srn, $program_code, $level)
    {
        $crtn = $level ? $level . '-' . $srn . ' ' . $program_code : $srn . ' ' . $program_code;
        return $crtn;
    }

    public function dartaList($per_page, $page, $q, $date, $program_id=NULL)
    {
        try {
            $query = Certificate::select(
                'certificates.*', 
                'levels.name as level_name', 
                'programs.name as program_name',
                DB::raw('COUNT(certificates.id) as total_count'),
                DB::raw('GROUP_CONCAT(CONCAT(certificates.srn, " ") ORDER BY certificates.srn ASC) as srn_list'),
                )->join('levels', 'certificates.level_id', '=', 'levels.id')
                ->join('programs', 'certificates.program_id', '=', 'programs.id')
                ->groupBy('certificates.level_id', 'certificates.program_id', 'certificates.decision_date');;
            if ($q) {
                $query->whereHas('program', function ($qry) use ($q) {
                    $qry->whereAny(['certificate_name', 'name'], 'LIKE', '%' . $q . '%');
                });
            }
            if ($date) {
                $query->where('decision_date', $date);
            }
            $data['applicants'] = $query->orderBy('decision_date', 'desc')->orderBy('level_id','DESC')->orderBy('program_id')->orderBy('certificates.srn', 'asc')->paginate($per_page);
            $data['applicants']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['applicants']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['applicants']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['applicants']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['applicants']->count();
            }
            return $data;


        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function dartaDetail($per_page, $page, $q, $date, $program_id=NULL)
    {
        // try {
            $query = Certificate::select('*')->orderby('id','desc');
            if ($q) {
                $query->whereHas('user', function ($qry) use ($q) {
                    $qry->whereAny(['name', 'email', 'phone'], 'LIKE', '%' . $q . '%');
                });
            }
            if ($date) {
                $query->where('decision_date', $date);
            }
            if ($program_id){
                $query->where('program_id', $program_id);
            }
            $data['applicants'] = $query->orderBy('id', 'desc')->paginate($per_page);
            $data['applicants']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['applicants']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['applicants']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['applicants']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['applicants']->count();
            }
            return $data;
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 400);
        // }
    }
}