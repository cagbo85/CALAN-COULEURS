<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        if (!$user->isActive() || (!$user->isAdmin() && !$user->isSuperAdmin())) {
            abort(403, 'Accès non autorisé');
        }

        return $next($request);
    }
}
