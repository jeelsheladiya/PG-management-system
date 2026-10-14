<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;//browser Info (url, form data, session, etc.)
use Symfony\Component\HttpFoundation\Response;

// class name which is used in routes / --> middleware (AdminAuth)
class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!session('admin_id')){
            return redirect('/admin/login');
        }
        return $next($request);
    }
}
