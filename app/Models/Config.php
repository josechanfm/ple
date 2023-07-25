<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;

class Config extends Model
{
    use HasFactory;
    //protected $casts=['value'=>'json'];

    static function item($key)
    {
        if(Session::has('organization')){
            $item = Config::where('organization_id',session('organization')->id)->where('key', $key)->first();
            if(empty($item)){
                $item = Config::where('organization_id',0)->where('key', $key)->first();
            }
        }
        if ($item) {
            return json_decode($item->value);
        } else {
            return false;
        }
    }

    // static function items($key,$organizationId=0)
    // {
    //     $items = Config::where('organization_id',$organizationId)->where('key', $key)->get();
    //     $collections=[];
    //     foreach($items as $item){
    //         $collections[]=json_decode($item->value,true);
    //     }
    //     return $collections;
    // }

    static function categories_weights()
    {
        if(Session::has('organization')){
            $items = Config::where('organization_id',session('organization')->id)->where('key', 'categories_weights')->get();
            if($items->count()==0){
                $items = Config::where('organization_id',0)->where('key', 'categories_weights')->get();                
            }
        }
        //  $items = Config::where('organization_id',$organizationId)->where('key', 'categories_weights')->get();
        $collections=[];
        foreach($items as $item){
            $collections[]=json_decode($item->value,true);
        }
        return $collections;
    }

}
