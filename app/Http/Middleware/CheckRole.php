<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user()) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure role relationship is loaded
        $user = $request->user()->load('role');
        
        if (!$user->role || $user->role->name !== $role) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
} 