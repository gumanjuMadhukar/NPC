<?php

namespace App\Services\Admin;

use App\Models\Certificate;
use App\Models\Program;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserQualification;
use App\Models\Level;
use App\Jobs\Admin\MigrateCertificateJob;
use App\Traits\StoreImageTrait;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class CertificateService
{
    public function get_old_data() {
        $data = DB::table('duplicate_certificate')
            ->select('*')
            ->get();
        return $data;
    }

    public function add($certificate_record){
        // DB::beginTransaction();
        
        $data = array(
            'registration_number' => $certificate_record->registration_number,
            'name' => $certificate_record->name,
            'profile_photo' => $certificate_record->profile_photo,
            'date_of_birth' => $certificate_record->date_of_birth,
            'level' => $certificate_record->level,
            'insitutate' => $certificate_record->insitutate,
            'passed_year' => $certificate_record->passed_year,
            'program_code' => $certificate_record->program_code,
            'decision_date' => $certificate_record->decision_date,
            'province' => $certificate_record->province,
            'district' => $certificate_record->district,
            'municipality' => $certificate_record->municipality,
            'ward' => $certificate_record->ward,
            'registrar' => $certificate_record->registrar,
            'date_of_issue' => $certificate_record->date_of_issue,
            'is_foreign' => $certificate_record->is_foreign
        );
        $jobToDispatch = (new MigrateCertificateJob($data))->delay(Carbon::now()->addSeconds(2));
        dispatch($jobToDispatch);
        return 'success';
    }

    protected function generateUniqueEmail($name)
    {
        do {
            // Generate a random email (e.g., using the name and a random number)
            $randomNumber = rand(1000, 9999);
            $email = strtolower($name) . $randomNumber . '@nhpc.gov.np';

            // Validate that the email is unique in the 'users' table
            $emailExists = User::where('email', $email)->exists();
        } while ($emailExists); // Repeat until a unique email is found

        return $email;
    }
}