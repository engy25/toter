<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\Helpers;

class CheckUserMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next)
  {
    if (auth('api')->check() && auth('api')->user()->getRoleNames()->first() == 'User') {

      return $next($request);
    }


    return Helpers::responseJson('failed', trans('api.Pleaze_login_first'), 401, null);

  }
}
