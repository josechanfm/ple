<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable=['uuid','organization_id','category_code','title_en','title_fn','content_en','content_fn','valid_at','expire_at','url','reference','published','public','author','user_id'];

    public static function publics(){
        return Article::where('published',true)->where('public',true)
                ->where(function($query){
                    $query->whereNull('valid_at')->orWhere('valid_at','<=',date('Y-m-d'));
                })
                ->where(function($query){
                    $query->whereNull('expire_at')->orWhere('expire_at','>=',date('Y-m-d'));
                })
                ->get();
    }
    public static function privates(){
        return Article::where('published',true)->where('public',false)->where('organization_id',session('organization')->id)
                ->where(function($query){
                    $query->whereNull('valid_at')->orWhere('valid_at','<=',date('Y-m-d'));
                })
                ->where(function($query){
                    $query->whereNull('expire_at')->orWhere('expire_at','>=',date('Y-m-d'));
                })
                ->get();
    }
}
