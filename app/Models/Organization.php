<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AdminUser;

class Organization extends Model
{
    use HasFactory;

    public function ownedBy($user=null){
        return in_array($user->id,$this->users()->get()->pluck('id')->toArray());
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function members(){
        return $this->belongsToMany(Member::class);
    }

    // public function hasUser($user){
    //     return in_array($user->id,$this->users()->get()->pluck('id')->toArray());
    // }

    public function approbates(){
        return $this->hasMany(Approbate::class);
    }

    public function certificates(){
        return $this->hasMany(Certificate::class);
    }
    public function forms(){
        return $this->hasMany(Form::class)->with('media');
    }

}
