<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
class CheckDeliveryMiddleware
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
 
    if (auth('api')->check() &&  auth('api')->user()->getRoleNames()->first() == 'Delivery') {
      return $next($request);
    }
    return Helpers::responseJson('failed', trans('api.Pleaze_login_first'), 401, null);

  }
}
