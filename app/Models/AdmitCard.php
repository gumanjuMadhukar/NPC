<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmitCard extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'user_id', 'exam_apply_id','symbol_number', 'is_taken'];

    public function exam_apply()
    {
        return $this->belongsTo(ExamApply::class, 'exam_apply_id', 'id');
    }

}

