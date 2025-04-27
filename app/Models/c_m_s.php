<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class c_m_s extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'page',
        'section',
        'name',
        'slug',
        'title',
        'sub_title',
        'description',
        'sub_description',
        'bg',
        'image',
        'btn_text',
        'btn_link',
        'btn_color',
        'metadata',
        'phone',
        'email',
        'location',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'page' => 'string',
        'section' => 'string',
        'name' => 'string',
        'slug' => 'string',
        'title' => 'string',
        'sub_title' => 'string',
        'description' => 'string',
        'sub_description' => 'string',
        'bg' => 'string',
        'image' => 'string',
        'btn_text' => 'string',
        'btn_link' => 'string',
        'btn_color' => 'string',
        'metadata' => 'array',
        'phone' => 'string',
        'email' => 'string',
        'location' => 'string',
        'latitude' => 'float',
        'longitude' => 'float',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
