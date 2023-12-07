<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CompetitionApplication extends Model
{
    use HasFactory;
    protected $fillable=['competition_id','organization_id','member_id','name_zh','name_fn','given_name','family_name','middle_name','display_name','id_num','gender','dob','belt_rank','email','mobile','category','weight','role','avatar','staff_options','referee_options'];
    protected $casts=['staff_options'=>'json','referee_options'=>'json'];
    protected $appends=['avatar_url'];

    public function getAvatarUrlAttribute(){
        return $this->avatar?Storage::url($this->avatar):'';
    }

    public function competition(){
        return $this->belongsTo(Competition::class)->with('media');
    }
    public function organization(){
        return $this->belongsTo(Organization::class);
    }

}
