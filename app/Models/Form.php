<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Form extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $fillable=[];

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('form_content');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('form_content');
    }

    public function organization(){
        return $this->belongsTo(Organization::class);
    }

    public function fields(){
        return $this->hasMany(FormField::class)->orderBy('sequence');
    }
    //extra fields show in entry table
    public function in_column_fields(){
        return $this->hasMany(FormField::class)->where('in_column',1);
    }
    //entry table column headers, for frontend table view and export to excel
    public function entry_columns(){
        $columns[]=(object)['title'=>'#','dataIndex'=>'uid'];
        foreach($this->in_column_fields as $column){
            $columns[]=(object)['title'=>$column->field_name,'dataIndex'=>'extra_'.$column->id];
        }
        $columns[]=(object)['title'=>'Submit at','dataIndex'=>'submitted_at'];
        $columns[]=(object)['title'=>'Action','dataIndex'=>'operation'];
        return $columns;
    }

    public function entries(){
        return $this->hasMany(Entry::class)->with('records');
    }
    //entries for frontend table view and export to excel
    public function tableEntries(){
        $entries=$this->entries;
        $fields=$this->in_column_fields;
        foreach($entries as $entry){
            foreach($fields as $field){
                $f=$entry->records->where('form_field_id',$field->id)->first();
                if($f){
                    $entry['extra_'.$field->id]=$f->field_value;
                }
            }
        }
        return $entries;
    }
    public function records(){
        $fields=$this->fields;
        $entries=$this->entries;
        $list=[];
        foreach($entries as $e=>$entry){
            $tmp=[];
            foreach($fields as $f=>$field){
                $tmp['entry_id']=$entry->id;
                $tmp[$field->id]='';
            }
            foreach($entry->records as $r=>$record){
                $tmp[$record->form_field_id]=$record->field_value;
            }
            array_push($list, $tmp);
        }
        return collect($list);
        
    }
    public function hasChild(){
        return $this->fields()->exists();
    }
    // public function members(): MorphToMany{
    //     return $this->morphToMany(Member::class,'attendee')->withPivot(['status']);
    // }

}
    