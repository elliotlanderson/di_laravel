<?php

namespace App\Api\Skills;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    /**
     * Many-Many Pivot Relationship with Users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}