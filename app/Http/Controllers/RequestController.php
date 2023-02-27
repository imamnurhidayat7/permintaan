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

class RequestController extends Controller{

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

    public function showRequestList(Request $request){
        
        $data['request'] = Req::with('user')->with('pelaksana')->with('layanan.fields')->with('meta')->get();
        $data['layanan'] = Layanan::where('status', 1)->get();
        $data['pelaksana'] = User::where('role', '!=', 'kasi')->where('role', '!=', 'kabid')->where('role', '!=', 'pemohon')->where('role', '!=', '')->get();
        
        if ($request->ajax()) {
            $request = Req::with('user')->with('pelaksana')->with('layanan.fields')->with('meta')->get();
            return Datatables::of($request)
                    ->addColumn('action', function($row){
                        $url = url('request/detail', $row->id);
                        $btn = '<a href="'.$url.'" class="btn btn-light waves-effect waves-light" role="button"><i class="mdi mdi-eye d-block font-size-16"></i> </a>';
                        if(Session::get('isSuperAdmin')){
                        $btn = $btn.' <a href="#" data-id="'.$row->id.'" class="btn btnReAssign btn-success waves-effect waves-light" role="button"><i class="mdi mdi-pencil d-block font-size-16" aria-hidden="true"></i> </a>';
                        }
        
                        return $btn;
                    })
                    ->addColumn('layanan', function($row){
                         return $row->layanan->layanan;
                    })
                    ->addColumn('pelaksana', function($row){
                        if($row->pelaksana != null){
                            return $row->pelaksana->name;
                        }           
                    })
                    ->addColumn('created_at', function($row){
                        // $date = convert_date('Y-m-d', $row->created_at);
                        // $time = date('Gi.s', $row->created_at);

                        return $row->created_at;
                    })
                    
                    ->filter(function ($instance) use ($request) {
                        if($request->get('status') != '') {
                            $instance->where('status', $request->get('status'));
                        }
                    })
                    ->rawColumns(['action', 'layanan', 'pelaksana', 'created_at'])
                    ->make(true);
        }

        return view('request.list-request')->with($data);
    }

    public function showRequestAssignToMe(Request $request){
        $data['layanan'] = Layanan::where('status', 1)->get();
        $data['request'] = Req::with('user')->with('layanan')->with('meta')->where('id_user_disposisi', Session::get('id'))->where('status', '!=', 'Ditutup')->where('status', '!=', 'Selesai')->get();
        $data['pelaksana'] = User::where('role', '!=', 'kasi')->where('role', '!=', 'kabid')->where('role', '!=', 'pemohon')->where('role', '!=', '')->get();
        if ($request->ajax()) {
            $request = Req::with('user')->with('layanan')->with('meta')->where('id_user_disposisi', Session::get('id'))->where('status', '!=', 'Ditutup')->where('status', '!=', 'Selesai')->get();
            return Datatables::of($request)
                    ->addColumn('action', function($row){
                        $url = url('request/detail', $row->id);
                        $btn = '<a href="'.$url.'" class="btn btn-light waves-effect waves-light" role="button"><i class="mdi mdi-eye d-block font-size-16"></i> </a>';
                    
                        return $btn;
                    })
                    ->addColumn('layanan', function($row){
                         return $row->layanan->layanan;
                    })
                    ->addColumn('pelaksana', function($row){
                        if($row->pelaksana != null){
                            return $row->pelaksana->name;
                        }           
                    })
                    ->addColumn('created_at', function($row){
                        // $date = convert_date('Y-m-d', $row->created_at);
                        // $time = date('Gi.s', $row->created_at);

                        return $row->created_at;
                    })
                    
                    ->filter(function ($instance) use ($request) {
                        if($request->get('status') != '') {
                            $instance->where('status', $request->get('status'));
                        }
                    })
                    ->rawColumns(['action', 'layanan', 'pelaksana', 'created_at'])
                    ->make(true);
        }

        return view('request.tunggakan_request')->with($data);
    }

    public function requestDetail($id){
        $data['request'] = Req::with('user')->with('layanan.fields.meta', 'meta', 'layanan.pelaksana', 'layanan.pic')->where('id', $id)->first();
        $data['catatan'] = Catatan::with('pengirim')->where('id_request', $id)->orderBy('created_at', 'desc')->get();
        $data['disposisi'] = Disposisi::with('pengirim')->with('penerima')->where('id_request', $id)->orderBy('created_at', 'desc')->get();
        $data['user'] = User::where('role', '!=', 'kasi')->where('role', '!=', 'kabid')->where('id_bidang', $data['request']->layanan->id_bidang)->where('id', '!=', Session::get('id'))->get();
        $data['riwayat'] = Riwayat::where('id_request', $id)->orderBy('id', 'asc')->get();

        if($data['request']->layanan->id == 26){
            $data['server'] = RequestServer::where('id_request', $data['request']->id)->first();
        }
        if($data['request']->layanan->id == 25){
            $data['akses'] = RequestAkses::with('userAkses')->where('id_request', $data['request']->id)->first();
        }
        if($data['request']->layanan->id == 27){
            $data['email'] = RequestEmail::with('detailRequest')->where('id_request', $data['request']->id)->first();
        }
        if($data['request']->layanan->id == 29){
            $data['va'] = RequestVA::where('id_request', $data['request']->id)->first();
        }
        if($data['request']->layanan->id == 20){
            $data['jaringan'] = RequestJaringan::where('id_request', $data['request']->id)->first();
        }
        if($data['request']->layanan->id == 28){
            $data['keamanan'] = RequestKeamananSiber::where('id_request', $data['request']->id)->first();
        }

        foreach($data['user'] as $row){
            // if($row->role == 'customerservice'){
            //     $row->jabatan = 'Customer Service';
            // }
            if($row->role == 'pelaksana'){
                $row->jabatan = 'Pelaksana';
            }
            if($row->role == 'kasi'){
                $row->jabatan = 'Kepala Subbidang';
            }
            if($row->role == 'kabid'){
                $row->jabatan = 'Kepala Bidang';
            }
            if($row->role == 'kapus'){
                $row->jabatan = 'Kepala Pusdatin';
            }
            
        }
        //dd($data);
        // if(Session::get('role') == 'pemohon'){
        //     return view('requester.request_detail')->with($data);
        // }
        return view('request.detail')->with($data);
    }

