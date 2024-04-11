<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        "Base_experience",
        "Pokemon_id",
    ];


    public function pokemon() : BelongsTo
    {
        return $this->belongsTo(Pokemon::class, 'Pokemon_id');
    }
}
