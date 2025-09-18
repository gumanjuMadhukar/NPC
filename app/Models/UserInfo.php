<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [ 'user_id',
	'program_id',
	'level_id',
	'first_name',
	'middle_name',
	'last_name',
	'first_name_nep',
	'middle_name_nep',
	'last_name_nep',
	'phone_number',
	'emergency_number',
	'dob_eng',
	'dob_nep',
	'sex',
	'marital_status',
	'ethinic',
	'cast',
	'citizenship_number',
	'citizenship_issue_date',
	'citizenship_issue_district',
	'father_name',
	'father_name_nep',
	'father_number',
	'father_email',
	'mother_name',
	'mother_name_nep',
	'mother_number',
	'mother_email',
	'grandfather_name',
	'grandfather_name_nep',
	'grandfather_number',
	'grandfather_email',
	'spouse_name',
	'spouse_name_nep',
	'spouse_number',
	'spouse_email',
	'province_id',
	'district',
	'municiplality',
	'ward_no',
	'profile_picture',
	'citizenship_front',
	'citizenship_back',
	'signature_image',
	'profile_state',
    ];

	protected $appends = ['full_name' , 'full_profile_picture' , 'full_citizenship_front' , 'full_citizenship_back' , 'full_signature_image'];

    public function getFullNameAttribute()
    {
        return $this->first_name. ' ' .  $this->middle_name. ' ' . $this->last_name;
    }

    public function getFullProfilePictureAttribute()
    {
        return Storage::disk('public')->url('student/'.$this->profile_picture);
    }

    public function getFullCitizenshipFrontAttribute()
    {
        return Storage::disk('public')->url('student/'.$this->citizenship_front);
    }

    public function getFullCitizenshipBackAttribute()
    {
        return Storage::disk('public')->url('student/'.$this->citizenship_back);
    }

    public function getFullSignatureImageAttribute()
    {
        return Storage::disk('public')->url('student/'.$this->signature_image);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }


    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id', 'id');
    }

	public function exam_applies()
    {
        return $this->hasMany(ExamApply::class, 'user_id', 'id');
    }

}
