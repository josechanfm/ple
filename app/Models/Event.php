<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Event extends Model
{
    use HasFactory;
    protected $fillable=['organization_id','title_en','title_fn','category','credit','start_date','end_date','description','remark','with_attendance'];
    protected $attributes=[
        'title_en'=>'',
        'category'=>'',
        'credit'=>'',
        'start_date'=>'',
    ];

    public function attendances(){
        return $this->hasMany(Attendance::class)->with('member');
    }
    public function managers(){
        return $this->belongsToMany(Member::class,'event_manager','event_id','member_id');
    }

    public function attendedMembers():MorphToMany{
        return $this->morphedByMany(Member::class,'attendee')->withPivot('status');
    }
    public function attendedParticipants(){
        return $this->morphedByMany(Participant::class,'attendee')->withPivot('status');
    }
    public function participants(){
        return $this->hasMany(Participant::class);
    }
    public function attendees(){
        return $this->hasMany(Attendee::class);
    }


}