    public function requestLayanan($id){
        $data['field'] = LayananField::where('layanan_id', $id)->orderBy('id', 'asc')->get();
        $data['layanan'] = Layanan::find($id);

        if($data['layanan']->isLayananPusat == 1 && Session::get('isUserPusat') != 1){
            Alert::error('Layanan ini hanya bisa diakses oleh pegawai Kantor Pusat');
            return redirect()->back();
        }

        if($data['layanan']->status != 1){
            Alert::error('Status layanan tidak aktif');
            return redirect()->back();
        }

        $page = 'add';
        
        if($data['layanan']->page != null){
            $page = $data['layanan']->page;
        }

        return view('request.'.$page)->with($data);
    } 

    public function addRequest(Request $request){
        $data = $request->all();

        foreach($data as $key => $value){
            $data[$key] = $this->amankan($value);
        }

        $id_req = DB::transaction(function() use ($data, $request){
            $no_req = IdGenerator::generate(['table' => 'request', 'field'=>'no_req', 'length' => 12, 'prefix' =>'REQ-']);
            $layanan = Layanan::find($data['id']);
            foreach(request()->allFiles() as $row => $value){
                
                $file = uniqid().'_'.$value->getClientOriginalName();
                $value->move(public_path('uploads'), $file);
                $data[$row] = $file;
                
            }

            //dd($request->except('_token'));

            $insert_req = Req::create([
                'layanan_id' => $data['id'],
                'user_id' => Session::get('id'),
                'status' => 'Request Diajukan',
                'tahapan' => 'Menunggu Pengecekan Berkas',
                'no_req' => $no_req,
                'jenis' => $data['jenis'],
                'id_user_disposisi' => $layanan->id_pelaksana
            ]);

            if(!$insert_req){
                Alert::error('Gagal membuat request!');
                return redirect()->back();
            }
    
            $type = '';
            foreach ($data as $key => $part) {
                if($key != '_token' && $key != 'id' && $key != 'jenis'){
                    if($request->hasFile($key)){
                        $part = $data[$key];
                        $type  = 'file';
                        //dd($type);
                    }
                    if($data['id'] == 27){
                        if($key == 'nip'){
                            $nip = explode(',', $data['nip']);
                            $count1 = 0;
                            $count2 = 0;
                            foreach($nip as $row){
                                $db = DB::connection('oracle_db');
                                $check_email = $db->selectOne("SELECT EMAIL FROM SIMPEG_2702.SIAP_VW_PEGAWAI WHERE NIPBARU = '$row' ");
                                if($check_email){
                                    $status = 'Sudah Ada Email ('.$check_email->email.')';
                                    $count1++;
                                }
                                else{
                                    $status = 'Belum Ada Email';
                                    $count2++;
                                }
                                //dd($status);
                                $meta = LayananMeta::create([
                                    'nama' => 'nip',
                                    'value' => $row,
                                    'request_id' => $insert_req->id,
                                    'status' => $status
                                ]);
                            }

                            if($count1 > 0){
                                Req::where('id', $insert_req->id)->update([
                                    'keterangan'=> 'Bagi Email yang sudah terdaftar, silakan lakukan permintaan layanan reset password email!'
                                ]);
                            }

                            if($count2 <= 0){
                                Req::where('id', $insert_req->id)->update([
                                    'status'=>'Ditutup', 
                                    'tahapan'=>'Ditutup Oleh Sistem',
                                    'keterangan'=> 'Email yang diajukan sudah terdaftar sehingga tiket ditutup otomatis oleh sistem, Untuk reset password email silakan lakukan reset password <a href="https://registrasi.atrbpn.go.id">disini</a>!'
                                ]);

                                $riwayat = Riwayat::create([
                                    'id_request'=> $insert_req->id,
                                    'tahapan'=> 'Request ditutup'
                                ]);
                            }


                        }
                        else{
                            $meta = LayananMeta::create([
                                'nama' => $key,
                                'value' => $part,
                                'request_id' => $insert_req->id,
                                'type' => $type
                            ]);
                        }
                    }
                    else{
                        $meta = LayananMeta::create([
                            'nama' => $key,
                            'value' => $part,
                            'request_id' => $insert_req->id,
                            'type' => $type
                        ]);
                    }
                }
            }

            $riwayat = Riwayat::create([
                'id_request'=> $insert_req->id,
                'tahapan'=> 'Request dibuat'
            ]);
            
            $layanan = Layanan::find($data['id']);
            $cust = User::where('id', $layanan->id_pic)->get();
            $pemohon = User::where('id', Session::get('id'))->first();
    
            $pesan = $pemohon->name.' mengajukan request permintaan layanan';
            $judul = 'Request Baru';
            $url = 'request/detail/'.$insert_req->id;


    
            //event(new Notif($pesan, $judul, $url, date('Y-m-d H:i:s'), $layanan->id_pelaksana));
            $pemberitahuan = Pemberitahuan::create([
                'pesan' => $pesan,
                'judul' => $judul,
                'url' => $url,
                'id_user' => $layanan->id_pelaksana,
                'status' => 0
            ]);

            if(!$pemberitahuan){
                Alert::error('Gagal membuat request!');
                return redirect()->back();
            }

            return $insert_req->id;
            
    
        });
        
        Alert::success('Permintaan Request Berhasil!');
        return redirect('my-request/detail/'.$id_req);
    }

    public function reassignRequest(Request $request){
        $data = $request->all();
        foreach($data as $key => $value){
            $data[$key] = amankan($value);
        }

        DB::transaction(function() use ($data){
            $update = Req::find($data['id']);
            $update->fill($data);
            $update->save();

            if($update){
                Alert::success('Berhasil menugaskan request');
            }

            return '';
        });

        return redirect('request');
    }

