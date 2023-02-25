<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->headers->get('authorization')) {
            $token = substr($request->headers->get('authorization'),
                strpos($request->headers->get('authorization'), ' ') + 1);
            $user = User::where('token', $token)->first();
            if(strpos($user->updated_at, '.')){
                $date=substr($user->updated_at,0, strpos($user->updated_at, '.'));

            }else{
                $date=$user->updated_at;
            }
            $date=explode(' ', $date);
            $h=explode(':', $date[1]);
            $d=explode('-', $date[0]);
            $time=mktime($h[0], $h[1], $h[2], $d[1], $d[2],$d[0]);
            $t=time()-$time;
            if((time()-$time)/60>5){
                $user->update([
                    'token'=>null
                ]);
               return \response('', 401);
            }

            return $next($request);
        }

        return \response('', 401);

        //первый токен обнавляется в этом случии
        /*if ($request->headers->get('authorization')) {
            if (auth()->user()) {
                $user=auth()->user();
                $user->update(['token'=>null]);
                return $next($request);
            } else {
                $token = substr($request->headers->get('authorization'),
                    strpos($request->headers->get('authorization'), ' ') + 1);
                $user = User::where('token', $token)->first();
                if (isset($user)) {
                    $token = auth()->login($user);
                    $user->update([
                        'token' => $token,
                    ]);
                } else {
                    return \response('', 401);
                }
            }
            return $next($request);
        }
        return \response('', 401);*/

    }
}
