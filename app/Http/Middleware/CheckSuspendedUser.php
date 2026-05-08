<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuspendedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (

            $user &&  $user->profile && ! $user->profile->is_active

        ) {

            return response()->json([

                'success' => false,

                'message' =>

                    'Account suspended. Contact admin.'

            ], 403);

        }
        return $next($request);
    }
}
