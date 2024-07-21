<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Models\Pemeliharaan;
use Auth;
use DB;
use Carbon\Carbon;

class Notification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show Notification';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date_now = date('Y-m-d');
        $pemeliharaan = Pemeliharaan::where('jadwal', $date_now)->where('status','Menunggu')->get();
        foreach ($pemeliharaan as $key => $value) {
            $updatePemeliharaan = Pemeliharaan::find($value->id);
            $updatePemeliharaan->notification = 1;
            $updatePemeliharaan->save();

            Log::info('Notification Success');
        }
        Log::info('Cronjob berhasil dijalankan');
    }
}
