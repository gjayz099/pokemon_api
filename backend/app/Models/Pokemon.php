<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pokemon extends Model
{
    use HasFactory;

    protected $fillable = [
        "Name","Picture"
    ];


    public function types() : HasMany
    {
        return $this->hasMany(Type::class, 'Pokemon_id');
    }

    public function abilities() : HasMany
    {
        return $this->hasMany(Ability::class, 'Pokemon_id');
    }

    public function experiences() : HasOne
    {
        return $this->hasOne(Experience::class, 'Pokemon_id');
    }
}   
