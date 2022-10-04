<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Config;
use Auth;

class SetTenant
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
        if (Auth::user()) {
            DB::statement('SET @tenant_id=' . Auth::user()->tenant_id);
        }        

        return $next($request);
    }
}