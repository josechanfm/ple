<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Certificate extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable=['organization_id','category_code','name','cert_title','cert_body','cert_template','number_format','rank_catption','descreption'];
    protected $appends=['cid','cert_number'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cert_content');
    }

    public function getCidAttribute(){
        return $this->id;
        //return substr('000'.strtoupper(base_convert($this->pivot->id,10,36)),-3);
    }

    public function getCertNumberAttribute(){
        return preg_replace('/0+/i',$this->number,$this->cert_number_format);
        //return '00000'.$this->pivot->number;
    }

    public function members(){
        return $this->belongsToMany(Member::class)->withPivot(
            'id','display_name','number','number_display','issue_date','valid_from','valid_until','authorized_by','rank','avatar','remark');
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }

    
}
