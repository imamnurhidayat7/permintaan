<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use DOMDocument;
use Illuminate\Support\Facades\DB;

class updateKurs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-kurs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Task untuk melakukan update kurs secara otomatis';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $// URL dari halaman web yang ingin di-crawl
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

                // Memeriksa apakah nilai jual mengandung koma
                $nilaiJual = str_replace(".", "", $nilaiJual);
                if (strpos($nilaiJual, ',') !== false) {
                    // Memisahkan angka sebelum dan sesudah koma
                    list($angkaDepan, $angkaBelakang) = explode(',', $nilaiJual);

                    // Memeriksa apakah angka belakang lebih besar atau sama dengan 5
                    $nilaiJual = ($angkaBelakang >= 50) ? $angkaDepan + 1 : $angkaDepan;
                }
                $tanggal = date('Y-m-d H:i:s', time());
                $db = DB::connection('oracle_db');
                $insert = $db->insert('INSERT INTO KKPWEB.KURSMATAUANG (TIPEMATAUANGID, KURSRUPIAH, TANGGAL, USERUPDATE, TANGGALPERUBAHAN) VALUES (?, ?, ?, ?, ?)', [$mataUang, $nilaiJual, $tanggal, 'pusdatin', $tanggal]);

            }
        } else {
            echo "Tabel kurs tidak ditemukan.";
        }
       
    }
}