    public function showMyRequest(Request $request){
        $data['request'] = Req::where('user_id', Session::get('id'))->get();
        $data['layanan'] = Layanan::where('status', 1)->get();
        $data['bidang'] = Bidang::all();

        if ($request->ajax()) {
            
            $request = Req::where('user_id', Session::get('id'))->get();
            return Datatables::of($request)
                    ->addColumn('action', function($row){
                        if(Session::get('role') == 'pemohon' || Session::get('role') == '') {
                            $url = url('my-request/detail', $row->id);
                        }
                        else{
                            $url = url('request/detail', $row->id);
                        }
                        
                        $btn = '<a href="'.$url.'" class="btn btn-light waves-effect waves-light" role="button"><i class="mdi mdi-eye d-block font-size-16"></i> </a>';
                    
                        return $btn;
                    })
                    ->addColumn('layanan', function($row){
                         return $row->layanan->layanan;
                    })
                    ->addColumn('pelaksana', function($row){
                        if($row->pelaksana != null){
                            return $row->pelaksana->name;
                        }           
                    })
                    ->addColumn('created_at', function($row){
                        // $date = convert_date('Y-m-d', $row->created_at);
                        // $time = date('Gi.s', $row->created_at);

                        return $row->created_at;
                    })
                    
                    ->filter(function ($instance) use ($request) {
                        if($request->get('status') != '') {
                            $instance->where('status', $request->get('status'));
                        }
                    })
                    ->rawColumns(['action', 'layanan', 'created_at', 'pelaksana'])
                    ->make(true);
        }

        if(Session::get('role') == 'pemohon' || Session::get('role') == '') {
            return view('requester.my_request')->with($data);   
        }
        else{
            
            return view('request.my_request')->with($data);
        }
        
    }

    public function detailRequest($id){
        $data['request'] = Req::with('user')->with('layanan.fields.meta')->where('id', $id)->first();
        $data['catatan'] = Catatan::with('pengirim')->where('id_request', $id)->orderBy('created_at', 'desc')->get();
        $data['riwayat'] = Riwayat::where('id_request', $id)->orderBy('id', 'asc')->get();
        if($data['request']->layanan->id == 26){
            $data['server'] = RequestServer::where('id_request', $data['request']->id)->first();
        }
        if($data['request']->layanan->id == 25){
            $data['akses'] = RequestAkses::where('id_request', $data['request']->id)->first();
        }
        if($data['request']->layanan->id == 27){
            $data['email'] = RequestEmail::with('detailRequest')->where('id_request', $data['request']->id)->first();
        }
        if($data['request']->layanan->id == 29){
            $data['va'] = RequestVA::where('id_request', $data['request']->id)->first();
        }
        if($data['request']->layanan->id == 20){
            $data['jaringan'] = RequestJaringan::where('id_request', $data['request']->id)->first();
        }
        if($data['request']->layanan->id == 28){
            $data['keamanan'] = RequestKeamananSiber::where('id_request', $data['request']->id)->first();
        }
        //dd($data);
        return view('requester.request_detail')->with($data);
    }

    public function updateRequest(Request $request){
        $data = $request->all();
        //dd($data);
        DB::transaction(function() use ($data, $request){
            foreach(request()->allFiles() as $row => $value){
                
                $file = uniqid().'_'.$value->getClientOriginalName();
                $value->move(public_path('/uploads'), $file);
                $data[$row] = $file;
                
            }


            $update = Req::find($data['request_id']);

            $layanan = Layanan::where('id', $update->layanan_id)->first();

            if($update->id_user_disposisi == $layanan->id_pic){
                $data['tahapan'] = 'Menunggu Approval';
                $data['status'] = 'Menunggu Persetujuan';
            }
            elseif($update->id_user_disposisi == $layanan->id_pelaksana){
                $data['tahapan'] = 'Menunggu Pengecekan Berkas';
                $data['status'] = 'Request Diajukan';
            }

            $update->fill($data);
            $update->save();

            $riwayat = Riwayat::create([
                'id_request'=> $update->id,
                'tahapan'=> 'Request diajukan kembali'
            ]);

            if($layanan->id == 26){
                $server = RequestServer::find($data['id']);
                $server->fill($data);
                $server->save();
            }
            if($layanan->id == 25){
                $server = RequestAkses::find($data['id']);
                $server->fill($data);
                $server->save();
            }
            else{
                $type = '';
                foreach ($request->except('_token') as $key => $part) {
                    if($key != '_token' && $key != 'id' && $key != 'jenis'){
                        if($request->hasFile($key)){
                            $part = $data[$key];
                            $type  = 'file';
                            //dd($type);
                        }
                        if($layanan->id == 27){
                            $check = is_numeric($key);
                            if($check){
                                $meta = LayananMeta::find($key);
                                if($meta){
                                    $meta->fill(['value'=>$part]);
                                    $meta->save();
                                }
                            }
                        }
                        else{
                            LayananMeta::where('request_id', $data['request_id'])->where('id', $part)->update([
                                'value' => $part,
                            ]);
                        }
                    }
                }
            }

            $pesan = 'Pemohon melakukan update request #'.$update->no_req;
            $judul = 'Pesan Baru';
            $url = 'request/detail/'.$update->id;
            
            $cust = User::where('role', 'customerservice')->get();
            
            foreach($cust as $row){
                ////event(new Notif($pesan, $judul, $url, date('Y-m-d H:i:s'), $row->id));
                Pemberitahuan::create([
                    'pesan' => $pesan,
                    'judul' => $judul,
                    'url' => $url,
                    'id_user' => $row->id,
                    'status' => 0
                ]);
            }
        });    
        Alert::success('Permintaan Request Berhasil di Update!');
        return redirect('my-request');
    }

    public function tutupRequest(Request $request){
        $data = $request->all();
        $update = Req::find($data['id']);
        $update->fill($data);
        $update->save();

        if($update){
            $riwayat = Riwayat::create([
                'id_request'=> $update->id,
                'tahapan'=> 'Request ditutup'
            ]);
            Alert::success('Request berhasil ditutup');
            return redirect('my-request/detail/'.$data['id']);
        }
    }

