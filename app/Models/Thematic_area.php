<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thematic_area extends Model
{
    //

    public function users()
{
    return $this->belongsToMany(User::class)
                ->withTimestamps();
}

}
