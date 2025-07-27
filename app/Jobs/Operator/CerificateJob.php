<?php

namespace App\Jobs\Operator;

use App\Models\Certificate;
use App\Models\CertificateHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CerificateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 0;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $certificate_histories = CertificateHistory::get();
        foreach ($certificate_histories as $certificate_history) {
            $certificate = Certificate::where('id', $certificate_history->id)->first();
            if ($certificate) {
                $certificate->issued_date = $certificate_history->issued_date;
                $certificate->valid_till = $certificate_history->valid_till;
                $certificate->printed_date = $certificate_history->printed_date;
                $certificate->decision_date = $certificate_history->decision_date;
                $certificate->save();
            } else {
                $certificate = new Certificate;
                $certificate->id = $certificate_history->id;
                $certificate->registration_id = $certificate_history->registration_id;
                $certificate->category_id = $certificate_history->category_id;
                $certificate->user_id = null;
                $certificate->program_id = $certificate_history->program_id;
                $certificate->level_id = $certificate_history->level_id;
                $certificate->program_certificate_code = $certificate_history->program_certificate_code;
                $certificate->srn = $certificate_history->srn;
                $certificate->cert_registration_number = $certificate_history->cert_registration_number;
                $certificate->registrar = $certificate_history->registrar;
                $certificate->date_of_birth = $certificate_history->date_of_birth;
                $certificate->address = $certificate_history->address;
                $certificate->qualification = $certificate_history->qualification;
                $certificate->decision_date = $certificate_history->decision_date;
                $certificate->issued_year = $certificate_history->issued_year;
                $certificate->issued_date = $certificate_history->issued_date;
                $certificate->valid_till = $certificate_history->valid_till;
                $certificate->certificate = $certificate_history->certificate;
                $certificate->type = $certificate_history->type;
                $certificate->remarks = $certificate_history->remarks;
                $certificate->is_printed = $certificate_history->is_printed;
                $certificate->printed_date = $certificate_history->printed_date;
                $certificate->printed_by = $certificate_history->printed_by;
                $certificate->is_edited = $certificate_history->is_edited;
                $certificate->issued_by = $certificate_history->issued_by;
                $certificate->certificate_status = $certificate_history->certificate_status;
                $certificate->save();
            }
        }
    }
}
