<?php

namespace App\Http\Livewire\AntrianObat;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Services\DayListService;
use Illuminate\Support\Facades\DB;

class Displayfarmasi extends Component
{
    public $kd_display_farmasi;
    public $pusher_key;
    public $getAntrianObat;
    public $getLoket;
    // Listener untuk update tampilan real-time
    protected $listeners = ['updateDisplayFarmasi' => 'getDisplayFarmasi'];

    public function mount(Request $request)
    {
        $this->kd_display_farmasi = $request->kd_display_farmasi;
        $this->pusher_key = env('PUSHER_APP_KEY'); // Ambil dari .env
        $this->getAntrianObat();
        $this->getDisplayFarmasi();
    }

    public function render()
    {
        $this->getAntrianObat();
        $this->getDisplayFarmasi();
        return view('livewire.antrian-obat.displayfarmasi', [
            'getLoket' => $this->getLoket,
            'getAntrianObat' => $this->getAntrianObat
        ]);
    }

    public function getAntrianObat()
    {
        $this->getAntrianObat = DB::table('antrian')
        ->select('nomor_antrian', 'nama_pasien', 'tanggal')
        ->where('tanggal', date('Y-m-d'))
        ->orderBy('created_at', 'asc')
        ->first(); 
    
    // Ubah ke array agar didukung oleh Livewire
    $this->getAntrianObat = $this->getAntrianObat ? (array) $this->getAntrianObat : [];
    }

    public function getDisplayFarmasi() {
        $dayList = DayListService::getDayList();
        $hari = $dayList[date('l')];
    
        $this->getLoket = DB::table('bw_loket_farmasi')
            ->select(
                'bw_loket_farmasi.kd_loket_farmasi',
                'bw_loket_farmasi.nama_loket_farmasi',
                'bw_loket_farmasi.kd_display_farmasi',
                'bw_loket_farmasi.posisi_display_farmasi'
            )
            ->where('bw_loket_farmasi.kd_display_farmasi', $this->kd_display_farmasi)
            ->orderBy('bw_loket_farmasi.posisi_display_farmasi', 'asc')
            ->get();
    
        $this->getLoket->map(function ($item) {
            $item->getAntrianObat = DB::table('antrian')
                ->leftJoin('bw_log_antrian_obat', 'antrian.nomor_antrian', '=', 'bw_log_antrian_obat.nomor_antrian')
                ->select(
                    'antrian.nomor_antrian',
                    'antrian.nama_pasien',
                    'antrian.tanggal',
                    'antrian.created_at',
                    'antrian.updated_at',
                    'antrian.racik_non_racik',
                    'antrian.status',
                    'antrian.kd_loket_farmasi',
                    'antrian.kd_display_farmasi'
                )
                ->where('antrian.tanggal', date('Y-m-d'))
                ->where('antrian.kd_loket_farmasi', $item->kd_loket_farmasi)
                ->whereNull('bw_log_antrian_obat.status') // Hanya ambil yang statusnya kosong
                ->orderBy('antrian.created_at', 'asc')
                ->orderBy('antrian.nomor_antrian', 'asc')
                ->take(4) // Ambil 3 antrian berikutnya
                ->get();
        });
    }
    
    
}
