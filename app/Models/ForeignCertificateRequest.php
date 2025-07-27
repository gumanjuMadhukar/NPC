<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ForeignCertificateRequest extends Model
{
    use HasFactory;

    protected $filliable = [
		'user_id', 
		'level_id',
		'program_id',
		'voucher_image', 
		'status',
    ];

    protected $appends = ['full_profile_img'];
	
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
	public function getFullVoucherImageAttribute()
    {
        return Storage::disk('public')->url('student/'.$this->voucher_image);
    }

}
