<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_names',
        'academic_level',
        'occupation',
        'institution',
        'country',
        'participant_type',
        'presentation_modality',
        'thematic_axis',
        'abstract_content',
        'keywords',
        'abstract_filepath',
    ];

    public function thematic(){
        return $this->belongsTo(Thematic_area::class,'thematic_axis');
    }
    
}