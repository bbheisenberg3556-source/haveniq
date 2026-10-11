<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedRoom extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'output_urls' => 'array',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
