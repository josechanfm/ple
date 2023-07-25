<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    protected $casts=['match_dates'=>'json','categories_weights'=>'json','roles'=>'json'];
    protected $attributes=[
        'title_en'=>'',                                                                                                                                                                                                                                                                             
        'title_fn'=>'',
        'description'=>'',
        'start_date'=>'',
        'end_date'=>'',
        // 'period'=>'[]',
        // 'match_dates'=>'[]',
        // // 'categories_weights'=>'',
        // // 'roles'=>'[]',
        // // 'period'=>'[]',
        // 'cwSelected'=>'[]',
        // 'roleSelected'=>''
        // 'roles'=>''
    ];

}
