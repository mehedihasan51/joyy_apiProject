<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class notifications extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'message',
        'type',
        'user_id',
    ];
    protected $casts = [
        'title' => 'string',
        'message' => 'string',
        'type' => 'string',
        'user_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
