<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MemberGuest
{
    public function handle(Request $request, Closure $next)
    {
        // Agar member already login hai toh dashboard bhejo
        if (session()->has('member_id')) {
            return redirect('/member/dashboard');
        }

        return $next($request);
    }
}
