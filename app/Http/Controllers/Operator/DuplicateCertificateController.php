<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Operator\Certificate\CertificateRequest;
use App\Http\Requests\Operator\Certificate\ForeignCertificateRequest;
use App\Models\Certificate;
use App\Models\District;
use App\Models\Level;
use App\Models\Municipality;
use App\Models\Program;
use App\Models\Province;
use App\Models\SubjectCommittee;
use App\Models\UserQualification;
use App\Services\Operator\CertificateService;
use Illuminate\Http\Request;

class DuplicateCertificateController extends Controller
{
    public function __construct(protected CertificateService $service)
    {
    }
    public function searchList(Request $request)
    {
    }
    
    public function view(Request $request, $id)
    {
        $data['nav'] = 'certificate';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Profile';
        $data['certificate'] = Certificate::where('id', $id)->first();
        $data['qualification'] = UserQualification::where('user_id', $data['certificate']['user_id'])->where('level_id', $data['certificate']['level_id'])->first();

        $duplicate = $data['certificate']->replicate();
        $duplicate->type = 'copy';
        $duplicate->certificate_status = 'active';;
        $duplicate->printed_date = date('Y-m-d');
        $duplicate->save();

        $data['certificate']->certificate_status = 'inactive';
        $data['certificate']->save();

        if ($data['certificate']) {
            $this->service->status($id);
            if ($data['certificate']->is_foreign == 1) {
                return view('operator.duplicate_certificate.foreign.certificate', $data);
            } else {
                return view('operator.duplicate_certificate.certificate', $data);
            }
        } else {
            abort(404);
        }
    }

    public function create($id)
    {
        $original = Certificate::where('id', $id)->first();

        $duplicate = $original->replicate();
        $duplicate->type = 'original';
        $duplicate->save();

    }
}