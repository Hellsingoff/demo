<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (null === $user = $request->user()) {
            return redirect()->route('login');
        }
        if ($role !== $user->role->value) {
            return redirect()->route('main.menu');
        }

        return $next($request);
    }
}
