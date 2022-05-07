<?php


namespace App\Http\Middleware;

use Closure;
class AdminMiddleware
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
        $user = auth()->user();
        if(!empty($user))
        {
            $roles = $user->roles;
            if(!in_array('admin',$roles))
                return response('Unauthorized.',401);
        }
        return $next($request);
    }
}