    public function tambahCatatan(Request $request){
        $data = $request->all();
        $return = '';
        foreach(request()->allFiles() as $row => $value){
            
            $file = uniqid().'_'.$value->getClientOriginalName();
            $value->move(public_path('/uploads'), $file);
            $data[$row] = $file;
            
        }
        
        $db = DB::transaction(function() use ($data){
            $catatan = Catatan::create($data);
            $req = Req::find($data['id_request']);
            Alert::success('Pesan Berhasil Dikirim!');

            if(Session::get('role') == 'customerservice'){
                $pesan = 'Customer Service mengirimkan balasan untuk request #'.$req->no_req;
                $judul = 'Pesan Baru';
                $url = 'my-request/detail/'.$data['id_request'];

                //Req::where('id', $data['id_request'])->update(['status'=>'Sudah Direspon']);
                $return = 'request/detail/'.$data['id_request'];
                //event(new Notif($pesan, $judul, $url, date('Y-m-d H:i:s'), $req->user_id));
                Pemberitahuan::create([
                    'pesan' => $pesan,
                    'judul' => $judul,
                    'url' => $url,
                    'id_user' => $req->user_id,
                    'status' => 0
                ]);
            }
            else{
                $pesan = 'Pemohon mengirimkan balasan untuk request #'.$req->no_req;
                $judul = 'Pesan Baru';
                $url = 'request/detail/'.$data['id_request'];
                //Req::where('id', $data['id_request'])->update(['status'=>'Dalam Proses']);
                
                $return = 'my-request/detail/'.$data['id_request'];
                $cust = User::where('role', 'customerservice')->get();
                
                foreach($cust as $row){
                    //event(new Notif($pesan, $judul, $url, date('Y-m-d H:i:s'), $row->id));
                    Pemberitahuan::create([
                        'pesan' => $pesan,
                        'judul' => $judul,
                        'url' => $url,
                        'id_user' => $row->id,
                        'status' => 0
                    ]);
                }
            }

            return compact('return');
        });
        
        return redirect($db['return']);
    }

    public function tambahDisposisi(Request $request){
        $data = $request->all();
        //dd($data);
        foreach(request()->allFiles() as $row => $value){
            
            $file = uniqid().'_'.$value->getClientOriginalName();
            $value->move(public_path('/uploads'), $file);
            $data[$row] = $file;
            
        }
        $db = DB::transaction(function() use ($data){
        //dd($data);
            $data['id_penerima'] = $data['id_user_disposisi'];
            $disposisi = Disposisi::create($data);
            $req = Req::find($data['id_request']);

            $pengirim = User::find(Session::get('id'));
            $tujuan = User::find($data['id_user_disposisi']);

            $tahapan = 'Ditugaskan ke '.$tujuan->name;
            $riwayat = Riwayat::create([
                'id_request'=> $req->id,
                'tahapan'=> $tahapan
            ]);
            $pesan = $pengirim->name.' mengirimkan request #'.$req->no_req;
            $judul = 'Penugasan Request';
            $url = 'request/detail/'.$data['id_request'];

            ////event(new Notif($pesan, $judul, $url, date('Y-m-d H:i:s'), $tujuan->id));
            Pemberitahuan::create([
                'pesan' => $pesan,
                'judul' => $judul,
                'url' => $url,
                'id_user' => $tujuan->id,
                'status' => 0
            ]);

            Alert::success('Request berhasil ditugaskan!');
            Req::where('id', $data['id_request'])->update(['tahapan'=>$tahapan, 'id_user_disposisi'=>$data['id_user_disposisi']]);
        });
        
        return redirect('request/detail/'.$data['id_request']);
           
    }

    public function ubahStatusRequest(Request $request){
        $data = $request->all();
        //dd($data);
        foreach(request()->allFiles() as $row => $value){
            
            $file = uniqid().'_'.$value->getClientOriginalName();
            $value->move(public_path('/uploads'), $file);
            $data[$row] = $file;
            
        }
        DB::transaction(function() use($data){
            $catatan = Catatan::create($data);
            $req = Req::find($data['id_request']);

            if($data['status'] == 'Sedang Diproses' && $req->status == 'Sedang Diproses'){
                $data['tahapan'] = 'Sedang Diproses';
            }
            else{
                $data['tahapan'] = 'Request '.$data['status'];
                $riwayat = Riwayat::create([
                    'id_request'=> $req->id,
                    'tahapan'=> $data['tahapan']
                ]);
            }

            $pesan = 'Request #'.$req->no_req.' '.$data['status'];
            $judul = 'Pesan Baru';
            $url = 'my-request/detail/'.$data['id_request'];

            Req::where('id', $data['id_request'])->update(['status'=>$data['status'], 'tahapan'=>$data['tahapan']]);
            $return = 'request/detail/'.$data['id_request'];
            ////event(new Notif($pesan, $judul, $url, date('Y-m-d H:i:s'), $req->user_id));
            Pemberitahuan::create([
                'pesan' => $pesan,
                'judul' => $judul,
                'url' => $url,
                'id_user' => $req->user_id,
                'status' => 0
            ]);
        });

        Alert::success('Berhasil merubah status request!');
        return redirect('request/detail/'.$data['id_request']);
    }

    public function setujuiRequest(Request $request){
        $data = $request->all();
        DB::transaction(function() use($data){
            
            $data['id_penerima'] = $data['id_user_disposisi'];
            $disposisi = Disposisi::create($data);
            
            $req = Req::find($data['id_request']);
            $layanan = Layanan::where('id', $req->layanan_id)->first();

            $pengirim = User::find(Session::get('id'));
            $tujuan = User::find($data['id_user_disposisi']);

            if($data['jenis'] == 1){
                $tahapan = 'Menunggu Persetujuan '.$tujuan->name;
                $pesan = $pengirim->name.' menugaskan request #'.$req->no_req;
                $data['approval'] = 1;
                $data['waktu_approval'] = date('Y-m-d H:i:s');
            }
            elseif($data['jenis'] == 2){
                $tahapan = 'Ditugaskan ke '.$tujuan->name;
                $pesan = $pengirim->name.' meminta persetujuan request #'.$req->no_req;
            }

            $req->fill($data);
            $req->save();


            $riwayat = Riwayat::create([
                'id_request'=> $req->id,
                'tahapan'=> $tahapan
            ]);
            
            $judul = 'Request Baru';
            $url = 'request/detail/'.$data['id_request'];

            //event(new Notif($pesan, $judul, $url, date('Y-m-d H:i:s'), $tujuan->id));
            Pemberitahuan::create([
                'pesan' => $pesan,
                'judul' => $judul,
                'url' => $url,
                'id_user' => $tujuan->id,
                'status' => 0
            ]);
        });

        Alert::success('Request berhasil disetujui!');
        return redirect('request/detail/'.$data['id_request']);

    }

