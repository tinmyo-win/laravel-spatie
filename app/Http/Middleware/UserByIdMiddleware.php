<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserByIdMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $id = $request->id ?? null;
        $user = auth()->user();

        //it means if user is starndard user and request for another user by id we fobidden

        if(!$user->hasAnyRole(['admin', 'Super-Admin']) && $id != $user->id) {
            return response()->json(['message' => 'You do not have permission for this user info request!'], 403);
        }

        return $next($request);
    }
}
