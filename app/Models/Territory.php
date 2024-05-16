<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Territory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'city_id',
        'number',
        'comment',
        'image_1',
        'image_2',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function donotdisturbs() : HasMany 
    {
        return $this->hasMany(Donotdisturb::class);
    }

    public function events() : HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function congregation(): BelongsTo
    {
        return $this->belongsTo(Congregation::class);
    }
}
