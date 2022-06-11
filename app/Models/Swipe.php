<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Swipe extends Model
{
    protected $fillable = [
        'owner_id',
        'target_id'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'target_id');
    }
}
