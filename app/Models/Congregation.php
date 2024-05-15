<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Congregation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function publishers() : HasMany
    {
        return $this->hasMany(Publisher::class);
    }

    public function territories(): HasMany
    {
        return $this->hasMany(Territory::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function donotdisturbs(): HasMany
    {
        return $this->hasMany(Donotdisturb::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
