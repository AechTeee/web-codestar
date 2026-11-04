<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';
    protected $dates = ['deleted_at'];
    protected $dateFormat = 'Y-m-d';

    public function scopeLavarel($query)
    {
        return $query->where('title', 'like', '%Laravel%');
    }

    public function scopeGetUser2($query)
    {
        return $query->where('user_id', 2);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
