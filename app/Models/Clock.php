<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clock extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id', 'type', 'time', 'memo', 'minutes', 'is_approved', 'approved_by', 'approval_notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
}
