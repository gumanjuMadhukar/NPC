<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectCommitteeUser extends Model
{
    use HasFactory;

    public function subject_committee(){
        return $this->belongsTo(SubjectCommittee::class, 'subject_committee_id', 'id');
    }
}
