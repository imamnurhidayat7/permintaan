<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DOMDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;


class KursController extends Controller
{
    // Metode untuk melakukan crawling data kurs dari halaman web
    public function crawlKursBI()
    {
        // URL dari halaman web yang ingin di-crawl
        $url = 'https://www.bi.go.id/id/statistik/informasi-kurs/transaksi-bi/default.aspx';

        // Inisialisasi array untuk menyimpan data kurs
        $dataKurs = array();

        // Mendapatkan halaman web menggunakan cURL
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($curl);
        curl_close($curl);

        // Membuat objek DOMDocument dan menghilangkan pesan kesalahan
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML($html);
        libxml_clear_errors();

        // Mengambil tabel kurs menggunakan ID
        $tabelKurs = $dom->getElementById('ctl00_PlaceHolderMain_g_6c89d4ad_107f_437d_bd54_8fda17b556bf_ctl00_GridView1');

        //dd($dom);

        // Memeriksa apakah tabel kurs ditemukan
        if ($tabelKurs) {
            // Mengambil semua baris dalam tabel
            $baris = $tabelKurs->getElementsByTagName('tr');

            // Iterasi melalui setiap baris, mulai dari baris kedua (indeks 1) karena baris pertama adalah header
            for ($i = 1; $i < $baris->length; $i++) {
                $kolom = $baris->item($i)->getElementsByTagName('td');

                // Mengambil data dari kolom-kolom tertentu (misalnya, mata uang, nilai beli, nilai jual)
                $mataUang = $kolom->item(0)->nodeValue;
                $nilaiBeli = $kolom->item(1)->nodeValue;
                $nilaiJual = $kolom->item(2)->nodeValue;

                // Menambahkan data kurs ke array dataKurs
                $dataKurs[] = array(
                    'mata_uang' => trim($mataUang),
                    'nilai_beli' => trim($nilaiBeli),
                    'nilai_jual' => trim($nilaiJual)
                );
            }
        } else {
            echo "Tabel kurs tidak ditemukan.";
        }

        return $dataKurs;
    }

    // Metode untuk menampilkan data kurs jika berhasil diambil
    public function showKurs()
    {
        // Panggil fungsi crawlKursBI
        $dataKurs = $this->crawlKursBI();

        // Cetak data kurs jika berhasil diambil
        if (!empty($dataKurs)) {
            foreach ($dataKurs as $data) {
                // Memeriksa apakah nilai jual mengandung koma
                $data['nilai_jual'] = str_replace(".", "", $data['nilai_jual']);
                if (strpos($data['nilai_jual'], ',') !== false) {
                    // Memisahkan angka sebelum dan sesudah koma
                    list($angkaDepan, $angkaBelakang) = explode(',', $data['nilai_jual']);

                    // Memeriksa apakah angka belakang lebih besar atau sama dengan 5
                    $data['nilai_jual'] = ($angkaBelakang >= 50) ? $angkaDepan + 1 : $angkaDepan;
                }
                $tanggal = date('Y-m-d H:i:s', time());
                $db = DB::connection('oracle_db');
                $insert = $db->insert('INSERT INTO KKPWEB.KURSMATAUANG (TIPEMATAUANGID, KURSRUPIAH, TANGGAL, USERUPDATE, TANGGALPERUBAHAN) VALUES (?, ?, ?, ?, ?)', [$data['mata_uang'], $data['nilai_jual'], $tanggal, 'pusdatin', $tanggal]);
                //echo "Mata Uang: " . $data['mata_uang'] . ", Nilai Beli: " . $data['nilai_beli'] . ", Nilai Jual: " . $data['nilai_jual'] . "<br>";
            }
        }

        echo "OK";
    }

