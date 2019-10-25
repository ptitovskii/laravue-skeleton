<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Guest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if ($request->wantsJson()) {
                return \Response::noContent(Response::HTTP_FORBIDDEN);
            }

            return redirect('/');
        }

        return $next($request);
    }
}
