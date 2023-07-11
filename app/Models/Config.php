<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;
    //protected $casts=['value'=>'json'];

    static function item($key)
    {
        $item = Config::where('key', $key)->first();
        if ($item) {
            return json_decode($item->value);
        } else {
            return false;
        }
    }

    static function items($key)
    {
        $items = Config::where('key', $key)->get();
        $collections=[];
        foreach($items as $item){
            $collections[]=json_decode($item->value,true);
        }
        return $collections;
    }

    static function categories_weights()
    {
        $items = Config::where('key', 'categories_weights')->get();
        $collections=[];
        foreach($items as $item){
            $collections[]=json_decode($item->value,true);
        }
        return $collections;
    }

}
