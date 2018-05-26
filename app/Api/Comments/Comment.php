<?php

namespace App\Api\Comments;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function idea()
    {
        return $this->belongsTo('App\Api\Ideas');
    }
}