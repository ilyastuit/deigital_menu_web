<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(Auth::check()){
            if(Auth::user()->hasRole('admin')){
                return $next($request);
            }
            return redirect('/login');
        }
        return redirect('/login');
    }
}
