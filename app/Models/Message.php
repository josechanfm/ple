<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    // protected $append=['received_member'];

    // public function getReceivedMemberAttribute(){
    //     //return $this->getAttribute('received_member
    // }

    public function received_member(){
        return $this->belongsTo(Member::class,'receiver');
    }
}
