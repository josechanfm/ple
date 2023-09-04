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

    static function getInstances(){
        if(!session('organization')){
            return ['events'=>null,'forms'=>'','attendances'=>null];
        };
        $records['events']=Event::where('organization_id',session('organization')->id)->where('with_attendance',true)->get();
        //$records['forms']=Form::where('organization_id',session('organization')->id)->where('with_attendance',true)->get();
        //$records['attendances']=Attendance::where('organization_id',session('organization')->id)->where('with_attendance',true)->get();
        return $records;
    }
}
