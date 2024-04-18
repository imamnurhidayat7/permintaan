<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DOMDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use App\Models\Attendance;
use Zoom;
use Alert;


class ZoomController extends Controller
{

    public function index(){
        $db = DB::connection('oracle_db');
        //$data['kantor'] = $db->select('SELECT kantorid, nama FROM WILAYAH.KANTOR WHERE VALIDSAMPAI IS NULL');
        $data['meeting_id'] = '86746984952';

        return view('attendance')->with($data);
        //dd($kantor);
    }

    public function absen(Request $request){
        $data = $request->all();
        $data['meeting_id'] = '86746984952';
        $data['nama'] = $data['first_name'].' '.$data['last_name'];
        $data['auto_approve'] = true;
        //dd($data);
        $cek_kantor = Attendance::where('kantor', $data['kantor'])->first();
       
        if($cek_kantor){
            Alert::error($data['kantor'].' Sudah Mendaftar Sebelumnya');
            return redirect()->back();
        }

        $add = Zoom::addUserToMeeting($data);
        
        if($add['status']){
            Attendance::create($data);

            //return redirect()->away($add['data']['join_url']);
            Alert::success('Pendaftaran Berhasil', 'Silahkan Cek Email untuk Jadwal dan Link Zoom');
            return redirect()->back();
        }
        else{
            Alert::error('Email sudah didaftarkan terlalu sering!');
            return redirect()->back();
        }
        

    }

}