    public function tolakRequest(Request $request){
        $data = $request->all();
        //dd($data);
        DB::transaction(function() use($data){
            $data['id_pengirim'] = Session::get('id');
            $catatan = Catatan::create($data);
            $req = Req::find($data['id_request']);
            $req->fill($data);
            $req->save();

            $pesan = 'Request #'.$req->no_req.' ditolak';
            $judul = 'Pesan Baru';
            $url = 'my-request/detail/'.$data['id_request'];

            $riwayat = Riwayat::create([
                'id_request'=> $req->id,
                'tahapan'=> 'Request ditolak'
            ]);

            //event(new Notif($pesan, $judul, $url, date('Y-m-d H:i:s'), $req->user_id));
            Pemberitahuan::create([
                'pesan' => $pesan,
                'judul' => $judul,
                'url' => $url,
                'id_user' => $req->user_id,
                'status' => 0
            ]);
            
        });

        Alert::success('Request berhasil ditolak!');
        return redirect('request/detail/'.$data['id_request']);
    }

    public function bukaRequest(Request $request){
        $data = $request->all();
        foreach(request()->allFiles() as $row => $value){
            
            $file = uniqid().'_'.$value->getClientOriginalName();
            $value->move(public_path('/uploads'), $file);
            $data[$row] = $file;
            
        }
        DB::transaction(function() use($data){
            $catatan = Catatan::create($data);
            $req = Req::find($data['id_request']);

            if($req->id_user_disposisi != null){
                $data['status'] = 'Sedang Diproses';
                $data['tahapan'] = 'Ditugaskan ke Pelaksana';
            }

            $pesan = 'Request #'.$req->no_req.' dibuka kembali';
            $judul = 'Pesan Baru';
            $url = 'request/detail/'.$data['id_request'];

            $riwayat = Riwayat::create([
                'id_request'=> $req->id,
                'tahapan'=> 'Request dibuka kembali'
            ]);

            Req::where('id', $data['id_request'])->update(['status'=>$data['status'], 'tahapan'=>$data['tahapan']]);
            $pelaksana = User::where('id', $req->id_user_disposisi)->first();
                
            //event(new Notif($pesan, $judul, $url, date('Y-m-d H:i:s'), $pelaksana->id));
            Pemberitahuan::create([
                'pesan' => $pesan,
                'judul' => $judul,
                'url' => $url,
                'id_user' => $pelaksana->id,
                'status' => 0
            ]);
            
        });

        Alert::success('Berhasil membuka kembali request!');
        return redirect('my-request/detail/'.$data['id_request']);
    }

    public function tambahServer(Request $request){
        $data = $request->all();
        foreach($data as $key => $value){
            $data[$key] = $this->amankan($value);
        }

        $id_req = DB::transaction(function() use ($data, $request){
        $no_req = IdGenerator::generate(['table' => 'request', 'field'=>'no_req', 'length' => 12, 'prefix' =>'REQ-']);
        $layanan = Layanan::find($data['id']);
        
        // if($layanan->isLayananPusat == 1 && Session::get('isUserPusat') != 1){
        //     Alert::error('Layanan ini hanya bisa diakses oleh pegawai Kantor Pusat');
        //     return redirect()->back();
        // }

        foreach(request()->allFiles() as $row => $value){
            
            $file = uniqid().'_'.$value->getClientOriginalName();
            $value->move(public_path('uploads'), $file);
            $data[$row] = $file;
            
        }

        //dd($request->except('_token'));

        $insert_req = Req::create([
            'layanan_id' => $data['id'],
            'user_id' => Session::get('id'),
            'status' => 'Request Diajukan',
            'tahapan' => 'Menunggu Pengecekan Berkas',
            'no_req' => $no_req,
            'jenis' => $data['jenis'],
            'id_user_disposisi' => $layanan->id_pelaksana
        ]);

        if(!$insert_req){
            Alert::error('Gagal membuat request!');
            return redirect()->back();
        }

        $data['id_request'] = $insert_req->id;

        $insert2 = RequestServer::create($data);

        //dd($insert2);

        // $field = LayananField::where('layanan_id', $data['id'])->get();

        // foreach($field as $row){

        //     if(isset($data[$row->nama])){
        //         $meta = LayananMeta::create([
        //             'nama' => $row->nama,
        //             'value' => $data[$row->nama],
        //             'request_id' => $insert_req->id,
        //         ]);

        //         if(!$meta){
        //             Alert::error('Gagal membuat request!');
        //             return redirect()->back();
        //         }
        //     }
        // }
        
        $riwayat = Riwayat::create([
            'id_request'=> $insert_req->id,
            'tahapan'=> 'Request dibuat'
        ]);
        
        $layanan = Layanan::find($data['id']);
        $cust = User::where('id', $layanan->id_pic)->get();
        $pemohon = User::where('id', Session::get('id'))->first();

        $pesan = $pemohon->name.' mengajukan request permintaan layanan';
        $judul = 'Request Baru';
        $url = 'request/detail/'.$insert_req->id;

        //event(new Notif($pesan, $judul, $url, date('Y-m-d H:i:s'), $layanan->id_pelaksana));
        $pemberitahuan = Pemberitahuan::create([
            'pesan' => $pesan,
            'judul' => $judul,
            'url' => $url,
            'id_user' => $layanan->id_pelaksana,
            'status' => 0
        ]);

        if(!$pemberitahuan){
            Alert::error('Gagal membuat request!');
            return redirect()->back();
        }

        return $insert_req->id;
        
    
        });
        
        Alert::success('Permintaan Request Berhasil!');
        return redirect('my-request/detail/'.$id_req);
    }

