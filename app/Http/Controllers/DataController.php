<?php

namespace App\Http\Controllers;
use App\Models\Layanan;
use App\Models\Bidang;
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

class DataController extends Controller
{

    public function home(){
        // $db = DB::connection('oracle_db');
        // $update = $db->update("UPDATE SIMPEG_2702.PEGAWAI SET EMAIL = '' WHERE NIPBARU = '196002091982032001' ");

        $data['layanan'] = Layanan::where('status', 1)->get();
        $data['bidang'] = Bidang::orderBy('id', 'asc')->get();
        return view('frontpage.home')->with($data);
    }

    public function showDetailLayanan($id){
        $data['layanan'] = Layanan::find($id);
        if($data['layanan']->status != 1){
            Alert::error('Status layanan tidak aktif');
            return redirect()->back();
        }
        return view('frontpage.detail_layanan')->with($data);
    }

    

}