<?php

namespace App\Http\Controllers;
use App\Models\Layanan;
use App\Models\Bidang;
use App\Models\Riwayat;
use App\Models\LayananApprover;
use App\Models\LayananField;
use App\Models\LayananMeta;
use App\Models\Request as Req;
use App\Models\RequestServer;
use App\Models\RequestVA;
use App\Models\RequestAkses;
use App\Models\RequestJaringan;
use App\Models\RequestKeamananSiber;
use App\Models\RequestEmail;
use App\Models\DetailRequestAkses;
use App\Models\DetailRequestEmail;
use App\Models\Catatan;
use App\Models\Disposisi;
use App\Models\User;
use DataTables;
use App\Models\Pemberitahuan;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Alert;
use Illuminate\Support\Facades\DB;
use File;
use App\Events\Notification as Notif;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use PDF;

class LaporanController extends Controller{

    public function laporan(Request $request){
        $data['request'] = Req::all();

        // foreach($data['request'] as $row){
        //     $user = DB::table('users')->select('kantor')->where('id', $row->user_id)->first();
        //     Req::where('id', $row->id)->update(['kantor'=>$user->kantor]);
        // }

        $data['ditutup'] = Req::where('status', 'Ditutup')->count();
        $data['selesai'] = Req::where('status', 'Selesai')->count();
        $data['proses'] = Req::where('status', 'Sedang Diproses')->count();
        $data['menunggu'] = Req::where('status', 'Menunggu Persetujuan')->count();
        $data['email'] = Req::where('layanan_id', '27')->count();
        $data['akses'] = Req::where('layanan_id', '25')->count();
        $data['va'] = Req::where('layanan_id', '29')->count();
        $data['server'] = Req::where('layanan_id', '26')->count();
        $data2 = Req::select('kantor', 
                        DB::raw('COUNT(request.id) as total_req'), \
                        DB::raw("(SELECT COUNT(*) as akses FROM request r WHERE r.kantor = request.kantor AND r.layanan_id = '25') "),
                        DB::raw("(SELECT COUNT(*) as server FROM request r WHERE r.kantor = request.kantor AND r.layanan_id = '26') "),
                        DB::raw("(SELECT COUNT(*) as email FROM request r WHERE r.kantor = request.kantor AND r.layanan_id = '27') "),
                        DB::raw("(SELECT COUNT(*) as va FROM request r WHERE r.kantor = request.kantor AND r.layanan_id = '29') ")
                        )
                        ->groupBy('kantor')
                        ->get();

        //dd($data);
        if ($request->ajax()) {
            return Datatables::of($data2)
            
            ->make(true);
        }
        return view('admin.laporan')->with($data);
    }
}