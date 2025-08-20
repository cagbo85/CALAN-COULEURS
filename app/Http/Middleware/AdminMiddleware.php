<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (! $user) {
            return redirect('/login');
        }

        if (! $user->isActive() || (! $user->isAdmin() && ! $user->isSuperAdmin())) {
            abort(403, 'Accès non autorisé');
        }

        return $next($request);
    }
}
