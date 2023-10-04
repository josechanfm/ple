<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AdminUser;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Organization extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable=['region','territory','abbr','full_name','email','phone','address','country','href','title','avatar','description','content','president','registration_code','card_style','status'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->useDisk('form');
    }

    public function ownedBy($user=null){
        return in_array($user->id,$this->users()->get()->pluck('id')->toArray());
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function members(){
        return $this->belongsToMany(Member::class)->with('user');
    }

    public function hasUser($user){
        return in_array($user->id,$this->users()->get()->pluck('id')->toArray());
    }

    public function approbates(){
        return $this->hasMany(Approbate::class);
    }

    public function certificates(){
        return $this->hasMany(Certificate::class)->with('media');
    }
    public function events(){
        return $this->hasMany(Event::class);
    }
    public function forms($published=null){
        if($published==null){
            return $this->hasMany(Form::class)->with('media')->withCount('entries');    
        }else{
            return $this->hasMany(Form::class)->where('published',$published)->with('media')->withCount('entries');
        }
    }

}
