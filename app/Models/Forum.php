<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    public function mainDiscussions(){
        return $this->hasMany(Discussion::class)->where('discussion_id',null);
    }
}
