<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AdminUser;

class Organization extends Model
{
    use HasFactory;
    protected $fillable=['region','territory','abbr','full_name','email','phone','address','country','href','title','avatar','description','content','president','registration_code','card_style','status'];

    public function ownedBy($user=null){
        return in_array($user->id,$this->users()->get()->pluck('id')->toArray());
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function members(){
        return $this->belongsToMany(Member::class)->with('user');
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
    public function events(){
        return $this->hasMany(Event::class);
    }
    public function forms(){
        return $this->hasMany(Form::class)->where('published',true)->with('media');
    }

}
