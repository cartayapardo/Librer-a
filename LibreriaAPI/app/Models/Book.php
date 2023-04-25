<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'description', 'user_id', 'reservation_date', 'deadline', 'active'];

    protected $with = ['user'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
