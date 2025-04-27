<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branche extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'zip',
        'name',
        'email',
        'phone',
        'state',
        'address',
        'status'
    ];
    protected $casts = [
        'zip' => 'integer',
        'status' => 'string',
        'deleted_at' => 'datetime'
    ];
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
