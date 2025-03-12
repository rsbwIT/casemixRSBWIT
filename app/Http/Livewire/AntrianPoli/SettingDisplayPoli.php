<?php

namespace App\Http\Livewire\AntrianPoli;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SettingDisplayPoli extends Component
{
    public function mount() {
        $this->getDisplay();
    }
    public function render()
    {
        $this->getDisplay();
        return view('livewire.antrian-poli.setting-display-poli');
    }

    // ALLERT FUNTION
    private function flashMessage($message, $color, $icon){
        Session::flash('message', $message);
        Session::flash('color', $color);
        Session::flash('icon', $icon);
    }

    // GET PENDAFTARAN
    public $getDisplay;
    private function getDisplay() {
        $this->getDisplay = DB::table('bw_display_poli')
        ->select('bw_display_poli.kd_display', 'bw_display_poli.nama_display')
        ->get();
    }

    // ADD PENDAFTARAN
    public $kd_display;
    public $nama_display;
    protected $rules = [
        'kd_display' => 'required',
        'nama_display' => 'required',
    ];
    protected $messages = [
        'kd_display.required' => 'Kode Display harus diisi',
        'nama_display.required' => 'Nama Display harus diisi',
    ];
    public function addDisplay() {
        $this->validate();
        try {
            DB::table('bw_display_poli')->insert([
                'kd_display' => $this->kd_display,
                'nama_display' => $this->nama_display,
            ]);
            $this->reset(['kd_display', 'nama_display']);
            $this->flashMessage('Display berhasil ditambahkan!', 'success', 'check');
            $this->emit('mount');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat menambahkan display poli.', 'danger', 'ban');
        }
    }

     // EDIT PENDAFTARAN
     public function editDisplay($key, $kd_display) {
        try {
            DB::table('bw_display_poli')
            ->where('kd_display', $kd_display)
            ->update($this->getDisplay[$key]);
            $this->flashMessage('Display berhasil diupdate!', 'success', 'check');
            $this->emit('mount');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat update pendaftaran.', 'danger', 'ban');
        }
    }
    // HAPUS PENDAFTARAN
    public function deleteDisplay($key ,$kd_display) {
        try {
            DB::table('bw_display_poli')
                ->where('kd_display', $kd_display)
                ->delete();
            $this->flashMessage('Display berhasil dihapus!', 'warning', 'check');
            $this->emit('mount');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat menghapus pendaftaran.', 'danger', 'ban');
        }
    }

}
