<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discussion extends Model
{
    use HasFactory;

    /**
     * Get the replies for the discussion
     *
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Discussion::class, 'discussion_id');
    }
}
