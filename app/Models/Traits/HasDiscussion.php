<?php

namespace App\Models\Traits;

use App\Models\Discussion;

trait HasDiscussion
{
    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    public function isDiscussionOwner($discussion)
    {
        return $this->id === $discussion->user_id;
    }
}