    public function tambahVA(Request $request){
        $data = $request->all();
        foreach($data as $key => $value){
            $data[$key] = $this->amankan($value);
        }

        $id_req = DB::transaction(function() use ($data, $request){
        $no_req = IdGenerator::generate(['table' => 'request', 'field'=>'no_req', 'length' => 12, 'prefix' =>'REQ-']);
        $layanan = Layanan::find($data['id']);
        foreach(request()->allFiles() as $row => $value){
            
            $file = uniqid().'_'.$value->getClientOriginalName();
            $value->move(public_path('uploads'), $file);
            $data[$row] = $file;
            
        }

        //dd($request->except('_token'));

        $insert_req = Req::create([
            'layanan_id' => $data['id'],
            'user_id' => Session::get('id'),
            'status' => 'Sedang Diproses',
            'tahapan' => 'Sedang Diproses',
            'no_req' => $no_req,
            'id_user_disposisi' => $layanan->id_pelaksana
        ]);

        if(!$insert_req){
            Alert::error('Gagal membuat request!');
            return redirect()->back();
        }

        $data['id_request'] = $insert_req->id;

        $insert2 = RequestVA::create($data);
        
        $riwayat = Riwayat::create([
            'id_request'=> $insert_req->id,
            'tahapan'=> 'Request dibuat'
        ]);
        
        $layanan = Layanan::find($data['id']);
        $cust = User::where('id', $layanan->id_pic)->get();
        $pemohon = User::where('id', Session::get('id'))->first();

        $pesan = $pemohon->name.' mengajukan request permintaan layanan';
        $judul = 'Request Baru';
        $url = 'request/detail/'.$insert_req->id;

        //event(new Notif($pesan, $judul, $url, date('Y-m-d H:i:s'), $layanan->id_pelaksana));
        $pemberitahuan = Pemberitahuan::create([
            'pesan' => $pesan,
            'judul' => $judul,
            'url' => $url,
            'id_user' => $layanan->id_pelaksana,
            'status' => 0
        ]);

        if(!$pemberitahuan){
            Alert::error('Gagal membuat request!');
            return redirect()->back();
        }

        return $insert_req->id;
        
    
        });
        
        Alert::success('Permintaan Request Berhasil!');
        return redirect('my-request/detail/'.$id_req);
    }

    public function tambahAkses(Request $request){
        $data = $request['outer-group'][0];

        if($data['kategori'] == 'Internal' && $data['jenis'] != 'Lainnya'){
            if($data['pegawai'] == 'ASN'){
                $nip = $data['nip'];
                $db = DB::connection('oracle_db');
                $check_email = $db->selectOne("SELECT NAMA_LENGKAP, SATKERID, EMAIL FROM SIMPEG_2702.SIAP_VW_PEGAWAI WHERE NIPBARU = '$nip' ");
                if($check_email){
                    if($check_email->email != null){
                        $validasi = explode('@', $check_email->email);
                        if($validasi[1] == 'atrbpn.go.id'){
                            $data['email'] = $check_email->email;
                            $data['nama'] = $check_email->nama_lengkap;
                        }
                        else{
                            Alert::error('NIP yang dimasukkan belum memiliki email, Silahkan lakukan permintaan email terlebih dahulu!');
                            return redirect()->back();
                        }
                    }
    
                    if($check_email->satkerid != null){
                        $satkerid = substr($check_email->satkerid, 0, 6);
                        //dd($data_simpeg);
                        $satker = $db->selectOne("SELECT SATKER FROM SIMPEG_2702.SATKER WHERE SATKERID = '$satkerid' ");
                        if($satker){
                            $data['satker'] = $satker->satker;
                        }
                    }
    
                }
                else{
                    Alert::error('NIP yang dimasukkan belum memiliki email, Silahkan lakukan permintaan email terlebih dahulu!');
                    return redirect()->back();
                }
            }
            else{
                $data['nip'] = '';
            }
        }

        $id_req = DB::transaction(function() use ($data, $request){
        
        $no_req = IdGenerator::generate(['table' => 'request', 'field'=>'no_req', 'length' => 12, 'prefix' =>'REQ-']);
        $layanan = Layanan::find($data['id']);
        
        foreach(request()->allFiles() as $row => $value){
            
            $file = uniqid().'_'.$value->getClientOriginalName();
            $value->move(public_path('uploads'), $file);
            $data[$row] = $file;
            
        }

        $insert_req = Req::create([
            'layanan_id' => $data['id'],
            'user_id' => Session::get('id'),
            'status' => 'Request Diajukan',
            'tahapan' => 'Menunggu Pengecekan Berkas',
            'no_req' => $no_req,
            'jenis' => $data['jenis'],
            'id_user_disposisi' => $layanan->id_pelaksana
        ]);

        if(!$insert_req){
            Alert::error('Gagal membuat request!');
            return redirect()->back();
        }

        $data['id_request'] = $insert_req->id;

        $akses = RequestAkses::create($data);
        $user = User::find(Session::get('id'));
        $kasi = User::find($layanan->id_pic);

        if($akses){
            if($data['jenis'] == 'VPN' || $data['jenis'] == 'Akses Jaringan'){
                if($data['kategori'] == 'Pihak Ketiga'){
                    for($i=0; $i<count($data['inner-group']); $i++){
                        DetailRequestAkses::create([
                            'nama' => $data['inner-group'][$i]['nama'],
                            'peralatan'=>$data['inner-group'][$i]['peralatan'],
                            'ip_address'=>$data['inner-group'][$i]['ip_address'],
                            'mac_address'=>$data['inner-group'][$i]['mac_address'],
                            'id_request_akses'=>$akses->id
                        ]);
                    }
                }
                else{
                    DetailRequestAkses::create([
                        'nama' => $data['nama'],
                        'email' => $data['email'],
                        'nip' => $data['nip'],
                        'satker' => $data['satker'],
                        'peralatan'=>$data['peralatan'],
                        'ip_address'=>$data['ip_address'],
                        'mac_address'=>$data['mac_address'],
                        'id_request_akses'=>$akses->id
                    ]);
                    // $data['created_at'] = convert_date(date('Y-m-d'));
                    // $data['nama'] = $user->name;
                    // $data['pegawaiid'] = $user->pegawaiid;
                    // $data['kantor'] = $user->kantor;
                    // $data['pegawaiid'] = $user->pegawaiid;
                    // $data['email'] = $user->email;
                    // $data['nama_kasi'] = $kasi->name;
                    // $data['nip_kasi'] = $kasi->pegawaiid;
                    // $data['jabatan_kasi'] = 'Kepala Subbidang Infrastruktur TI';
                    // $pdf = PDF::loadView('template.form_akses_internal', ['data' => $data])->setPaper('A4', 'potrait');;
                    // file_put_contents(public_path('dokumen').'/'.date('Y-m-d').'dokumen.pdf', $pdf->download()->getOriginalContent());
                }
            }
        }
        else{
            if($data['kategori'] == 'Pihak Ketiga'){

            }
            else{

            }
        }

        $riwayat = Riwayat::create([
            'id_request'=> $insert_req->id,
            'tahapan'=> 'Request dibuat'
        ]);
        
        $layanan = Layanan::find($data['id']);
        $cust = User::where('id', $layanan->id_pic)->get();
        $pemohon = User::where('id', Session::get('id'))->first();

        $pesan = $pemohon->name.' mengajukan request permintaan layanan';
        $judul = 'Request Baru';
        $url = 'request/detail/'.$insert_req->id;

        //event(new Notif($pesan, $judul, $url, date('Y-m-d H:i:s'), $layanan->id_pelaksana));
        $pemberitahuan = Pemberitahuan::create([
            'pesan' => $pesan,
            'judul' => $judul,
            'url' => $url,
            'id_user' => $layanan->id_pelaksana,
            'status' => 0
        ]);

        if(!$pemberitahuan){
            Alert::error('Gagal membuat request!');
            return redirect()->back();
        }

        return $insert_req->id;
        
    
        });

        Alert::success('Permintaan Request Berhasil!');
        return redirect('my-request/detail/'.$id_req);
    }

