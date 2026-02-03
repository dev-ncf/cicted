<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    //
    protected $fillable = [
        'title',
        'abstract',
        'author_id ',
        'thematic_area_id ',
        'status',
    ];
}
