<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserQualification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id',
        'level_id',
        'name',
        'board_university',
        'passed_year',
        'admission_year',
        'college_name',
        'registration_number',
        'transcript_image',
        'provisional_image',
        'character_image',
        'ojt_image',
        'visa_image',
        'noc_image',
        'intership_image',
        'passport_image',
        'licence',
        'council_registration_certificate',
        'ojt_pcl_community_1_image',
        'ojt_pcl_community_2_image',
        'transcript_mas_marksheet',
        'transcript_bac_1',
        'transcript_bac_2',
        'transcript_bac_3',
        'transcript_bac_3',
        'transcript_bac_5',
        'transcript_bac_6',
        'transcript_bac_7',
        'transcript_bac_8',
        'migration_image',
        'equivalence_certificate',
    ];

    protected $appends = ['full_transcript_image', 'full_provisional_image', 'full_character_image', 'full_ojt_image', 'full_equivalence_certificate', 'full_council_registration_certificate','full_ojt_pcl_community_1_image', 'full_ojt_pcl_community_2_image', 'full_transcript_bac_1',
    'full_transcript_bac_2',
    'full_transcript_bac_3',
    'full_transcript_bac_3',
    'full_transcript_bac_5',
    'full_transcript_bac_6',
    'full_transcript_bac_7',
    'full_transcript_bac_8',
    'full_migration_image',
    'full_visa_image',
    'full_noc_image',
    'full_intership_image',
    'full_passport_image',
    'transcript_mas_marksheet',];

    public function getFullTranscriptImageAttribute()
    {
        return Storage::disk('public')->url('student/' . $this->transcript_image);
    }

    public function getFullProvisionalImageAttribute()
    {
        return Storage::disk('public')->url('student/' . $this->provisional_image);
    }

    public function getFullCharacterImageAttribute()
    {
        return Storage::disk('public')->url('student/' . $this->character_image);
    }
    public function getFullOjtImageAttribute()
    {
        return Storage::disk('public')->url('student/' . $this->ojt_image);
    }
    
    public function getFullEquivalenceCertificateAttribute()
    {
        return Storage::disk('public')->url('student/' . $this->equivalence_certificate);
    }
    public function getFullCouncilRegistrationCertificateAttribute()
    {
        return Storage::disk('public')->url('student/' . $this->council_registration_certificate);
    }
    public function getFullOjtPclCommunity1ImageAttribute()
    {
        return Storage::disk('public')->url('student/' . $this->ojt_pcl_community_1_image);
    }
    public function getFullOjtPclCommunity2ImageAttribute()
    {
        return Storage::disk('public')->url('student/' . $this->ojt_pcl_community_2_image);
    }

    public function getFullTranscriptBac1Attribute()
    {
        return Storage::disk('public')->url('student/' . $this->transcript_bac_1);
    }
    
    public function getFullTranscriptBac2Attribute()
    {
        return Storage::disk('public')->url('student/' . $this->transcript_bac_2);
    }
    
    public function getFullTranscriptBac3Attribute()
    {
        return Storage::disk('public')->url('student/' . $this->transcript_bac_3);
    }
    
    public function getFullTranscriptBac4Attribute()
    {
        return Storage::disk('public')->url('student/' . $this->transcript_bac_4);
    }
    
    public function getFullTranscriptBac5Attribute()
    {
        return Storage::disk('public')->url('student/' . $this->transcript_bac_5);
    }
    
    public function getFullTranscriptBac6Attribute()
    {
        return Storage::disk('public')->url('student/' . $this->transcript_bac_6);
    }
    
    public function getFullTranscriptBac7Attribute()
    {
        return Storage::disk('public')->url('student/' . $this->transcript_bac_7);
    }
    
    public function getFullTranscriptBac8Attribute()
    {
        return Storage::disk('public')->url('student/' . $this->transcript_bac_8);
    }
    public function getFullMigrationImageAttribute()
    {
        return Storage::disk('public')->url('student/' . $this->migration_image);
    }
    
    public function getFullIntershipImageAttribute()
    {
        return Storage::disk('public')->url('student/' . $this->intership_image);
    }
    public function getFullNocImageAttribute()
    {
        return Storage::disk('public')->url('student/' . $this->noc_image);
    }
    
    public function getFullVisaImageAttribute()
    {
        return Storage::disk('public')->url('student/' . $this->visa_image);
    }
    
    public function getFullPassportImageAttribute()
    {
        return Storage::disk('public')->url('student/' . $this->passport_image);
    }
    
    public function getFullTranscriptMasMarksheetAttribute()
    {
        return Storage::disk('public')->url('student/' . $this->transcript_mas_marksheet);
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'name', 'id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }


    



    

}
