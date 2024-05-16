<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Congregation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();

        //To generate unique slugs
        static::creating(function ($congregation) {
            $congregation->slug = $congregation->generateUniqueSlug($congregation->name);
        });
    }

    // Function to generate unique slug
    protected function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = 1;

        // Check if the slug already exists
        while (static::whereSlug($slug)->exists()) {
            $slug = Str::slug($name) . '-' . $count;
            $count++;
        }

        return $slug;
    }

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
