<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Alert;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class CheckKeycloak
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
            if(Session::get('id') != ''){
                //$apiURL = env("KEYCLOAK_API_URL", "");
                $user = User::find(Session::get('id'));
                //$apiURL = 'https://logindev.atrbpn.go.id/auth/realms/internal-realm/protocol/openid-connect/userinfo';
                $apiURL = 'https://login.atrbpn.go.id/auth/realms/internal/protocol/openid-connect/userinfo';
        
                $headers = [
                    'Authorization' => 'Bearer '.$user->access_token
                ];

                try{
                    $response = Http::withHeaders($headers)->post($apiURL);
        
                    $statusCode = $response->status();
                    $responseBody = json_decode($response->getBody(), true);
                    if(Session::get('id') == 13){
                        //dd($responseBody);
                    }
                    
                    if($statusCode != 200){
                        Auth::logout();
                        Session::flush();
                        return redirect('/login');
                    }
                    else{
                        return $next($request);
                    }
                }
                catch(\Exception $e){
                    return $next($request);
                }
            }
            else{
                return redirect('/login');
            }


            return $next($request);
        
        

    }
}
