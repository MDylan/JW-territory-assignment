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
        'number',
        'comment'
    ];

    public function city(): BelongsTo
    {
        $this->belongsTo(City::class);
    }

    public function donotdisturbs() : HasMany 
    {
        $this->hasMany(Donotdisturb::class);
    }

    public function events() : HasMany
    {
        $this->hasMany(Event::class);
    }
}
