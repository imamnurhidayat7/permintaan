<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Alert;
use App\Models\User;

class CheckRole
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

        if (Auth::guest()){
            return redirect('/');
        }
        $roles = array_slice(func_get_args(), 2);

        foreach ($roles as $role) { 
            $user = Auth::user()->role;
            if( $user == $role){
                return $next($request);
            }
            // if($role == 'pemohon'){
            //     $user = User::find(Auth::user()->id);
            //     if($user->buat_tiket == 1){
            //         return $next($request);
            //     }
            // }
            if($role == 'pusdatin'){
                $user = User::find(Auth::user()->id);
                if($user->buat_tiket == 1){
                    return $next($request);
                }
            }
        }

        //Alert::error('Anda tidak berhak mengakses halaman ini');
        return redirect('error');
    }
}
