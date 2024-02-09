<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    protected $fillable=['course_id','module','type','title','content','image','start_on','finsh_on','published','frontpage','user_id'];

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
