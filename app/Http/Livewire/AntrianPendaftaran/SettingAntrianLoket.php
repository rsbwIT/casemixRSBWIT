<?php

namespace App\Http\Livewire\AntrianPendaftaran;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SettingAntrianLoket extends Component
{
    // DEVINISI
    public $Loket;
    public $Pendaftaran;
    protected $listeners = ['hydrate'];

    // LIFESYCLE
    public function mount(Request $request){
        $this->getLoket();
        $this->getPendaftaran();
    }
    public function hydrate()
    {
        $this->getPendaftaran();
    }
    public function render()
    {
        $this->getLoket();
        $this->getPendaftaran();
        return view('livewire.antrian-pendaftaran.setting-antrian-loket');
    }

    // GET PENDAFTARAN
    private function getPendaftaran() {
        $this->Pendaftaran = DB::table('pendaftaran')
        ->select('kd_pendaftaran', 'nama_pendaftaran')
        ->get();
    }

    // GET LOKET
    private function getLoket() {
        $this->Loket = DB::table('loket')
            ->select('loket.kd_loket', 'loket.nama_loket', 'loket.kd_pendaftaran', 'pendaftaran.nama_pendaftaran')
            ->join('pendaftaran','loket.kd_pendaftaran','=','pendaftaran.kd_pendaftaran')
            ->get();
    }

    // ADD LOKET
    public $kdLoket;
    public $NmLoket;
    public $kdPendaftaran;
    protected $rules = [
        'kdLoket' => 'required',
        'NmLoket' => 'required',
        'kdPendaftaran' => 'required',
    ];
    protected $messages = [
        'kdLoket.required' => 'Kode Loket harus diisi',
        'NmLoket.required' => 'Nama Loket harus diisi',
        'kdPendaftaran.required' => 'Pilih Lokasi Pendaftaran',
    ];
    public function addLoket()
    {
        $this->validate();
        try {
            DB::table('loket')->insert([
                'kd_loket' => $this->kdLoket,
                'nama_loket' => $this->NmLoket,
                'kd_pendaftaran' => $this->kdPendaftaran,
            ]);
            $this->reset(['kdLoket', 'NmLoket', 'kdPendaftaran']);
            $this->flashMessage('Loket berhasil ditambahkan!', 'success', 'check');
            $this->emit('mout'); // Triger ke komponen SettingPosisiDokter
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat menambahkan loket.', 'danger', 'ban');
        }
    }

    // EDIT LOKET
    public $select;
    public function editLoket($key, $kd_loket) {
       $this->select = $this->Loket[$key]['kd_pendaftaran'];
        try {
            DB::table('loket')->where('kd_loket', $kd_loket)
                ->update([
                    'nama_loket' => $this->Loket[$key]['nama_loket'],
                    'kd_pendaftaran' => $this->Loket[$key]['kd_pendaftaran'],
                ]);
            $this->flashMessage('Loket berhasil diupdate!', 'success', 'check');
            $this->emit('mout');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat update Loket.', 'danger', 'ban');
        }
    }

    // HAPUS LOKET
    public function delteLoket($kdloket) {
        try {
            DB::table('loket')
                ->where('kd_loket', $kdloket)
                ->delete();
            $this->flashMessage('Loket berhasil dihapus!', 'warning', 'check');
            $this->emit('mout');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat menghapus Loket.', 'danger', 'ban');
        }
    }

    // ALERT
    private function flashMessage($message, $color, $icon){
        Session::flash('message', $message);
        Session::flash('color', $color);
        Session::flash('icon', $icon);
    }

}
