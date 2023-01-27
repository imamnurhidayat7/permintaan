<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Request as Req;

class tutupRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tutup-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Task untuk menutup request secara otomatis';

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

        $req = Req::where('status', 'Selesai')->get();
        $hours = 'aaa';
        foreach($req as $row){
            $starttimestamp = new \DateTime($row->updated_at);
            $endtimestamp = new \DateTime(date('Y-m-d H:i:s'));
            $difference = $endtimestamp->diff($starttimestamp);

            $hours = $difference->h;
            $hours = $hours + ($difference->days*24);

            if($hours >= 72){
                Req::where('id', $row->id)->update(['status'=>'Ditutup', 'tahapan'=>'Ditutup oleh system']);
            }
            
        }
        
        $this->info($hours);
       
    }
}
