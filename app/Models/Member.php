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
    protected $fillable=[
        'user_id',
        'given_name',
        'family_name',
        'middle_name',
        'display_name',
        'gender',
        'dob',
        'email',
        'mobile',
        'country',
        'nationality',
        'city',
        'street',
        'zip',
        'vat',
        'address',
        'club',
        'positions',
        'role_referees',
        'role_coaches',
        'athlete_belt',
        'athlete_coach',
        'athlete_technique',
        'athlete_side',
        'athlete_height',
        'athlete_weight',
        'federation_officials',
        'organization_officials',
    ];
    protected $casts=['positions'=>'json','federation_officials'=>'json','organization_officials'=>'json'];

    public function createUser(): User
    {
        $user = new User();
        $user->email = $this->email;
        $user->name = $this->given_name;
        $user->password = 'need-to-set';
        $user->save();
        $this->user_id=$user->id;
        $this->save();
        return $user;
    }

    public function user()
    {
        return $this->belongsTo(User::class)->with('roles');
    }

    public function ownedBy($organization=null){
        return in_array($organization->id,$this->organizations()->get()->pluck('id')->toArray());
    }

    // public function hasUser()
    // {
    //     return $this->user()->exists();
    // }
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

    // public function portfolio(){
    //     return $this->hasMany(Portfolio::class);
    // }
    public function positions(){
        return $this->belongsToMany(Position::class);
    }

    public function events(){
        return $this->belongsToMany(Event::class,'event_manager','member_id','event_id');
    }

    public function attendances(){
        return $this->belongsToMany(Attendance::class);
    }

}
