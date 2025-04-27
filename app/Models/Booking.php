<?php

namespace App\Models;

// use App\Models\Branche;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'agree',
        'branche_id',
        'day',
        'type',
        'category',
        'subcategory',
        'square',
        'bedroom',
        'bathroom',
        'carpet',
        'interior',
        'price',
        'address',
        'apartment',
        'city',
        'state',
        'zip',
        'tc',
        'transaction_id',
        'status'
    ];

    protected $casts = [
        'interior' => 'array',
        'day' => 'date',
        'price' => 'double',
        'agree' => 'boolean',
        
        'tc' => 'boolean',
        'deleted_at' => 'datetime',
        'branch_id' => 'integer'
    ];


    // public function branch()
    // {
    //     return $this->belongsTo(Branche::class);
    // }

    public function branch()
    {
        return $this->belongsTo(Branche::class, 'branche_id');
    }




}