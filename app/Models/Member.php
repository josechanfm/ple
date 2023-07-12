<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Organization;

class Member extends Model
{
    use HasFactory;

    public function createUser(): User
    {
        $user = new User();

        $user->email = $this->email;
        $user->name = $this->first_name;
        $user->password = 'need-to-set';

        $user->save();

        return $user;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hasUser()
    {
        return $this->user()->exists();
    }
    public function guardian(){
        return $this->belongsTo(Guardian::class);
    }
    public function organizations(){
        return $this->belongsToMany(Organization::class);
    }

    public function belongsToOrganization($organization){
        return $this->belongsToMany(Organization::class)->wherePivot('organization_id', $organization->id);
    }
    public function portfolios(){
        return $this->hasMany(Portfolio::class);
    }
    public function certificates(){
        return $this->belongsToMany(Certificate::class)->withPivot(
            'id','display_name','number','number_display','issue_date','valid_from','valid_until','authorize_by','rank','avata');
    }

    public function portfolio(){
        return $this->hasOne(Portfolio::class);
    }
    public function positions(){
        return $this->belongsToMany(Position::class);
    }
    public function athlete(){
        return $this->hasOne(Athlete::class)->latestOfMany();
        //return $this->hasOne(Athlete::class)->ofMany('active',true);
    }

}
