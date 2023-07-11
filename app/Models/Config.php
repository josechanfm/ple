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
}
