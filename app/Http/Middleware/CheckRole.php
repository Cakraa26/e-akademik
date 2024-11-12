<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (in_array(Session::get('role'), $roles)) {
            return $next($request);
        }

        return redirect('/')->withErrors(['error' => 'Anda tidak memiliki akses ke halaman ini']);
    }
}
