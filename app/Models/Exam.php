<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = ['name','name_nep', 'opening_date', 'closing_date', 'description',  'status', 'result_status'];

    
}
