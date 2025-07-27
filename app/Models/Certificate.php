<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $filliable = [
        'registration_id', 
		'category_id', 
		'user_id', 
		'program_id', 
		'level_id', 
		'program_certificate_code', 
		'srn', 
		'cert_registration_number', 
		'registrar', 
		'name', 
		'date_of_birth', 
		'address', 
		'qualification', 
		'decision_date', 
		'issued_year', 
		'issued_date', 
		'valid_till', 
		'certificate', 
		'type', 
		'remarks', 
		'is_printed', 
		'printed_date', 
		'printed_by', 
		'is_edited', 
		'issued_by', 
		'certificate_status', 
    ];

	
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
}
