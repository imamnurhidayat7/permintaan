<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Auth;
use Alert;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    private function amankan($x) {
        $search  = array('SELECT', ' UNION ', ' AND ', ' OR ');
        $replace = array('', '', '', '', '');
        
        $kataAman = strip_tags($x);
        $kataAman = str_replace("'","",$kataAman);
        $kataAman = str_replace("--","",$kataAman);
        $kataAman = str_replace(";","",$kataAman);
        $kataAman = str_ireplace($search,$replace,$kataAman); 
         
        return $kataAman;
    }

    public function showLoginPage(){
        return Socialite::driver('keycloak')->redirect(); 
        //return view('auth.login');  
    }

    public function redirect(Request $request){
        
        foreach($request->all() as $key => $value){
            $request->$key = $this->amankan($value);
        }

        $data = $request->all();

        $keycloak_user = Socialite::driver('keycloak')->stateless()->user(); 
        if(!$keycloak_user){
            return Socialite::driver('keycloak')->redirect(); 
        }
        $detail = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $keycloak_user->token)[1]))),true);
        
        $role = '';
        $nip = $detail['atrbpn-profile']['pegawaiid'];
        $foto = '';
        $kantor = $detail['atrbpn-profile']['namakantor'];

        //oracle
        $store = DB::connection('oracle_db');
        $data_simpeg = $store->selectOne("SELECT FOTO, SATKERID FROM SIMPEG_2702.PEGAWAI WHERE NIPBARU = '$nip' ");
        
        $data['isUserPusat'] = 0;
        
        if($detail['atrbpn-profile']['namakantor'] == 'Kantor Badan Pertanahan Nasional'){
            $data['isUserPusat'] = 1;
            //get satker
            if($data_simpeg){
                $satkerid = substr($data_simpeg->satkerid, 0, 6);
                //dd($data_simpeg);
                $satker = $store->selectOne("SELECT SATKER FROM SIMPEG_2702.SATKER WHERE SATKERID = '$satkerid' ");
                if($satker){
                    $kantor = $satker->satker;
                    $foto = $data_simpeg->foto;
                    Session::put('isPusdatin', false);
                    if($satker->satker == 'Pusat Data dan Informasi Pertanahan, Tata Ruang dan Lahan Pertanian Pangan Berkelanjutan'){
                        Session::put('isPusdatin', true);
                    }
                }
            }
            
        }

        $user = User::updateOrCreate([
            'pegawaiid' => $detail['atrbpn-profile']['pegawaiid'],
        ], [
            'name' => $keycloak_user->name,
            'email' => $keycloak_user->email,
            'access_token' => $keycloak_user->token,
            'id_token' => $keycloak_user->id,
            'refresh_token' => $keycloak_user->refreshToken,
            'pegawaiid' => $detail['atrbpn-profile']['pegawaiid'],
            'kantor' => $kantor,
            'foto'=>$foto,
            'buat_tiket'=>$detail['atrbpn-profile']['loginpusdatin'],
            'isUserPusat'=>$data['isUserPusat']
        ]);

        // if($detail['atrbpn-profile']['loginpusdatin'] == 1){
        //     $update = User::where('pegawaiid', $detail['atrbpn-profile']['pegawaiid'])->update(['buat_tiket'=>1]);
        // }

        $admin = 0;
       
        if($user->role == ''){
            foreach($detail['resource_access']['dotnet-web']['roles'] as $row){
                if($row == 'KepalaSubBagianTataUsaha' || $row == 'KabagTU'){
                    $update = User::where('pegawaiid', $detail['atrbpn-profile']['pegawaiid'])->update(['role'=>'pemohon', 'buat_tiket'=>1]);
                }
                // else if($row == 'Administrator Pusdatin'){
                //     $admin = 1;
                // }
            }
        }

        // if($detail['atrbpn-profile']['pegawaiid'] == '199702042022041001'){
        //     $admin = 1;
        // }

        if($admin == 1){
            $update = User::where('pegawaiid', $detail['atrbpn-profile']['pegawaiid'])->update(['role'=>'admin']);
        }

        $user = User::where('pegawaiid', $detail['atrbpn-profile']['pegawaiid'])->first();
        
        Auth::login($user);
        
        if($user->isSuperAdmin == 1){
            Session::put('isSuperAdmin', true);
        }
        
        Session::put('name', $user->name);
        Session::put('id', $user->id);
        Session::put('role', $user->role);
        Session::put('isUserPusat', $data['isUserPusat']);

        if($user->role == 'admin'){
            Session::put('jabatan', 'Admin');
            return redirect('admin/dashboard');
        }
        else if($user->role=='customerservice'){
            Session::put('jabatan', 'Customer Service');
            return redirect('cs/dashboard');
        }
        else if($user->role=='kasi'){
            Session::put('jabatan', 'Kepala Subbidang');
            return redirect('kasi/dashboard');
        }
        else if($user->role=='kabid'){
            Session::put('jabatan', 'Kepala Bidang');
            return redirect('kabid/dashboard');
        }
        else if($user->role=='kapus'){
            Session::put('jabatan', 'Kepala Pusdatin');
            return redirect('kapus/dashboard');
        }
        else if($user->role=='pelaksana'){
            Session::put('jabatan', 'Pelaksana');
            return redirect('pelaksana/dashboard');
        }
        else if($user->role == 'pemohon' ){
            Session::put('jabatan', 'Pemohon');
            return redirect('/');
        }
        else if($user->buat_tiket == 1 ){
           //Session::put('jabatan', 'Pemohon');
            return redirect('/');
        }
        else{
            Alert::error('Website ini hanya bisa diakses oleh Kasubag TU!');
            return redirect('error');
        }
    }

    public function redirectLogout(){
        return redirect('/login');
    }

    public function keluar(Request $request){
        Auth::logout(); // Logout of your app
        $redirectUri = url('/'); // The URL the user is redirected to
        Cookie::queue(Cookie::forget('atrbpnkc'));
        Cookie::queue(Cookie::forget('atrbpnkcC1'));
        Cookie::queue(Cookie::forget('atrbpnkcC2'));
        return redirect(Socialite::driver('keycloak')->getLogoutUrl($redirectUri));
        //return redirect('https://logindev.atrbpn.go.id/auth/realms/internal-realm/protocol/openid-connect/logout?redirect_uri='.urlencode($redirectUri)); // Redirect to Keycloak
	}

}
