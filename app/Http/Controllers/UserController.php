<?php

namespace App\Http\Controllers;
use App\Models\Layanan;
use App\Models\User;
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

class UserController extends Controller
{
    public function index(){
        if(Session::get('isSuperAdmin')){
            $data['user'] = User::where('role', '!=', '')->where('role', '!=', 'pemohon')->get();
        }
        else{
            $data['user'] = User::where('role', '!=', '')->where('role', '!=', 'admin')->where('role', '!=', 'pemohon')->get();
        }
        
        $data['bidang'] = Bidang::all();
        return view('admin.user.index')->with($data);
    }

    public function tambahUser(Request $request){
        $data = $request->all();
    
        $rules = [
            'pegawaiid' => 'string|required',
            'role' => 'required',
        ];

        $validator = Validator::make($data, $rules);

        if($validator->fails()){
            Alert::error($validator->errors());
            return redirect()->back();
        }
        
        //User::create($data);

        $user = User::updateOrCreate([
            'pegawaiid' => $data['pegawaiid'],
        ], [
            'role' => $data['role'],
            'id_bidang' => $data['id_bidang']
        ]);

        Alert::success('Berhasil menambahkan user!');
        return redirect('admin/users');
    } 
    
    public function updateUser(Request $request){
        $data = $request->all();
        $rules = [
            'id' => 'required',
            'pegawaiid' => 'string|required',
            'role' => 'required',
        ];

        $validator = Validator::make($data, $rules);

        if($validator->fails()){
            Alert::error($validator->errors());
            return redirect()->back();
        }
        
        $user = User::find($data['id']);
        $user->fill($data);
        $user->save();

        Alert::success('Berhasil melakukan update user!');
        return redirect('admin/users');
    } 
}