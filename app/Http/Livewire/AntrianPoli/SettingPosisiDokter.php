<?php

namespace App\Http\Livewire\AntrianPoli;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SettingPosisiDokter extends Component
{
    protected $listeners = ['mount'];

    public function mount() {
        $this->getListDokter();
        $this->getPoli();
    }
    public function render()
    {
        $this->getListDokter();
        $this->getPoli();
        return view('livewire.antrian-poli.setting-posisi-dokter');
    }
    // ALERT
    private function flashMessage($message, $color, $icon){
        Session::flash('message', $message);
        Session::flash('color', $color);
        Session::flash('icon', $icon);
    }

    // GET POLI
    public $getPoli;
    public function getPoli() {
        $this->getPoli = DB::table('bw_ruang_poli')
        ->select('bw_ruang_poli.kd_ruang_poli',
            'bw_ruang_poli.nama_ruang_poli',
            'bw_ruang_poli.kd_display',
            'bw_ruang_poli.posisi_display_poli')
        ->get();
    }

     // GET LIST DOKTER
     public $getListDokter;
     private function getListDokter() {
        $this->getListDokter = DB::table('dokter')
        ->select('bw_ruangpoli_dokter.kd_ruang_poli', 'bw_ruang_poli.nama_ruang_poli', 'dokter.kd_dokter', 'dokter.nm_dokter')
        ->leftJoin('bw_ruangpoli_dokter','dokter.kd_dokter','=','bw_ruangpoli_dokter.kd_dokter')
        ->leftJoin('bw_ruang_poli','bw_ruangpoli_dokter.kd_ruang_poli','=','bw_ruang_poli.kd_ruang_poli')
        ->where('dokter.status','=','1')
        ->get();
    }

    public function editPoliDokter($key, $kd_dokter, $nm_dokter) {
        try {
            DB::table('bw_ruangpoli_dokter')->updateOrInsert(
                ['kd_dokter' => $kd_dokter],
                ['nama_dokter' => $nm_dokter, 'kd_ruang_poli' => $this->getListDokter[$key]['kd_ruang_poli']]
            );
            $this->flashMessage('Posisi Dokter Dipindahkan Ke '.$this->getListDokter[$key]['kd_ruang_poli'], 'success', 'check');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat menghapus pendaftaran.', 'danger', 'ban');
        }
    }
}