    public function cekBPJS(Request $request){
        // $nik = $request->nik;
        if(!$request->nik || !$request->berkasid){
            $output = [
                'success' => false,
                'message' => 'Masih ada data yang belum lengkap! Silahkan hubungi administrator!',
            ];
            return response()->json($output);
        }
        $data['nik'] = $request->nik;
        $data['berkasid'] = $request->berkasid;

        $data['timestamp'] = time();
        $data['consid'] = '1129';
        $data['secretkey'] = '3vT38A9098';
        $data['user_key'] = 'b08dd7b672910e09f9ccdce7ee1933a4';
        // Menghitung signature menggunakan HMAC-SHA256
        $data['signature'] = hash_hmac('sha256', $data['consid'] . '&' . $data['timestamp'], $data['secretkey'], true);

        // Mengonversi signature ke dalam format Base64
        $data['signature'] = base64_encode($data['signature']);
        $output = false;
        $status = '';
        $pesan = '';
        
        try{
            $response = Http::withHeaders([
                'x-cons-id' => $data['consid'],
                'x-timestamp' => $data['timestamp'],
                'x-signature' => $data['signature'],
                'user_key' => $data['user_key']
            ])->get('https://apijkn-dev.bpjs-kesehatan.go.id/infopeserta_dev/api/nik/'.$data['nik']);

            // Mendekodekan respons JSON menjadi array asosiatif
            $responseData = json_decode($response->body(), true);

            // Mendapatkan nilai variabel 'response' dari array respons
            $responseValue = $responseData['response'];
            
            if($responseValue != null){
                    $encrypt_method = 'AES-256-CBC';
                    $decrypt_key = $data['consid'].$data['secretkey'].$data['timestamp'];; // Isi dengan kunci Anda

                    
                    $data['key'] = hash('sha256', $decrypt_key, true);
                    $data['iv'] = substr(hash('sha256', $decrypt_key, true), 0, 16);

                    $decryptedData = openssl_decrypt(base64_decode($responseValue), $encrypt_method, $data['key'], OPENSSL_RAW_DATA, $data['iv']);
                    if ($decryptedData === false) {
                        // Penanganan kesalahan dekripsi
                        $error = openssl_error_string(); // Mendapatkan pesan kesalahan OpenSSL
                    } else {
                        $hasil = json_decode(\LZCompressor\LZString::decompressFromEncodedURIComponent($decryptedData));
                        $status = 'T';
                        $pesan =  $hasil->ketstatuspeserta;

                        $output = [
                            'success' => true,
                            'message' => 'berhasil',
                            'status' => $pesan
                        ];
                    }
            }
            else{
                $status = "F";
                $pesan =  'Data Tidak Ditemukan';
                $output = [
                    'success' => false,
                    'message' => $pesan,
                ];
            }


        }
        catch(\Exception $e){
            $status = "F";
            $pesan =  'Terjadi Kesalahan pada Service BPJS';
            $output = [
                'success' => false,
                'message' => $pesan,
            ];
        }

        $tanggal = date('Y-m-d H:i:s', time());
        $db = DB::connection('oracle_db');
        $getid = $db->select("SELECT sys_guid() as guid FROM DUAL");
        $guid = $getid[0]->guid;
        //var_dump(bin2hex($guid));
        $insert = $db->insert("INSERT INTO BPJSSERVICELOG (BPJSSERVICELOGID, NIK, STATUS, TANGGAL, PESAN, BERKASID) VALUES (?, ?, ?, ?, ?, ?)", [bin2hex($guid), $data['nik'], $status, $tanggal, $pesan, $data['berkasid']]);

        return response()->json($output);
        
    }

