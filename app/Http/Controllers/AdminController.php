<?php

namespace App\Http\Controllers;
use App\Models\Layanan;
use App\Models\Bidang;
use App\Models\LayananApprover;
use App\Models\LayananField;
use App\Models\Catatan;
use App\Models\User;
use App\Models\RequestServer;
use App\Models\RequestVA;
use App\Models\RequestAkses;
use App\Models\RequestEmail;
use App\Models\DetailRequestAkses;
use App\Models\DetailRequestEmail;
use App\Models\Request as Req;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Alert;
use Illuminate\Support\Facades\DB;
use File;
use DataTables;

class AdminController extends Controller{
    
    public function dashboard(){
        //echo phpinfo(); 
        // $store = DB::connection('oracle_db');
        // $data = $store->select("SELECT * FROM KKPWEB.REGISTERUSERPERTANAHAN WHERE PEGAWAIID='199702042022041001'");
        // dd($data);
        return view('admin.dashboard');
    }

    public function layanan(){
        $data['layanan'] = Layanan::with('bidang')->get();
        $data['bidang'] = Bidang::all();
        //dd($data);
        return view('admin.layanan.index')->with($data);
    }

    public function addLayanan(Request $request){
        $data = $request->all();
        //dd($data);
        $data['status'] = 2;
        $layanan = Layanan::create($data);
        return redirect('admin/layanan/edit/'.$layanan->id);
    }

    public function addField(Request $request){
        $data = $request->all();

        if($data['jenis'] == 'select'){
            $data['tipe'] = '';
        }
        elseif($data['jenis'] == 'input'){
            $data['options'] = '';
        }
        elseif($data['jenis'] == 'textarea'){
            $data['tipe'] = '';
            $data['options'] = '';
        }

        if($request->has('required')){
            $data['required'] = 1;
        }
        else{
            $data['required'] = 0;
        }

        if($data['jenis_input'] == 'update'){
            $field = LayananField::find($data['id']);
            $field->fill($data);
            $field->save();

            $div = '
            <div class="col">
                <input type="text" value="'.$field->label.'" class="form-control" disabled>
            </div>
            <div class="col-auto">
                <button type="button" class="btnEdit btn btn-md btn-success" data-id="'.$field->id.'" data-nama="'.$field->nama.'" data-label="'.$field->label.'" data-jenis="'.$field->jenis.'" data-tipe="'.$field->tipe.'" data-options="'.$field->options.'" data-required="'.$field->required.'">Edit</button>
                <button type="button" class="btnDelete btn btn-md btn-danger" data-id="'.$field->id.'">Hapus</button>
            </div>
            ';
        }
        else{
            $field = LayananField::create($data);
            $div = '<div class="row mb-2" id="'.$field->id.'">
            <div class="col">
                <input type="text" value="'.$field->label.'" class="form-control" disabled>
            </div>
            <div class="col-auto">
                <button type="button" class="btnEdit btn btn-md btn-success" data-id="'.$field->id.'" data-nama="'.$field->nama.'" data-label="'.$field->label.'" data-jenis="'.$field->jenis.'" data-tipe="'.$field->tipe.'" data-options="'.$field->options.'" data-required="'.$field->required.'">Edit</button>
                <button type="button" class="btnDelete btn btn-md btn-danger" data-id="'.$field->id.'">Hapus</button>
            </div>
            </div>';
        }

        echo $div;
    }

    public function deleteField($id){

        // $field = LayananField::find($id);
        // $field->delete();

        LayananField::where('id', $id)->update(['status_hapus'=>1]);

        return $id;
    }

    public function formLayanan(){
        $data['bidang'] = Bidang::all();
        return view('admin.layanan.add')->with($data);
    }

