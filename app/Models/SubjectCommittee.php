<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectCommittee extends Model
{
    use HasFactory;

    protected $fillable = ['name',  'code',  'status', ];

    public function programs()
    {
        return $this->hasMany(Program::class, 'subject_committee_id');
    }
}