    public function tambahEmail(Request $request){
        $data = $request->all();
        foreach($data as $key => $value){
            $data[$key] = $this->amankan($value);
        }
        //dd($request->all());
        $id_req = DB::transaction(function() use ($data, $request){
        
        $no_req = IdGenerator::generate(['table' => 'request', 'field'=>'no_req', 'length' => 12, 'prefix' =>'REQ-']);
        $layanan = Layanan::find($data['id']);
        
        foreach(request()->allFiles() as $row => $value){
            
            $file = uniqid().'_'.$value->getClientOriginalName();
            $value->move(public_path('uploads'), $file);
            $data[$row] = $file;
            
        }

        $insert_req = Req::create([
            'layanan_id' => $data['id'],
            'user_id' => Session::get('id'),
            'status' => 'Sedang Diproses',
            'tahapan' => 'Sedang Diproses',
            'no_req' => $no_req,
            'jenis' => $data['jenis'],
            'id_user_disposisi' => $layanan->id_pelaksana
        ]);

        if(!$insert_req){
            Alert::error('Gagal membuat request!');
            return redirect()->back();
        }

        $riwayat = Riwayat::create([
            'id_request'=> $insert_req->id,
            'tahapan'=> 'Request dibuat'
        ]);

        $data['id_request'] = $insert_req->id;
        $insert_email = RequestEmail::create($data);

        if($insert_email){
            if($data['jenis'] == 'Pendaftaran Email Baru'){
                $nip = explode(',', $data['nip']);
                $count1 = 0;
                $count2 = 0;
                $count3 = 0;
                foreach($nip as $row){
                    $db = DB::connection('oracle_db');
                    $check_email = $db->selectOne("SELECT NAMA_LENGKAP, EMAIL FROM SIMPEG_2702.SIAP_VW_PEGAWAI WHERE NIPBARU = '$row' ");
                    if($check_email){
                        if($check_email->email != null){
                            $validasi = explode('@', $check_email->email);
                            if($validasi[1] == 'atrbpn.go.id'){
                                $status = 'Sudah Ada Email';
                                $count1++;
                            }
                            else{
                                $status = 'Belum Ada Email';
                                $count2++;
                            }
                        }
                        else{
                            $status = 'Belum Ada Email';
                            $count2++;
                        }
        
                        $email = $check_email->email;
                        $nama = $check_email->nama_lengkap;
                    }
                    else{
                        $status = 'NIP Tidak Terdaftar di SIMPEG';
                        $nama =  '';
                        $email = '';
                        $count3++;
                    }
                    
                    $detail = DetailRequestEmail::create([
                        'nama' => $nama,
                        'nip' => $row,
                        'email' => $email,
                        'status' => $status,
                        'id_request_email' => $insert_email->id
                    ]);

                    //dd($detail);
                }

                if($count1 > 0){
                    Req::where('id', $insert_req->id)->update([
                        'keterangan'=> 'Bagi Email yang sudah terdaftar, silakan lakukan permintaan layanan reset password email!'
                    ]);
                }
    
                if($count2 <= 0){
                    Req::where('id', $insert_req->id)->update([
                        'status'=>'Ditutup', 
                        'tahapan'=>'Ditutup Oleh Sistem',
                        'keterangan'=> 'NIP Pegawai yang diajukan sudah memiliki email atau NIP Pegawai tidak terdaftar di SIMPEG sehingga tiket ditutup otomatis oleh sistem, Untuk reset password email silakan lakukan reset password <a href="https://registrasi.atrbpn.go.id">disini</a>!'
                    ]);
    
                    $riwayat = Riwayat::create([
                        'id_request'=> $insert_req->id,
                        'tahapan'=> 'Request ditutup'
                    ]);
                }
            }
            else{
                $data_email = $data['email'];
                $db = DB::connection('oracle_db');
                $check_nip = $db->selectOne("SELECT NIPBARU, NAMA FROM SIMPEG_2702.PEGAWAI WHERE EMAIL = '$data_email' ");
                
                if($check_nip){
                    $status = 'Terdaftar di SIMPEG';
                    $nip = $check_nip->nipbaru;
                    $nama = $check_nip->nama;
                }
                else{
                    $status = 'Tidak Terdaftar di SIMPEG';
                    $nama = '';
                    $nip = '';

                    Req::where('id', $insert_req->id)->update([
                        'status'=>'Ditutup', 
                        'tahapan'=>'Ditutup Oleh Sistem',
                        'keterangan'=> 'Email yang dimasukkan tidak terdaftar di SIMPEG sehingga tiket ditutup otomatis oleh sistem'
                    ]);
    
                    $riwayat = Riwayat::create([
                        'id_request'=> $insert_req->id,
                        'tahapan'=> 'Request ditutup'
                    ]);
                }

                $detail = DetailRequestEmail::create([
                    'nama' => $nama,
                    'nip' => $nip,
                    'email' => $data_email,
                    'status' => $status,
                    'id_request_email' => $insert_email->id
                ]);
            }

            

        }
        
        $layanan = Layanan::find($data['id']);
        $cust = User::where('id', $layanan->id_pic)->get();
        $pemohon = User::where('id', Session::get('id'))->first();

        $pesan = $pemohon->name.' mengajukan request permintaan layanan';
        $judul = 'Request Baru';
        $url = 'request/detail/'.$insert_req->id;

        //event(new Notif($pesan, $judul, $url, date('Y-m-d H:i:s'), $layanan->id_pelaksana));
        $pemberitahuan = Pemberitahuan::create([
            'pesan' => $pesan,
            'judul' => $judul,
            'url' => $url,
            'id_user' => $layanan->id_pelaksana,
            'status' => 0
        ]);

        if(!$pemberitahuan){
            Alert::error('Gagal membuat request!');
            return redirect()->back();
        }

        return $insert_req->id;
        
        });

        //Alert::success('Permintaan Request Berhasil!');
        return redirect('my-request/detail/'.$id_req);
    }

