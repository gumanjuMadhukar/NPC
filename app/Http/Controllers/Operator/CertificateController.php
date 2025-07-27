<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\Certificate\CertificateRequest;
use App\Http\Requests\Operator\Certificate\DuplicateCertificateRequest;
use App\Http\Requests\Operator\Certificate\ForeignCertificateRequest;
use App\Models\Certificate;
use App\Models\District;
use App\Models\Level;
use App\Models\Municipality;
use App\Models\Program;
use App\Models\Province;
use App\Models\SubjectCommittee;
use App\Models\UserInfo;
use App\Models\UserQualification;
use App\Services\Operator\CertificateService;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function __construct(protected CertificateService $service)
    {
    }
    public function searchList(Request $request)
    {
        // $jobToDispatch = (new CerificateJob())->delay(Carbon::now()->addSeconds(1));
        // dispatch($jobToDispatch);

        $data['nav'] = 'search_certificate';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Certificates';
        $per_page = 10;
        $data['is_printed'] = $request->is_printed ?? "";
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['decision_date'] = $request->program_id ?? '';
        $data['decision_dates'] = Certificate::select('decision_date')->distinct()->orderby('decision_date', 'asc')->get();
        // dd($data['dicision_dates']);
        $data['levels'] = Level::select('*')->where('status', 1)->where('id', '<', '5')->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('name', 'desc')->get();
        $data['result'] = $this->service->searchList($per_page, $page, $data['q'], $data['level_id'], $data['program_id'], $data['is_printed'], $data['decision_date']);

        return view('operator.certificate.search_list', $data);
    }
    public function list(Request $request, $print_status)
    {
        // $jobToDispatch = (new CerificateJob())->delay(Carbon::now()->addSeconds(1));
        // dispatch($jobToDispatch);

        $data['nav'] = 'certificate';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Certificates';
        $per_page = 10;
        $data['is_printed'] = $print_status == 'printed' ? 1 : 0;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['levels'] = Level::select('*')->where('status', 1)->where('id', '<', '5')->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('name', 'desc')->get();
        $data['result'] = $this->service->list($per_page, $page, $data['q'], $data['level_id'], $data['program_id'], $data['is_printed']);

        $programCounts = [];
        $level = ['1', '2', '3', '4'];

        foreach ($level as $level) {
            $programs = Program::where('level_id', $level)->get();

            foreach ($programs as $program) {
                $count = Certificate::with(['user.info']) // Eager load user and their info
                    ->whereHas('user.info', function ($qry) {
                        $qry->whereNotNull('first_name')
                            ->whereNotNull('last_name');
                    })->where('program_id', $program->id)->where('is_printed', $data['is_printed'])
                    ->count();

                $programCounts[$level][] = [
                    'program_id' => $program->id,
                    'program_name' => $program->name,
                    'count' => $count,
                ];
            }
        }
        $data['program_wise_counts'] = $programCounts;

        return view('operator.certificate.list_cat', $data);
    }

    public function foreignCertificateRequestList()
    {
        $data['nav'] = 'foreign_certificate';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Foreign Certificate Requests';
        $per_page = 10;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['is_printed'] = "";
        $data['level_id'] = "";
        $data['program_id'] = "";
        $data['result'] = $this->service->foreignReqList($per_page, $page, $data['q'], $data['level_id'], $data['program_id'], $data['is_printed']);
        return view('operator.certificate.foreign.request_list', $data);
    }
    public function certificateIssuanceRequestList(Request $request)
    {
        $data['nav'] = 'certificate_issuance';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Certificate Issuance Requests';
        $per_page = 10;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['is_printed'] = "";
        $data['level_id'] = "";
        $data['program_id'] = "";

        // dd($data['q']);
        $data['result'] = $this->service->certificateIssuanceReqList($per_page, $page, $data['q'], $data['level_id'], $data['program_id'], $data['is_printed']);
        return view('operator.certificate.request_list', $data);
    }

    public function foreignCertificateList(Request $request)
    {
        $data['nav'] = 'foreign_certificate';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Foreign Certificates';
        $per_page = 10;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['is_printed'] = $request->is_printed;
        $data['level_id'] = "";
        $data['program_id'] = "";
        $data['decision_date'] = "";
        $data['result'] = $this->service->foreignList($per_page, $page, $data['q'], $data['is_printed'], $data['level_id'], $data['program_id'], $data['decision_date']);
        return view('operator.certificate.foreign.list', $data);
    }

    public function duplicateCertificateList(Request $request)
    {
        $data['nav'] = 'duplicate_certificate';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Duplicate Certificates';
        $per_page = 15;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['is_printed'] = "";
        $data['level_id'] = "";
        $data['program_id'] = "";
        $data['decision_date'] = "";
        $data['result'] = $this->service->duplicateList($per_page, $page, $data['q'], $data['level_id'], $data['program_id'], $data['is_printed'], $data['decision_date']);
        return view('operator.certificate.duplicate.list', $data);
    }

    public function programWiseList(Request $request, $id, $isPrinted)
    {
        $data['nav'] = 'certificate';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Certificates';
        $per_page = 10;
        $data['is_printed'] = $isPrinted;
        // dd($isPrinted);
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $id;
        $data['result'] = $this->service->list($per_page, $page, $data['q'], $data['is_printed'], $data['level_id'], $data['program_id']);

        return view('operator.certificate.list', $data);

    }

    public function printedList(Request $request)
    {
        $data['nav'] = 'certificate';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Printed Certificates';
        $per_page = 10;
        $page = $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['level_id'] = $request->level_id ?? "";
        $data['program_id'] = $request->program_id ?? '';
        $data['is_foreign'] = "";
        $data['levels'] = Level::select('*')->where('status', 1)->orderBy('order', 'desc')->get();
        $data['programs'] = Program::select('*')->orderBy('name', 'desc')->get();
        $data['result'] = $this->service->list($per_page, $page, $data['q'], $data['is_foreign'], $data['level_id'], $data['program_id'], 1);

        return view('operator.certificate.printed_list', $data);
    }

    public function profile($id)
    {
        $data['nav'] = 'certificate';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Profile';
        $data['certificate'] = Certificate::where('id', $id)->first();
        $data['qualification'] = UserQualification::where('user_id', $data['certificate']['user_id'])->where('level_id', $data['certificate']['level_id'])->first();

        if ($data['certificate']) {
            $this->service->status($id);
            if ($data['certificate']->is_foreign == 1) {
                return view('operator.certificate.foreign.certificate', $data);
            } else {
                return view('operator.certificate.certificate', $data);
            }
        } else {
            abort(404);
        }
    }
    public function idProfile($id)
    {
        $data['nav'] = 'certificate';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Profile';
        $data['certificate'] = Certificate::where('id', $id)->first();
        // $data['qualification'] = UserQualification::where('user_id', $data['certificate']['user_id'])->where('level_id', $data['certificate']['level_id'])->first();
        if ($data['certificate']) {
            $this->service->status($id);
            return view('operator.certificate.id_card', $data);
        } else {
            abort(404);
        }
    }

    public function foreignAddEdit(Request $request)
    {
        $data['nav'] = 'certificate';
        $data['sub_nav'] = '';
        $user_id = $request->id ?? 0;
        $data['user_id'] = $user_id ?? 0;
        $data['page_title'] = "Edit Certificate";
        $data['action'] = route('operator-exam-store');
        $data['dates'] = Certificate::select('decision_date')
            ->distinct()->orderBy('id', 'desc')
            ->get();
        $data['certificate'] = Certificate::where('user_id', $user_id)->first();
        $data['user_info'] = UserInfo::where('user_id', $user_id)->first();
        $data['row'] = $data['certificate'];
        // dd($data['user_info'], $user_id);
        $data['programs'] = Program::all();
        $data['levels'] = Level::all();

        // $program_id = $data['certificate']->program_id;
        // $data['row'] = Program::where('id', $program_id)->first();

        return view('operator.certificate.foreign.add', $data);
    }

    public function duplicateAddEdit(Request $request)
    {
        $data['nav'] = 'certificate';
        $data['sub_nav'] = '';
        $id = $request->id ?? 0;
        $data['page_title'] = "Edit Certificate";
        $data['action'] = route('operator-exam-store');
        $data['certificate'] = Certificate::where('id', $id)->first();
        $data['user_id'] = $id;
        $data['row'] = $data['certificate'];
        $data['provinces'] = Province::all();
        $data['districts'] = District::all();
        $data['municipalities'] = Municipality::all();
        $data['programs'] = Program::all();
        $data['levels'] = Level::all();

        return view('operator.certificate.duplicate.add', $data);
    }

    public function edit(Request $request)
    {
        $data['nav'] = 'certificate';
        $data['sub_nav'] = '';
        $id = $request->id ?? 0;
        $data['page_title'] = "Edit Certificate";
        $data['action'] = route('operator-exam-store');
        $data['certificate'] = Certificate::where('id', $id)->first();
        $data['qualifications'] = UserQualification::where('user_id', $data['certificate']['user_id'])
            ->where('level_id', $data['certificate']['level_id'])
            ->get();
        $data['provinces'] = Province::all();
        $data['districts'] = District::all();
        $data['municipalities'] = Municipality::all();
        $data['programs'] = Program::all();
        $data['levels'] = Level::all();

        $program_id = $data['certificate']->program_id;
        $data['program'] = Program::where('id', $program_id)->first();
        $data['levels'] = Level::where('status', 1)->get();
        $data['subject_committees'] = SubjectCommittee::where('status', 1)->get();

        if ($data['certificate']->is_foreign == 1) {
            return redirect('operator/certificate/foreign/addedit?id=' . $data['certificate']['user_id']);
        }else {
            return view('operator.certificate.edit', $data);
        }
    }

    public function delete(Request $request)
    {
        return $this->service->delete($request->id);
    }

    public function store(CertificateRequest $request)
    {
        return $this->service->store($request->validated());
    }
    public function foreignstore(ForeignCertificateRequest $request)
    {
        return $this->service->foreignStore($request->validated());
    }
    public function duplicatestore(DuplicateCertificateRequest $request)
    {
        return $this->service->duplicateStore($request->validated());
    }
    public function programEdit(Request $request)
    {
        return $this->service->programStore($request);
    }

}
