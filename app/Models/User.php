<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'phone',
        'password',
        'password_reference',
        'status',
        'is_foreign',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'password_reference',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function info()
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'id');
    }

    public function user_qualifications()
    {
        return $this->hasMany(UserQualification::class, 'user_id', 'id');
    }

    public function user_qualification()
    {
        return $this->hasOne(UserQualification::class, 'user_id', 'id')->orderBy('id', 'desc');
    }

    public function slc()
    {
        return $this->hasOne(UserQualification::class, 'user_id', 'id')->where('level_id', 5);
    }

    public function tslc()
    {
        return $this->hasOne(UserQualification::class, 'user_id', 'id')->where('level_id', 4);
    }

    public function pcl()
    {
        return $this->hasOne(UserQualification::class, 'user_id', 'id')->where('level_id', 3);
    }

    public function bachelor()
    {
        return $this->hasOne(UserQualification::class, 'user_id', 'id')->where('level_id', 2);
    }

    public function bachelors()
    {
        return $this->hasMany(UserQualification::class, 'user_id', 'id')->where('level_id', 2);
    }

    public function master()
    {
        return $this->hasOne(UserQualification::class, 'user_id', 'id')->where('level_id', 1);
    }

    public function kyc()
    {
        return $this->hasOne(Kyc::class, 'user_id', 'id');
    }

    public function exam_applies()
    {
        return $this->hasMany(ExamApply::class, 'user_id', 'id')->orderBy('id', 'desc');
    }

    public function latest_exam_apply()
    {
        return $this->hasOne(ExamApply::class, 'user_id', 'id')->orderBy('id', 'desc');
    }

    public function qualifications() {
        return $this->hasMany(UserQualification::class,'user_id','id');
    }

    public function subject_committee_users(){
        return $this->hasMany(SubjectCommitteeUser::class, 'user_id', 'id');
    }

}
