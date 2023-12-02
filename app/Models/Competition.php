<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    protected $fillable=['organization_id','title_zh','title_fn','brief','description','start_date','end_date','match_dates','categories_weights','roles','for_member','published','scope'];
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

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
    public function applications(){
        return $this->hasMany(CompetitionApplication::class);
    }

}
