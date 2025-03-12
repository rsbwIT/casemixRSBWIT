<?php

namespace App\Http\Livewire\AntrianObat;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SettingDisplayObat extends Component
{
    public function mount() {
        $this->getDisplay();
    }
    public function render()
    {
        $this->getDisplay();
        return view('livewire.antrian-obat.setting-display-obat');
    }

    // ALLERT FUNTION
    private function flashMessage($message, $color, $icon){
        Session::flash('message', $message);
        Session::flash('color', $color);
        Session::flash('icon', $icon);
    }

    // GET Display Farmasi
    public $getDisplay;
    private function getDisplay() {
        $this->getDisplay = DB::table('bw_display_farmasi')
        ->select('bw_display_farmasi.kd_display_farmasi', 'bw_display_farmasi.nama_display_farmasi')
        ->get();
    }

    // ADD Display Farmasi
    public $kd_display_farmasi;
    public $nama_display_farmasi;
    protected $rules = [
        'kd_display_farmasi' => 'required',
        'nama_display_farmasi' => 'required',
    ];
    protected $messages = [
        'kd_display_farmasi.required' => 'Kode Display harus diisi',
        'nama_display_farmasi.required' => 'Nama Display harus diisi',
    ];
    public function addDisplay() {
        $this->validate();
        try {
            DB::table('bw_display_farmasi')->insert([
                'kd_display_farmasi' => $this->kd_display_farmasi,
                'nama_display_farmasi' => $this->nama_display_farmasi,
            ]);
            $this->reset(['kd_display_farmasi', 'nama_display_farmasi']);
            $this->flashMessage('Display berhasil ditambahkan!', 'success', 'check');
            $this->emit('mount');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat menambahkan display farmasi.', 'danger', 'ban');
        }
    }

     // EDIT Display Farmasi
     public function editDisplay($key, $kd_display_farmasi) {
        try {
            DB::table('bw_display_farmasi')
            ->where('kd_display_farmasi', $kd_display_farmasi)
            ->update($this->getDisplay[$key]);
            $this->flashMessage('Display berhasil diupdate!', 'success', 'check');
            $this->emit('mount');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat update display farmasi.', 'danger', 'ban');
        }
    }
    // HAPUS Display Farmasi
    public function deleteDisplay($key ,$kd_display_farmasi) {
        try {
            DB::table('bw_display_farmasi')
                ->where('kd_display_farmasi', $kd_display_farmasi)
                ->delete();
            $this->flashMessage('Display berhasil dihapus!', 'warning', 'check');
            $this->emit('mount');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat menghapus display farmasi.', 'danger', 'ban');
        }
    }

}
