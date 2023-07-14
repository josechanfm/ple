<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionApplication extends Model
{
    use HasFactory;
    protected $fillable=['member_id','given_name','family_name','middle_name','display_name','gender','dob','email','mobile','competition_id','category','weight','role'];

}
