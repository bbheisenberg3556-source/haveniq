<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalityProfile extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'traits' => 'array',
        'raw_response' => 'array',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
