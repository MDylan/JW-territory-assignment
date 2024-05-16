<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donotdisturb extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_visit',
        'comment',
        'territory_id'
    ];

    public function territory() : BelongsTo 
    {
        return $this->belongsTo(Territory::class);
    }

    public function congregation(): BelongsTo
    {
        return $this->belongsTo(Congregation::class);
    }
}
