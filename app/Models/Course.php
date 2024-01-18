<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable=['organization_id','title','learn','brief','description','image','start_on','finsh_on','published','user_id'];
    protected $casts=['modules'=>'json'];
    protected $appends=['teachers'];
    
    public function getTeachersAttribute(){
        return $this->users->where('pivot.actor_id','TCH');
    }
    public function content(){
        return $this->belongsTo(Course::class)->withPivot('type', 'title');
    }
    public function contents(){
        return $this->hasMany(Content::class);
    }
    public function forum(){
        return $this->hasOne(Forum::class)->with('mainDiscussions');
    }
    public function forums(){
        return $this->hasMany(Forum::class);
    }
    public static function recommends(){
        return Course::all();
    }
    public function isUser($user){
        return in_array($user->id,$this->users->pluck('id')->toArray());
    }
    public function users(){
        return $this->belongsToMany(User::class)->withPivot('actor_code');
    }
}
