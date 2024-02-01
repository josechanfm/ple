<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['organization_id', 'modules', 'title', 'learn', 'brief', 'description', 'image', 'start_on', 'finsh_on', 'published', 'user_id'];
    protected $casts = ['modules' => 'json'];
    protected $appends = ['teachers'];

    public function getTeachersAttribute()
    {
        return $this->users->where('pivot.actor_id', 'TCH');
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function forum()
    {
        return $this->hasOne(Forum::class)->with('mainDiscussions');
    }

    public function forums()
    {
        return $this->hasMany(Forum::class);
    }

    public static function recommends()
    {
        return Course::all();
    }

    public function isUser($user)
    {
        return in_array($user->id, $this->users->pluck('id')->toArray());
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('actor_code');
    }

    public function groupedContents()
    {
        $consolidated = collect([]);
        $modules = collect($this->modules);

        $this->contents()->get()->each(function($content) use($modules, $consolidated){

            // we try to find the corresponding module
            $module = $modules->where('value', $content->module)->first();

            // there is no module, we put it in general
            if ($module == null) {
                if (!$consolidated->contains('value', 'general')) {
                    $consolidated->push([
                        'title' => '未分組',
                        'value' => 'general',
                        'contentType' => 'module',
                        'children' => collect([$content])
                    ]);
                } else {
                    $consolidated->where('value', 'general')->first()['children']->push($content);
                }
                return;
            }

            if (!$consolidated->contains('value', $module['value'])) {
                $consolidated->push([
                    'title' => $module['label'],
                    'value' => $module['value'],
                    'contentType' => 'module',
                    'children' => collect([$content])
                ]);
                return;
            }

            $consolidated->where('value', $module['value'])->first()['children']->push($content);
        });

        return $consolidated;
    }
}
