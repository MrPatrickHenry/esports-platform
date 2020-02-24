<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use App\User;

class Admin
{

    private $auth;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->auth = auth()->user() ?
            (auth()->user()->userType === 'VALAdmin')
            : false;

            if($this->auth === true)
                return $next($request);

return false;
    }
}
