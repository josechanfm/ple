<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionApplication extends Model
{
    use HasFactory;
    protected $fillable=['competition_id','organization_id','member_id','given_name','family_name','middle_name','display_name','gender','dob','belt_rank','email','mobile','category','weight','role','staff_options','referee_options'];

}
