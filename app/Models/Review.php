<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
     protected $fillable = [
        'registration_id',
        'structure_ok',
        'content_ok',
        'score_intro',
        'score_objectives',
        'score_methodology',
        'score_results',
        'score_conclusions',
        'score_keywords',
        'score_style',
        'feedback',
        'score_total',
        'recommendation_type',
        'status',
        'reviewer_file',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class, 'registration_id');
    }

}
