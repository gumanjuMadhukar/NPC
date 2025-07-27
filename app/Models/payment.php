<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'exam_id',
        'level_id',
        'program_id',
        'cert_registration_number',
        'transaction_id',
        'txnId',
        'tidx',
        'pidx',
        'amount',
        'total_amount',
        'status',
        'purchase_order_name',
        'purchase_order_id',
        'mobile',
        'voucher_image',
        'is_active',
    ];

    public function user () {
        return $this->belongsTo(User::class ,'user_id', 'id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
    public function program()
    {
        return $this->belongsTo(Level::class, 'program_id', 'id');
    }
}
