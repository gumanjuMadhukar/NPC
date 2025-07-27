<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\Profile\BachelorRequest;
use App\Http\Requests\Student\Profile\ForeignGuardianRequest;
use App\Http\Requests\Student\Profile\ForeignPersonalRequest;
use App\Http\Requests\Student\Profile\GuardianRequest;
use App\Http\Requests\Student\Profile\MasterRequest;
use App\Http\Requests\Student\Profile\PclRequest;
use App\Http\Requests\Student\Profile\PersonalRequest;
use App\Http\Requests\Student\Profile\SlcRequest;
use App\Http\Requests\Student\Profile\TslcRequest;
use App\Http\Requests\Student\Profile\VoucherRequest;
use App\Models\College;
use App\Models\District;
use App\Models\ExamApply;
use App\Models\Level;
use App\Models\Municipality;
use App\Models\Program;
use App\Models\Province;
use App\Models\University;
use App\Models\UserInfo;
use App\Models\UserQualification;
use App\Services\Student\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function __construct(protected ProfileService $service)
    {
    }
    public function personal()
    {
        $data['nav']            = 'profile';
        $data['sub_nav']        = 'personal';
        $data['page_title']     = 'Personal Information';
        $data['user']           = Auth::guard('student')->user();
        $data['levels']         = Level::where('status', 1)->where('id', '<>', 5)->get();
        $data['programs']       = Program::where('status', 1)->get();
        $data['provinces']      = Province::where('status', 1)->get();
        $data['districts']      = District::where('status', 1)->get();
        $data['municipalities'] = Municipality::where('status', 1)->get();

        if ($data['user']->is_foreign == 1) {
            return view('student.profile.personala', $data);
        } else {
            return view('student.profile.personal', $data);
        }
    }

    public function savePersonal(PersonalRequest $request)
    {
        // dd($request);
        return $this->service->savePersonal($request->validated());
    }
    public function saveForeignPersonal(ForeignPersonalRequest $request)
    {
        // dd($request);
        return $this->service->saveForeignPersonal($request->validated());
    }

    public function imageDelete(Request $request)
    {
        return $this->service->imageDelete($request);
    }

    public function guardian()
    {
        $data['nav']        = 'profile';
        $data['sub_nav']    = 'guardian';
        $data['page_title'] = 'Guardian Information';
        $data['user']       = UserInfo::where('user_id', Auth::guard('student')->id())->first();
        if (! $data['user']) {
            return redirect()->route('student-profile-personal');
        }
        if ($data['user']->user->is_foreign == 1 ) {
            return view('student.profile.foreign_guardian', $data);
        }

        return view('student.profile.guardian', $data);
    }
    public function saveGuardian(GuardianRequest $request)
    {
        return $this->service->saveGuardian($request->validated());
    }
    public function saveForeignGuardian(ForeignGuardianRequest $request)
    {
        return $this->service->saveForeignGuardian($request->validated());
    }
    public function slc()
    {
        $data['nav']                = 'profile';
        $data['sub_nav']            = 'college';
        $data['user']               = Auth::guard('student')->user();
        $data['colleges']           = College::all();
        $data['page_title']         = 'SLC Information';
        $data['level_id']           = 5;
        $data['user_qualification'] = UserQualification::where(['user_id' => Auth::guard('student')->id(), 'level_id' => $data['level_id']])->first();
        $data['return_url']         = ($data['user']->info->level_id == 4) ? route('student-profile-tslc') : route('student-profile-pcl');
        return view('student.profile.slc', $data);
    }
    public function collegeImageDelete(Request $request)
    {
        return $this->service->collegeImageDelete($request);
    }
    public function saveTslc(TslcRequest $request)
    {
        return $this->service->saveTslc($request->validated());
    }
    public function saveSlc(SlcRequest $request)
    {
        return $this->service->saveSlc($request->validated());
    }

    public function tslc()
    {
        $data['nav']                = 'profile';
        $data['sub_nav']            = 'college';
        $data['user']               = Auth::guard('student')->user();
        $data['colleges']           = College::all();
        $data['page_title']         = 'TSLC Information';
        $data['level_id']           = 4;
        $data['user_qualification'] = UserQualification::where(['user_id' => Auth::guard('student')->id(), 'level_id' => $data['level_id']])->first();
        $data['exam_apply']         = ExamApply::where('user_id', Auth::Guard('student')->id())->whereHas('exam', function ($qry) {
            $qry->where('status', 1);
        })->orderBy('id', 'DESC')->first();
        if (! $data['exam_apply']) {
            $data['exam_apply'] = ExamApply::where('user_id', Auth::Guard('student')->id())->whereNull('exam_id')->first();
        }
        if (isset($data['exam_apply']) && $data['exam_apply']->status == 'rejected') {
            $data['return_url'] = route('student-profile-voucher');
        } else {
            $data['return_url'] = route('student-exam-dashboard');
        }
        return view('student.profile.tslc', $data);
    }

    public function pcl()
    {
        $data['nav']                = 'profile';
        $data['sub_nav']            = 'college';
        $data['user']               = Auth::guard('student')->user();
        $data['colleges']           = College::all();
        $data['page_title']         = 'PCL/+2 Information';
        $data['level_id']           = 3;
        $data['user_qualification'] = UserQualification::where(['user_id' => Auth::guard('student')->id(), 'level_id' => $data['level_id']])->first();
        $data['exam_apply']         = ExamApply::where('user_id', Auth::Guard('student')->id())->whereHas('exam', function ($qry) {
            $qry->where('status', 1);
        })->orderBy('id', 'DESC')->first();
        if (isset($data['exam_apply']) && $data['exam_apply']->status == 'rejected') {
            $data['return_url'] = ($data['user']->info->level_id == 2 || $data['user']->info->level_id == 1) ? route('student-profile-bachelor') : route('student-profile-voucher');
        } else {
            $data['return_url'] = ($data['user']->info->level_id == 2 || $data['user']->info->level_id == 1) ? route('student-profile-bachelor') : route('student-exam-dashboard');
        }
        return view('student.profile.pcl', $data);
    }
    public function savePcl(PclRequest $request)
    {
        return $this->service->savePcl($request->validated());
    }

    public function bachelor()
    {
        $data['nav']                = 'profile';
        $data['sub_nav']            = 'college';
        $data['user']               = Auth::guard('student')->user();
        $data['colleges']           = College::all();
        $data['universities']       = University::all();
        $data['page_title']         = 'Bachelor Information';
        $data['level_id']           = 2;
        $data['user_qualification'] = UserQualification::where(['user_id' => Auth::guard('student')->id(), 'level_id' => $data['level_id']])->first();
        $data['exam_apply']         = ExamApply::where('user_id', Auth::Guard('student')->id())->whereHas('exam', function ($qry) {
            $qry->where('status', 1);
        })->orderBy('id', 'DESC')->first();
        if (isset($data['exam_apply']) && $data['exam_apply']->status == 'rejected') {
            $data['return_url'] = ($data['user']->info->level_id == 1) ? route('student-profile-master') : route('student-profile-voucher');
        } else {
            $data['return_url'] = ($data['user']->info->level_id == 1) ? route('student-profile-master') : route('student-exam-dashboard');
        }
        return view('student.profile.bachelor', $data);
    }
    public function saveBachelor(BachelorRequest $request)
    {
        return $this->service->saveBachelor($request->validated());
    }

    public function master()
    {
        $data['nav']                = 'profile';
        $data['sub_nav']            = 'college';
        $data['user']               = Auth::guard('student')->user();
        $data['colleges']           = College::all();
        $data['page_title']         = 'Master Information';
        $data['universities']       = University::all();
        $data['level_id']           = 1;
        $data['user_qualification'] = UserQualification::where(['user_id' => Auth::guard('student')->id(), 'level_id' => $data['level_id']])->first();
        $data['exam_apply']         = ExamApply::where('user_id', Auth::Guard('student')->id())->whereHas('exam', function ($qry) {
            $qry->where('status', 1);
        })->orderBy('id', 'DESC')->first();
        if (isset($data['exam_apply']) && $data['exam_apply']->status == 'rejected') {
            $data['return_url'] = route('student-profile-voucher');
        } else {
            $data['return_url'] = route('student-exam-dashboard');
        }
        return view('student.profile.master', $data);
    }
    public function saveMaster(MasterRequest $request)
    {
        return $this->service->saveMaster($request->validated());
    }

    public function voucher()
    {
        $data['nav']          = 'profile';
        $data['sub_nav']      = 'voucher';
        $data['user']         = Auth::guard('student')->user();
        $data['colleges']     = College::all();
        $data['page_title']   = 'Voucher';
        $data['universities'] = University::all();
        $data['exam_apply']   = ExamApply::where('user_id', Auth::Guard('student')->id())->whereHas('exam', function ($qry) {
            $qry->where('status', 1);
        })->orderBy('id', 'DESC')->first();
        return view('student.profile.voucher', $data);
    }
    public function saveVoucher(VoucherRequest $request)
    {
        return $this->service->saveVoucher($request->validated());
    }
    public function voucherImageDelete(Request $request)
    {
        return $this->service->voucherImageDelete($request);
    }

}
