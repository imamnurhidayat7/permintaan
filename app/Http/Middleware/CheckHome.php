<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Alert;
use Illuminate\Support\Facades\Session;

class CheckHome
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
        //jika akun yang login sesuai dengan role 
        //maka silahkan akses
        //jika tidak sesuai akan diarahkan ke home
        if(Auth::user()){
            $role = Auth::user()->role;
            return $next($request);
            //dd(Auth::user());
            // if($role != ''){
            //     if($role == 'pemohon'){
            //         return $next($request);
            //     }
            //     else{
            //         //dd('a');
            //         return redirect($role.'/dashboard');
            //     }
            // }
        
        }
        else{
            return redirect('login');
        }

        //Alert::error('Anda tidak berhak mengakses halaman ini');
        return redirect('error');
    }
}
