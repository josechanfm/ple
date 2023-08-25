<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable=['organization_id','category_code','title_en','title_fn','content_en','content_fn','valid_at','expired_at','url','reference','published'];
}
