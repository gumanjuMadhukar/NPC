<?php

namespace App\Jobs\Admin;

use App\Models\User;
use App\Models\UserInfo;
use App\Models\Program;
use App\Models\UserQualification;
use App\Models\Certificate;
use App\Models\Level;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class MigrateCertificateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $certificate = Certificate::where('cert_registration_number', $this->data['registration_number'])->where('certificate_status','active')->orderBy('id','desc')->first();

            if($certificate){
                $new_certificate = $certificate->replicate();
                $new_certificate->type = 'copy';

                $certificate->certificate_status = 'inactive';
                $new_certificate->save();
                $certificate->save();
            }else{
                $user = new User;
                $user_info = new UserInfo;
                $user_qualification = new UserQualification;
                $certificate = new Certificate;
                
                $cleanedName = str_replace(' ', '', $this->data['name']);
                $user->email = $this->generateUniqueEmail($cleanedName);
                $user->password = Hash::make('Nepal@123');
                $user->password_reference = 'Nepal@123';
                $user->role_id = 1;
                $user->name = $this->data['name'];

                $user->save();
                $user_id = $user->id;

                $user_info->profile_picture = $this->data['profile_photo'];
                $user_info->dob_nep = $this->data['date_of_birth'];
                $level = Level::where('short_name_english',$this->data['level'])->first();
                $user_info->level_id = $level->id;
                $user_info->user_id = $user_id;
                $user_info->save();

                $user_qualification->level_id = $level->id;
                $user_qualification->board_university = $this->data['insitutate'];
                $user_qualification->passed_year = $this->data['passed_year'];
                $user_qualification->user_id = $user_id;
                $user_qualification->save();

                $program = Program::where('code', $this->data['program_code'])->first();
                // if(!$program){
                //     dd($certificate_record);
                // }

                $certificate->decision_date = $this->data['decision_date'];
                $certificate->name = $this->data['name'];
                $certificate->address = $this->data['province'] . ":" . $this->data['district'] . ":" . $this->data['municipality'] . ":" . $this->data['ward'];
                $certificate->date_of_birth = $this->data['date_of_birth'];
                $certificate->program_id = @$program->id;
                $certificate->program_certificate_code = $certificate->program_code;
                $certificate->registration_id = '-';
                $certificate->level_id = $level->id;
                $certificate->user_id = $user_id;
                $certificate->cert_registration_number = $this->data['registration_number'];
                $certificate->qualification = @$program->id . ':' . $this->data['insitutate'] . ":" . $this->data['passed_year'];
                $certificate->registrar = $this->data['registrar'];
                $certificate->type = 'copy';
                $certificate->certificate = 'copy';
                $certificate->issued_date = $this->data['date_of_issue'];
                $certificate->is_foreign = $this->data['is_foreign'];
                $certificate->certificate_status = 'active';

                $certificate->save();
            }
        } catch (\Exception $e) {
            // $certificate_issue_id = new CertificateJobIssueId;
            // $certificate_issue_id->id = $this->data['id'];
            // $certificate_issue_id->save();
        }
        
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