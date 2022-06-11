<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pair extends Model
{
    protected $fillable = [
        'first_user_id',
        'second_user_id'
    ];

    public function firstUser()
    {
        return $this->belongsTo(User::class, 'first_user_id');
    }

    public function secondUser()
    {
        return $this->belongsTo(User::class, 'second_user_id');
    }
}
