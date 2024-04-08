<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        "Type_name", "Pokemon_id"
    ];

    public function pokemon() : BelongsTo
    {
        return $this->belongsTo(Pokemon::class, 'Pokemon_id');
    }
}
