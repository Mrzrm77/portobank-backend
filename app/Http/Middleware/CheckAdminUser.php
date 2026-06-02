<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminUser
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (! $user || $user->role !== 'admin') {
            abort(403, 'Admin access required.');
        }

        return $next($request);
    }
}
