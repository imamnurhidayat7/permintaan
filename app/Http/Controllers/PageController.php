<?php

namespace App\Http\Controllers;
use App\Models\Layanan;
use App\Models\User;
use App\Models\Bidang;
use App\Models\Pemberitahuan;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Alert;
use Illuminate\Support\Facades\DB;
use File;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class PageController extends Controller
{
    public function dashboard_cs(){
        return view('customerservice.dashboard');
    }

    public function dashboard_kasi(){
        return view('kasi.dashboard');
    }

    public function dashboard_kabid(){
        return view('kabid.dashboard');
    }

    public function dashboard_kapus(){
        return view('kapus.dashboard');
    }

    public function dashboard_pelaksana(){
        return view('pelaksana.dashboard');
    }

    public function error(){
        return view('error_page');
    }

    public function pemberitahuan(){
        $data['pemberitahuan'] = Pemberitahuan::where('id_user', Session::get('id'))->orderBy('id', 'desc')->get();
        return view('pemberitahuan')->with($data);
    }

    public function markRead(){
        Pemberitahuan::where('id_user', Session::get('id'))->update(['status'=>1]);
        echo "ok";
    }

    public function showLayanan($id){
        $data['bidang'] = Bidang::find($id);
        $data['layanan'] = Layanan::where('status', 1)->where('id_bidang', $id)->get();
        //dd($data);
        return view('frontpage.request_list')->with($data);
    }

    public function profil(){
        $data['user'] = User::find(Session::get('id'));
        return view('profile')->with($data);
    }

    public function requestList(){
        $data['layanan'] = Layanan::where('status_hapus', 0)->get();
        return view('frontpage.request_list')->with($data);
    }
}