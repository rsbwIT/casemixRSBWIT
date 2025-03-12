<?php

namespace App\Http\Livewire\AntrianPendaftaran;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SettingAntrian extends Component
{
    public $Pendaftaran;
    public function mount(Request $request){
        $this->getPendaftaran();
    }

    public function render() {
        $this->getPendaftaran();
        return view('livewire.antrian-pendaftaran.setting-antrian');
    }

    // GET PENDAFTARAN
    private function getPendaftaran() {
        $this->Pendaftaran = DB::table('pendaftaran')
        ->select('kd_pendaftaran', 'nama_pendaftaran')
        ->get();
    }

    // ADD PENDAFTARAN
    public $KdPendaftaran;
    public $NamaPendaftaran;
    protected $rules = [
        'KdPendaftaran' => 'required',
        'NamaPendaftaran' => 'required',
    ];
    protected $messages = [
        'KdPendaftaran.required' => 'Kode Pendaftaran harus diisi',
        'NamaPendaftaran.required' => 'Nama Pendaftaran harus diisi',
    ];
    public function addPendaftaran() {
        $this->validate();
        try {
            DB::table('pendaftaran')->insert([
                'kd_pendaftaran' => $this->KdPendaftaran,
                'nama_pendaftaran' => $this->NamaPendaftaran,
            ]);
            $this->reset(['KdPendaftaran', 'NamaPendaftaran']);
            $this->flashMessage('Pendaftaran berhasil ditambahkan!', 'success', 'check');
            $this->emit('hydrate');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat menambahkan pendaftaran.', 'danger', 'ban');
        }
    }

    // EDIT PENDAFTARAN
    public function editPendaftaran($key, $KdPendaftaran) {
        try {
            DB::table('pendaftaran')
            ->where('kd_pendaftaran', $KdPendaftaran)
            ->update($this->Pendaftaran[$key]);
            $this->flashMessage('Pendaftaran berhasil diupdate!', 'success', 'check');
            $this->emit('hydrate');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat update pendaftaran.', 'danger', 'ban');
        }
    }

    // HAPUS PENDAFTARAN
    public function deltePendaftaran($KdPendaftaran) {
        try {
            DB::table('pendaftaran')
                ->where('kd_pendaftaran', $KdPendaftaran)
                ->delete();
            $this->flashMessage('Pendaftaran berhasil dihapus!', 'warning', 'check');
            $this->emit('hydrate');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat menghapus pendaftaran.', 'danger', 'ban');
        }
    }

    // ALLERT FUNTION
    private function flashMessage($message, $color, $icon){
        Session::flash('message', $message);
        Session::flash('color', $color);
        Session::flash('icon', $icon);
    }
}
