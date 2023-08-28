<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable=['event_id','member_id','status','user_id'];
    public function event(){
        return $this->belongsTo(Event::class);
    }
    public function member(){
        return $this->belongsTo(Member::class);
    }

    static function getAttendances(){
        $records['events']=Event::where('with_attendance',true)->get();
        $records['forms']=Form::where('with_attendance',true)->get();
        $records['attedances']=Attendance::where('with_attendance',true)->get();
        return $records;
    }
}
