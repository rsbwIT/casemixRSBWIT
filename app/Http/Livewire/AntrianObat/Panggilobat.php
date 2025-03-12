<?php

namespace App\Http\Livewire\AntrianObat;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Services\DayListService;
use Illuminate\Support\Facades\DB;
use App\Events\PanggilObatEvent;

class Panggilobat extends Component
{
    protected $getLoket;

    // Listener untuk menerima event dari Pusher
    protected $listeners = ['updateDisplayFarmasi' => 'getDisplayFarmasi'];
    public $kd_loket_farmasi;
    public $nama_loket_farmasi;
    public $kd_display_farmasi;
    public $getAntrianObat;

    public function mount()
    {
        $this->kd_loket_farmasi = request()->kd_loket_farmasi;
        $this->kd_display_farmasi = request()->kd_display_farmasi;
        $this->getAntrianObat();
    }
    

    public function render()
    {
        $this->getAntrianObat();
        return view('livewire.antrian-obat.panggilobat');
    }


   public function getAntrianObat()
{
    $this->getAntrianObat = DB::table('antrian')
        ->leftJoin('bw_log_antrian_obat', 'bw_log_antrian_obat.nomor_antrian', '=', 'antrian.nomor_antrian') // Sesuaikan dengan kolom yang benar
        ->select(
            'antrian.id',
            'antrian.nama_pasien',
            'antrian.nomor_antrian',
            'antrian.rekam_medik',
            'antrian.tanggal',
            'antrian.created_at',
            'antrian.updated_at',
            'antrian.racik_non_racik',
            'bw_log_antrian_obat.status', // Ambil status dari log
            'antrian.no_rawat',
            'antrian.keterangan',
            'antrian.kd_loket_farmasi',
            'antrian.kd_display_farmasi'
        )
        ->whereDate('antrian.tanggal', Carbon::today())
        ->where('antrian.kd_loket_farmasi', $this->kd_loket_farmasi)
        ->where('antrian.kd_display_farmasi', $this->kd_display_farmasi)
        ->orderBy('antrian.created_at', 'asc')
        ->orderBy('antrian.nomor_antrian', 'asc')
        ->get();
}
     
    

public function handleLog($id, $nomor_antrian, $kd_loket_farmasi, $type)
{
    $status = ($type == 'ada') ? '1' : '2';

    // Update atau insert ke bw_log_antrian_obat
    DB::table('bw_log_antrian_obat')->updateOrInsert(
        ['id' => $id],
        ['nomor_antrian' => $nomor_antrian, 'kd_loket_farmasi' => $kd_loket_farmasi, 'status' => $status]
    );

    // Update status pada tabel antrian agar tetap sinkron
    DB::table('antrian')
        ->where('nomor_antrian', $nomor_antrian)
        ->update(['status' => $status]);
}

public function resetLog($id)
{
    // Ambil nomor antrian sebelum menghapus log
    $log = DB::table('bw_log_antrian_obat')->where('id', $id)->first();

    if ($log) {
        // Reset status di tabel antrian (set ke NULL atau string kosong)
        DB::table('antrian')
            ->where('nomor_antrian', $log->nomor_antrian)
            ->update(['status' => NULL]); // Bisa diganti dengan '' jika menggunakan string kosong

        // Hapus log di bw_log_antrian_obat
        DB::table('bw_log_antrian_obat')->where('id', $id)->delete();
    }
}
    
    public function panggilAntrian($nomorAntrian) {
        DB::table('antrian')
            ->where('nomor_antrian', $nomorAntrian)
            ->update(['status' => 0]);
    
        // Perbarui tampilan secara real-time
        $this->emit('refreshTable'); 
    }
    
}