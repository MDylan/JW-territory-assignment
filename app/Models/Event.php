<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'congregation_id',
        'territory_id',
        'assigned',
        'completed',
        'comment'
    ];

    public function territory() : BelongsTo
    {
        return $this->belongsTo(Territory::class);
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    public function congregation(): BelongsTo
    {
        return $this->belongsTo(Congregation::class);
    }
}
