<?php

namespace App\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'congregation_id'
    ];

    protected static function boot()
    {
        parent::boot();

        //To generate unique slugs
        static::creating(function ($city) {
            $city->congregation_id = Filament::getTenant()->id;
        });

        static::addGlobalScope(function (Builder $builder) {
            $builder->where('congregation_id', Filament::getTenant()->id);
        });
    }

    public function congregation(): BelongsTo
    {
        return $this->belongsTo(Congregation::class);
    }
}
