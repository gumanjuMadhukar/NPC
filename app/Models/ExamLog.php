<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamLog extends Model
{
    use HasFactory;

    public function exam_applies () {
        return $this->belongsTo(ExamApply::class ,'exam_apply_id', 'id');
    }
    public function user () {
        return $this->belongsTo(User::class ,'user_id', 'id');
    }
    public function user_info () {
        return $this->belongsTo(UserInfo::class ,'user_id', 'id');
    }
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }
}