    public function editLayanan($id){
        $data['layanan_fields'] = LayananField::where('layanan_id', $id)->where('status_hapus', '!=', 1)->get();
        $data['layanan'] = Layanan::where('id', $id)->first();
        $data['bidang'] = Bidang::all();
        $data['pic'] = User::where('id_bidang', $data['layanan']->id_bidang)->where('role', 'kasi')->get();
        $data['pelaksana'] = User::where('id_bidang', $data['layanan']->id_bidang)->where('role', '!=', 'kasi')->where('role', '!=', 'kabid')->get();
        return view('admin.layanan.edit')->with($data);
    }

    public function updateLayanan(Request $request){
        $data = $request->all();
        //dd($data);
        $layanan = Layanan::find($data['id']);
        $layanan->fill($data);
        $layanan->save();

        // $data['nama']= [];
        // $data['tipe']= [];
        // $data['jenis']= [];
        // $data['label']= [];

        // LayananField::where('layanan_id', $data['id'])->delete();
        // for($i=0; $i<count($data['inner-group']); $i++){
        //     array_push($data['nama'], $data['inner-group'][$i]['nama']); 
        //     array_push($data['tipe'], $data['inner-group'][$i]['tipe']); 
        //     array_push($data['jenis'], $data['inner-group'][$i]['jenis']); 
        //     array_push($data['label'], $data['inner-group'][$i]['label']); 
        //     LayananField::insert([
        //         'nama' => $data['inner-group'][$i]['nama'],
        //         'tipe'=>$data['inner-group'][$i]['tipe'],
        //         'jenis'=>$data['inner-group'][$i]['jenis'],
        //         'label'=>$data['inner-group'][$i]['label'],
        //         'layanan_id'=>$layanan->id
        //     ]);
        // }

        Alert::success('Layanan berhasil diupdate!');
        return redirect('/admin/layanan');
    }

    public function uploadImage( Request $request ){
        if($request->hasFile('upload')) {
         
            //get filename with extension
            $fileNameWithExtension = $request->file('upload')->getClientOriginalName();
       
            //get filename without extension
            $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
       
            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();
       
            //filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
       
            //Upload File
            $request->file('upload')->move(public_path('uploads'), $fileNameToStore);
             
            $CKEditorFuncNum = $request->input('CKEditorFuncNum') ? $request->input('CKEditorFuncNum') : 0;
             
            if($CKEditorFuncNum > 0){
             
                $url = asset('uploads/'.$fileNameToStore); 
                $msg = 'Image successfully uploaded'; 
                $renderHtml = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                 
                // Render HTML output 
                @header('Content-type: text/html; charset=utf-8'); 
                echo $renderHtml;
                 
            } else {
             
                $url = asset('uploads/'.$fileNameToStore); 
                $msg = 'Image successfully uploaded'; 
                $renderHtml = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                return response()->json([
                    'uploaded' => '1',
                    'fileName' => $fileNameToStore,
                    'url' => $url
                ]);
            }
             
        }
    }

    public function tambahLayanan(Request $request){
        $data = $request['outer-group'][0];
        //dd($data);
        $layanan = Layanan::create($data);
        if($layanan){
            $data['nama']= [];
            $data['tipe']= [];
            $data['jenis']= [];
            $data['label']= [];

            for($i=0; $i<count($data['inner-group']); $i++){
                array_push($data['nama'], $data['inner-group'][$i]['nama']); 
                array_push($data['tipe'], $data['inner-group'][$i]['tipe']); 
                array_push($data['jenis'], $data['inner-group'][$i]['jenis']); 
                array_push($data['label'], $data['inner-group'][$i]['label']); 
                LayananField::insert([
                    'nama' => $data['inner-group'][$i]['nama'],
                    'tipe'=>$data['inner-group'][$i]['tipe'],
                    'jenis'=>$data['inner-group'][$i]['jenis'],
                    'label'=>$data['inner-group'][$i]['label'],
                    'layanan_id'=>$layanan->id
                ]);
            }
        }
        return redirect('admin/layanan');
    }

    public function showRequestList(Request $request){
        $data['request'] = Req::with('user')->with('layanan.fields')->with('meta')->get();
        $data['layanan'] = Layanan::where('status', 1)->get();
        return view('admin.request.index')->with($data);
    }

