<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Forum extends Model
{
    use HasFactory;

    /**
     * Get the threads / topics for the forum
     *
     * @return HasMany
     */
    public function mainDiscussions(): HasMany
    {
        return $this->hasMany(Discussion::class)->whereNull('discussion_id');
    }
}
