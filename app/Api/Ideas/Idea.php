<?php

namespace App\Api\Ideas;

use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    public function owner()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Api\Comments\Comment');
    }
}