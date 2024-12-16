<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\API\API;

class IsProvider
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->expectsJson()) {
            if(\Auth::check()) {
                if(\Auth::user()->user_type != User::TYPE_PROVIDER) {
                    return (new API)->setStatusUnauthorized()->setMessage(__("This Account can't Login On This ".User::TYPE_PROVIDER." Application"))->build();
                }   
            }
        }
        return $next($request);
    }
}