    public function requestDetail($id){
        $data['request'] = Req::with('user')->with('layanan.fields')->with('meta')->where('id', $id)->first();
        $data['catatan'] = Catatan::with('pengirim')->where('id_request', $id)->get();
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
        //DB::table('request')->where('id', $id)->delete();
        return view('admin.request.detail')->with($data);
    }

    public function updateRequest(Request $request){

        $data = $request->all();
        $req = Req::find($data['id']);
        $req->fill($data);
        $req->save();

        Alert::success('Status Request Berhasil Diubah');
        return redirect('admin/request/detail/'.$data['id']);

    }

    public function cariDataSimpeg(Request $request){
        $store = DB::connection('oracle_db');
        // $query = $store->update("UPDATE KKPWEB.KONTENAKTIF SET VERSI = '0' WHERE KONTENAKTIFID = '32c8703845994044a51dbd721dda769e' AND TIPE = 'GambarBidang' ");
        // $query = $store->insert("INSERT INTO KKPWEB.PROFILE (PROFILEID, NAMA, USERUPDATE, LASTUPDATE, VALIDSEJAK, VALIDSAMPAI, ROLENAME) VALUES ('N2908767', 'Kepala Seksi Hubungan Hukum Pertanahan', 'D3D15077B077DD1EE0400B0A9A146B69', '2013-01-22 01:40:53', '2013-01-22 01:40:53', '2013-01-22 01:40:53', 'KepalaSubSeksiHubHukumPertanahan')");
        
        // dd('ok');
        if ($request->ajax()) {
            
            $data_simpeg  = [];

            if($request->tipe == '' && $request->keyword ==''){
                return '';
            }

            if($request->tipe == 'nip'){
                $data_simpeg = $store->select("SELECT NAMA, NIPBARU AS NIP, EMAIL FROM SIMPEG_2702.PEGAWAI WHERE NIPBARU = '$request->keyword' ");
            }
            else if ($request->tipe == 'email'){
                $data_simpeg = $store->select("SELECT NAMA, NIPBARU AS NIP, EMAIL FROM SIMPEG_2702.PEGAWAI WHERE EMAIL = '$request->keyword' ");
            }
            
            return Datatables::of($data_simpeg)
                    ->addColumn('action', function($row){
                        $url = url('request/detail');
                        $btn = '<a data-email="'.$row->email.'"  data-nip="'.$row->nip.'" class="btn btnEdit btn-sm btn-success waves-effect waves-light" role="button"><i class="mdi mdi-pencil d-block font-size-16"></i> </a>';
                    
                        return $btn;
                    })
                    ->addColumn('NAMA', function($row){
                        return $row->nama;
                    })
                    ->addColumn('NIP', function($row){
                        return $row->nip;
                    })
                    ->addColumn('EMAIL', function($row){
                        return $row->email;
                    })
                    ->rawColumns(['action', 'NAMA', 'NIP', 'EMAIL'])
                    ->make(true);
        }
        return view('admin.aldi');
    }

    public function updateEmailSimpeg(Request $request){
        
        $run = DB::transaction(function() use ($request){
            $db = DB::connection('oracle_db');
            $data_user = $db->selectOne("SELECT USERID FROM PEGAWAI.PEGAWAI WHERE PEGAWAIID = '$request->nip' ");
            //dd($data_user);
            $db->update("UPDATE SIMPEG_2702.PEGAWAI SET EMAIL = '$request->email' WHERE NIPBARU = '$request->nip' ");
            $db->update("UPDATE KKPWEB.REGISTERUSERPERTANAHAN SET EMAIL = '$request->email' WHERE PEGAWAIID = '$request->nip' ");
            $db->update("UPDATE USERS SET EMAIL = '$request->email' WHERE USERID = '$data_user->userid' ");
            $db->update("UPDATE PEGAWAI SET EMAIL = '$request->email' WHERE PEGAWAIID = '$request->nip' ");
        });

        Alert::success('Berhasil merubah email');
        return redirect('aldi');
    
    }
}