    public function cekBPJSNoka(Request $request){
        // $nik = $request->nik;
        if(!$request->noka || !$request->berkasid){
            $output = [
                'success' => false,
                'message' => 'Masih ada data yang belum lengkap! Silahkan hubungi administrator!',
            ];
            return response()->json($output);
        }
        $data['noka'] = $request->noka;
        $data['berkasid'] = $request->berkasid;

        $data['timestamp'] = time();
        $data['consid'] = '1129';
        $data['secretkey'] = '3vT38A9098';
        $data['user_key'] = 'b08dd7b672910e09f9ccdce7ee1933a4';
        // Menghitung signature menggunakan HMAC-SHA256
        $data['signature'] = hash_hmac('sha256', $data['consid'] . '&' . $data['timestamp'], $data['secretkey'], true);

        // Mengonversi signature ke dalam format Base64
        $data['signature'] = base64_encode($data['signature']);
        $output = false;
        $status = '';
        $pesan = '';
        
        try{
            $response = Http::withHeaders([
                'x-cons-id' => $data['consid'],
                'x-timestamp' => $data['timestamp'],
                'x-signature' => $data['signature'],
                'user_key' => $data['user_key']
            ])->get('https://apijkn-dev.bpjs-kesehatan.go.id/infopeserta_dev/api/noka/'.$data['noka']);

            // Mendekodekan respons JSON menjadi array asosiatif
            $responseData = json_decode($response->body(), true);

            // Mendapatkan nilai variabel 'response' dari array respons
            $responseValue = $responseData['response'];
            
            if($responseValue != null){
                    $encrypt_method = 'AES-256-CBC';
                    $decrypt_key = $data['consid'].$data['secretkey'].$data['timestamp'];; // Isi dengan kunci Anda

                    
                    $data['key'] = hash('sha256', $decrypt_key, true);
                    $data['iv'] = substr(hash('sha256', $decrypt_key, true), 0, 16);

                    $decryptedData = openssl_decrypt(base64_decode($responseValue), $encrypt_method, $data['key'], OPENSSL_RAW_DATA, $data['iv']);
                    if ($decryptedData === false) {
                        // Penanganan kesalahan dekripsi
                        $error = openssl_error_string(); // Mendapatkan pesan kesalahan OpenSSL
                    } else {
                        $hasil = json_decode(\LZCompressor\LZString::decompressFromEncodedURIComponent($decryptedData));
                        $status = 'T';
                        $pesan =  $hasil->ketstatuspeserta;

                        $output = [
                            'success' => true,
                            'message' => 'berhasil',
                            'status' => $pesan
                        ];
                    }
            }
            else{
                $status = "F";
                $pesan =  'Data Tidak Ditemukan';
                $output = [
                    'success' => false,
                    'message' => $pesan,
                ];
            }


        }
        catch(\Exception $e){
            $status = "F";
            $pesan =  'Terjadi Kesalahan pada Service BPJS';
            $output = [
                'success' => false,
                'message' => $pesan,
            ];
        }

        $tanggal = date('Y-m-d H:i:s', time());
        $db = DB::connection('oracle_db');
        $getid = $db->select("SELECT sys_guid() as guid FROM DUAL");
        $guid = $getid[0]->guid;
        //var_dump(bin2hex($guid));
        $insert = $db->insert("INSERT INTO BPJSSERVICELOG (BPJSSERVICELOGID, NIK, STATUS, TANGGAL, PESAN, BERKASID) VALUES (?, ?, ?, ?, ?, ?)", [bin2hex($guid), $data['noka'], $status, $tanggal, $pesan, $data['berkasid']]);

        return response()->json($output);
        
    }

    function encrypt() {
        $key = utf8_encode('4456445677897789'); // assuming AppConfig::shared() is a function to get shared instance
        $iv = utf8_encode('1234567812345678'); // assuming AppConfig::shared() is a function to get shared instance
    
        // Pad the key if it's less than 16 bytes (128 bits)
        if (strlen($key) < 16) {
            $key = str_pad($key, 16, "\0");
        }
    
        // Pad the IV if it's less than 16 bytes (128 bits)
        if (strlen($iv) < 16) {
            $iv = str_pad($iv, 16, "\0");
        }
    
        $encryptedData = openssl_encrypt('93975C008CD1EA62E040A8C010017FFF', 'aes-128-cbc', $key, OPENSSL_RAW_DATA, $iv);
    
        if ($encryptedData === false) {
            // Handle error
            return null;
        }
    
        // Encode the encrypted data using base64
        $result = base64_encode($encryptedData);

        dd($result);
    
        return $result;
    }

    public function ratingIntan(){
        $data['appid'] = 'F5A9B9E681670858E053051D0B0AA2D4';
        $data['rating'] = $this->getRating($data['appid']);
        //dd($data);
        return view('layouts.rating')->with($data);
    }

    public function ratingHTEL(){
        $data['appid'] = 'F5A9B9E681670858E053051D0B0AA2D3';
        $data['rating'] = $this->getRating($data['appid']);
        //dd($data);
        return view('layouts.rating')->with($data);
    }

    public function setRating(Request $request){
        $db = DB::connection('oracle_db');
        $data = $request->all();
        $getid = $db->select("SELECT sys_guid() as guid FROM DUAL");
        $guid = $getid[0]->guid;
        $tanggal = date('Y-m-d H:i:s', time());
        //var_dump(bin2hex($guid));
        $insert = $db->insert("INSERT INTO KKPWEB.TBLAPPRATING (APPRATINGID, APPID, USERID, RATING, UPDTIME, UPDUSER, STATUS) VALUES (?, ?, ?, ?, ?, ?, ?)", [bin2hex($guid), $data['appid'], 'null', $data['rating'], $tanggal, 'null', 'A' ]);

        $rating = $this->getRating($data['appid']);
        return $rating;

    }

    public function getRating($appid){
        $db = DB::connection('oracle_db');
        $query = $db->selectOne("SELECT AVG(RATING) as rating, count(RATING) as jumlah FROM KKPWEB.TBLAPPRATING WHERE APPID = '$appid' ");

        return $query;
    } 
    
}
