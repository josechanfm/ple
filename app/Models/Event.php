<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable=['organization_id','title_en','title_fn','category','credit','start_date','end_date','description','remark'];
    protected $attributes=[
        'title_en'=>'',
        'category'=>'',
        'credit'=>'',
        'start_date'=>'',
    ];
}
