<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Event extends Model
{
    use HasFactory;
    protected $fillable=['organization_id','category_code','credit','title_en','title_fn','start_date','end_date','description','remark','with_attendance','form_id'];
    protected $attributes=[
        'title_en'=>'',
        'category_code'=>'',
        'credit'=>'',
        'start_date'=>'',
    ];

    public function attendances(){
        return $this->hasMany(Attendance::class)->with('member');
    }
    public function managers(){
        return $this->belongsToMany(Member::class,'event_manager','event_id','member_id');
    }

    public function members():MorphToMany{
        return $this->morphedByMany(Member::class,'attendee')->withPivot('status');
    }
    public function participants(){
        return $this->morphedByMany(Participant::class,'attendee')->withPivot('status');
    }
    public function entries(){
        return $this->morphedByMany(Entry::class,'attendee')->withPivot('status');
    }
    public function others(){
        return $this->hasMany(Attendee::class)->where('attendee_type',null);
    }
    public function attendees(){
        $attendees=$this->hasMany(Attendee::class)->get();
        foreach($attendees as $id=>$attendee){
            if($attendee->attendee_type){
                $instance=$attendee->attendee_type::find($attendee->attendee_id)->first();
                $attendee[strtolower(class_basename($instance))]=$instance;
    
            }
        }
        return $attendees;

        //return $this->hasMany(Attendee::class);
        //return $this->hasMany(Attendee::class)->with('member')->where('attendee_type','App\Models\Member');
    }

}
