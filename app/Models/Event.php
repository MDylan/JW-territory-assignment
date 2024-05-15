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
        'assigned',
        'completed',
        'comment'
    ];

    public function territory() : BelongsTo
    {
        $this->belongsTo(Territory::class);
    }

    public function publisher(): BelongsTo
    {
        $this->belongsTo(Publisher::class);
    }
}
