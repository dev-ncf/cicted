<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    //
    protected $fillable = [
        'title',
        'abstract',
        'author_id',
        'thematic_area_id',
        'status',
        'avaliador_id',
        'prazo',
        'keywords',
    ];

    public function thematic(){
        return $this->belongsTo(Thematic_area::class,'thematic_area_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'author_id');
    }
    public function avaliador(){
        return $this->hasOne(User::class,'avaliador_id');
    }
}
