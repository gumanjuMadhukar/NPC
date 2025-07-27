<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CertificateRenewRequest extends Model
{
    use HasFactory;

    protected $table = 'certificate_renew_requests';
    protected $fillable = [
        'user_id',
        'level_id',
        'program_id',
        'cert_registration_number',
        'transaction_id',
        'txnId',
        'tidx',
        'voucher_image',
        'total_amount',
        'amount',
        'status',
        'cert_status',
        'purchase_order_name',
        'purchase_order_id',
        'mobile',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    // Accessor for full voucher image URL
    public function getFullVoucherImageAttribute()
    {
        return $this->voucher_image
            ? Storage::disk('public')->url('voucher_images/' . $this->voucher_image)
            : null;
    }
}
