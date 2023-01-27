<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function lintorKanwil(Request $request){
        if($request->username && $request->password){
            foreach($request->all() as $key => $value){
                $request->$key = $this->amankan($value);
            }
    
            if($request->username == 'pusdatin' && $request->password == 'pusdatin'){
                $store = DB::connection('oracle_db');
                $data = $store->select("SELECT KANWILID ID, KODEKANWIL KODE, NAMAKANWIL NAMA, SUM(TARGETFISIKYURIDIS) TARGET, SUM(BERKAS) BERKAS, SUM(PBT) PBT, SUM(SU) SU, NVL(SUM(PENGESAHAN),SUM(SK)) PengesahanSK, SUM(BT) BT, SUM(DI208) DI208, SUM(DI301A) DI301A FROM DASHBOARD.PROGRESLINTORKANWIL WHERE TIPEPRODUKID IS NOT NULL GROUP BY KANWILID, KODEKANWIL, NAMAKANWIL ORDER BY KODE");
    
                if($data){
                    return response()->json([
                        'status' => 200,
                        'data'=>$data
                    ]);
                }
                
            }
            else{
                return response()->json([
                    'status' => 403,
                    'response'=>'Username atau password salah'
                ]);
            }
        }
        else{
            return response()->json([
                'status' => 403,
                'response'=>'Masukkan username dan password untuk mengakses api'
            ]);
        }
        
    }

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
}
