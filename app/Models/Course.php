<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable=['organization_id','title','brief','description','image','start_on','finsh_on','published','user_id'];

    public function materials(){
        return $this->hasMany(Material::class);
    }
    public static function recommends(){
        return Course::all();
    }
}
