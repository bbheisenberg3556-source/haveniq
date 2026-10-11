<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'checklist_data' => 'array',
    ];

    public function getImageUrlAttribute($value)
    {
        if (!empty($this->image_path)) {
            return '/storage/' . ltrim($this->image_path, '/');
        }
        if (!empty($value)) {
            if (str_starts_with($value, 'http://localhost/storage')) {
                return substr($value, strlen('http://localhost'));
            }
            return $value;
        }
        return null;
    }

    public function checklistResponses()
    {
        return $this->hasMany(ChecklistResponse::class);
    }

    public function generatedRooms()
    {
        return $this->hasMany(GeneratedRoom::class);
    }

    public function personalityProfile()
    {
        return $this->hasOne(PersonalityProfile::class);
    }
}
