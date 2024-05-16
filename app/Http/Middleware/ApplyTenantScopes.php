<?php

namespace App\Http\Middleware;

use App\Models\City;
use App\Models\Donotdisturb;
use App\Models\Event;
use App\Models\Publisher;
use App\Models\Territory;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplyTenantScopes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        City::addGlobalScope(
            fn (Builder $query) => $query->whereBelongsTo(Filament::getTenant())
        );
        Territory::addGlobalScope(
            fn (Builder $query) => $query->whereBelongsTo(Filament::getTenant())
        );
        Donotdisturb::addGlobalScope(
            fn (Builder $query) => $query->whereBelongsTo(Filament::getTenant())
        );
        Event::addGlobalScope(
            fn (Builder $query) => $query->whereBelongsTo(Filament::getTenant())
        );
        Publisher::addGlobalScope(
            fn (Builder $query) => $query->whereBelongsTo(Filament::getTenant())
        );
        return $next($request);
    }
}
