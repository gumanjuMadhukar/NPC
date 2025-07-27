<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ExamApply extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'user_id',
        'voucher_image',
        'remarks',
        'subject_committee_count',
        'level_id',
        'program_id',
        'attempt',
        'is_admit_card_generate',
        'is_certificate_generate',
        'is_passed',
        'rejected',
        'state',
        'status'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'id');
    }
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function user_info()
    {
        return $this->belongsTo(UserInfo::class, 'user_id', 'user_id');
    }

    public function qualification()
    {
        return $this->belongsTo(UserQualification::class, 'user_id', 'user_id');
    }
    public function slc()
    {
        return $this->belongsTo(UserQualification::class, 'user_id', 'user_id')->where('level_id', 5);
    }

    public function tslc()
    {
        return $this->belongsTo(UserQualification::class, 'user_id', 'user_id')->where('level_id', 4);
    }
    public function pcl()
    {
        return $this->belongsTo(UserQualification::class, 'user_id', 'user_id')->where('level_id', 3);
    }
    public function bachelor()
    {
        return $this->belongsTo(UserQualification::class, 'user_id', 'user_id')->where('level_id', 2);
    }
    public function master()
    {
        return $this->belongsTo(UserQualification::class, 'user_id', 'user_id')->where('level_id', 1);
    }
    public function subject_committee()
    {
        return $this->belongsTo(SubjectCommittee::class, '', 'user_id');
    }

    public function getFullVoucherImageAttribute()
    {
        return Storage::disk('public')->url('student/' . $this->voucher_image);
    }
    public function exam_logs()
    {
        return $this->hasMany(ExamLog::class, 'exam_apply_id', 'id' );
    }
    public function admit_card()
    {
        return $this->hasOne(AdmitCard::class, 'exam_apply_id', 'id' );
    }
    public function certificate()
    {
        return $this->hasMany(Certificate::class, 'user_id', 'user_id' );
    }
    public function certificate_apply()
    {
        return $this->hasOne(CertificateRequest::class, 'user_id', 'user_id' );
    }
    public function payment()
    {
        return $this->hasOne(Payment::class, 'user_id', 'user_id')
                ->where('exam_id', $this->exam_id)->where('purchase_order_name', 'ExamApply Payment');
    }

}
