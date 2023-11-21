<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Illuminate\Http\Response; // Import the Response class


class CheckRoleScopeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$scopes) // Return JsonResponse
    {
        
        /**check if the user exist */
        if (auth('api')->check()) {

            $user = auth('api')->user();
            /**get the access token of the user */
            $access_token = \DB::Table("oauth_access_tokens")->where("user_id", $user->id)->first();
           
            if ($access_token) {

                $scope = json_decode($access_token->scopes);

                if (in_array($scopes[0], $scope)) {
                  
                    return $next($request);
                } else {

                    return Helpers::responseJson('failed', trans('api.Pleaze_login_first'), 401, null);

                }
            } else {

                return Helpers::responseJson('failed', trans('api.Pleaze_login_first'), 401, null);
            }
        } else {
            return Helpers::responseJson('failed', trans('api.Pleaze_login_first'), 401, null);
        }



    }









}