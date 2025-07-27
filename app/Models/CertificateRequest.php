<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CertificateRequest extends Model
{
    use HasFactory;

    protected $fillable = [
		'user_id',
		'symbol_number',
		'cert_registration_number',
        'voucher_image',
		'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function admit_card()
    {
        return $this->belongsTo(AdmitCard::class, 'user_id', 'user_id');
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
    public function certificate()
    {
        return $this->hasOne(Certificate::class, 'user_id', 'user_id')->where('level_id',$this->level_id);
        // return $this->hasOne(Certificate::class, 'user_id', 'user_id')->where('level_id',$this->level_id);
    }
	public function getFullVoucherImageAttribute()
    {
        return Storage::disk('public')->url('student/voucher/'.$this->voucher_image);
    }


}
