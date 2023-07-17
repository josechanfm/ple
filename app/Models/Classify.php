<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classify extends Model
{
    use HasFactory;

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
    public function articles(){
        return $this->hasMany(Article::class);
    }
}