    public function tambahEmailUser(Request $request){
        $data = $request->all();
       
        foreach($data as $key => $value){
            $data[$key] = $this->amankan($value);
        }

        $email = $data['email'];
        $nip = $data['nip'];
        $data['status'] = 'Sudah Ada Email';

        $db = DB::connection('oracle_db');
        $update = $db->update("UPDATE SIMPEG_2702.PEGAWAI SET EMAIL = '$email' WHERE NIPBARU = '$nip' ");

        //dd($data);

        if($update){
            $updateMeta = DetailRequestEmail::find($data['id']);
            $updateMeta->fill($data);
            $updateMeta->save();
        }
        else{
            Alert::error('NIP tidak terdaftar di SIMPEG');
            return redirect()->back();
        }

        Alert::success('Berhasil menambahkan email di Simpeg!');
        return redirect('request/detail/'.$data['id_request']);


    }

    public function tambahJaringan(Request $request){
        $data = $request->all();
        foreach($data as $key => $value){
            $data[$key] = $this->amankan($value);
        }

        $id_req = DB::transaction(function() use ($data, $request){
        $no_req = IdGenerator::generate(['table' => 'request', 'field'=>'no_req', 'length' => 12, 'prefix' =>'REQ-']);
        $layanan = Layanan::find($data['id']);
        foreach(request()->allFiles() as $row => $value){
            
            $file = uniqid().'_'.$value->getClientOriginalName();
            $value->move(public_path('uploads'), $file);
            $data[$row] = $file;
            
        }

        ///dd($request->except('_token'));

        $insert_req = Req::create([
            'layanan_id' => $data['id'],
            'user_id' => Session::get('id'),
            'status' => 'Request Diajukan',
            'tahapan' => 'Menunggu Pengecekan Berkas',
            'no_req' => $no_req,
            'jenis' => $data['jenis'],
            'id_user_disposisi' => $layanan->id_pelaksana
        ]);

        if(!$insert_req){
            Alert::error('Gagal membuat request!');
            return redirect()->back();
        }

        $data['id_request'] = $insert_req->id;

        $insert2 = RequestJaringan::create($data);
        
        $riwayat = Riwayat::create([
            'id_request'=> $insert_req->id,
            'tahapan'=> 'Request dibuat'
        ]);
        
        $layanan = Layanan::find($data['id']);
        $cust = User::where('id', $layanan->id_pic)->get();
        $pemohon = User::where('id', Session::get('id'))->first();

        $pesan = $pemohon->name.' mengajukan request permintaan layanan';
        $judul = 'Request Baru';
        $url = 'request/detail/'.$insert_req->id;

        //event(new Notif($pesan, $judul, $url, date('Y-m-d H:i:s'), $layanan->id_pelaksana));
        $pemberitahuan = Pemberitahuan::create([
            'pesan' => $pesan,
            'judul' => $judul,
            'url' => $url,
            'id_user' => $layanan->id_pelaksana,
            'status' => 0
        ]);

        if(!$pemberitahuan){
            Alert::error('Gagal membuat request!');
            return redirect()->back();
        }

        return $insert_req->id;
        
    
        });
        
        Alert::success('Permintaan Request Berhasil!');
        return redirect('my-request/detail/'.$id_req);
    }

    public function tambahKeamananSiber(Request $request){
        $data = $request->all();
        foreach($data as $key => $value){
            $data[$key] = $this->amankan($value);
        }

        $id_req = DB::transaction(function() use ($data, $request){
        $no_req = IdGenerator::generate(['table' => 'request', 'field'=>'no_req', 'length' => 12, 'prefix' =>'REQ-']);
        $layanan = Layanan::find($data['id']);
        foreach(request()->allFiles() as $row => $value){
            
            $file = uniqid().'_'.$value->getClientOriginalName();
            $value->move(public_path('uploads'), $file);
            $data[$row] = $file;
            
        }

        ///dd($request->except('_token'));

        $insert_req = Req::create([
            'layanan_id' => $data['id'],
            'user_id' => Session::get('id'),
            'status' => 'Request Diajukan',
            'tahapan' => 'Menunggu Pengecekan Berkas',
            'no_req' => $no_req,
            'jenis' => $data['jenis'],
            'id_user_disposisi' => $layanan->id_pelaksana
        ]);

        if(!$insert_req){
            Alert::error('Gagal membuat request!');
            return redirect()->back();
        }

        $data['id_request'] = $insert_req->id;

        $insert2 = RequestKeamananSiber::create($data);
        
        $riwayat = Riwayat::create([
            'id_request'=> $insert_req->id,
            'tahapan'=> 'Request dibuat'
        ]);
        
        $layanan = Layanan::find($data['id']);
        $cust = User::where('id', $layanan->id_pic)->get();
        $pemohon = User::where('id', Session::get('id'))->first();

        $pesan = $pemohon->name.' mengajukan request permintaan layanan';
        $judul = 'Request Baru';
        $url = 'request/detail/'.$insert_req->id;

        //event(new Notif($pesan, $judul, $url, date('Y-m-d H:i:s'), $layanan->id_pelaksana));
        $pemberitahuan = Pemberitahuan::create([
            'pesan' => $pesan,
            'judul' => $judul,
            'url' => $url,
            'id_user' => $layanan->id_pelaksana,
            'status' => 0
        ]);

        if(!$pemberitahuan){
            Alert::error('Gagal membuat request!');
            return redirect()->back();
        }

        return $insert_req->id;
        
    
        });
        
        Alert::success('Permintaan Request Berhasil!');
        return redirect('my-request/detail/'.$id_req);
    }
}

?>