<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Kyc extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'dob', 'symbol_number', 'profile_img'];

    protected $appends = ['full_profile_img'];

    public function getFullProfileImgAttribute()
    {
        return Storage::disk('public')->url('student/' . $this->profile_img);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
