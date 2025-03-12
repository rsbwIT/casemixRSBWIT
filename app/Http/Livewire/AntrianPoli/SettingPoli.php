<?php

namespace App\Http\Livewire\AntrianPoli;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SettingPoli extends Component
{
    protected $listeners = ['mount'];

    public  function mount()
    {
        $this->getPoli();
        $this->getDisplay();
    }
    public function render()
    {
        $this->getDisplay();
        $this->getPoli();
        return view('livewire.antrian-poli.setting-poli');
    }
    // ALERT
    private function flashMessage($message, $color, $icon)
    {
        Session::flash('message', $message);
        Session::flash('color', $color);
        Session::flash('icon', $icon);
    }
    // GET Display
    public $getDisplay;
    public  function getDisplay()
    {
        $this->getDisplay = DB::table('bw_display_poli')
            ->select('bw_display_poli.kd_display', 'bw_display_poli.nama_display')
            ->get();
    }

    // GET Poli
    public $getPoli;
    private function getPoli()
    {
        $this->getPoli = DB::table('bw_ruang_poli')
            ->select(
                'bw_ruang_poli.kd_ruang_poli',
                'bw_ruang_poli.nama_ruang_poli',
                'bw_ruang_poli.kd_display',
                'bw_ruang_poli.posisi_display_poli',
                'bw_display_poli.nama_display'
            )
            ->join('bw_display_poli', 'bw_ruang_poli.kd_display', '=', 'bw_display_poli.kd_display')
            ->get();
    }

    // ADD Poli
    public $kd_ruang_poli;
    public $nama_ruang_poli;
    public $kd_display;
    public $posisi_display_poli;
    protected $rules = [
        'kd_ruang_poli' => 'required',
        'nama_ruang_poli' => 'required',
        'kd_display' => 'required',
        'posisi_display_poli' => 'required',
    ];
    protected $messages = [
        'kd_ruang_poli.required' => 'Kode poli harus diisi',
        'nama_ruang_poli.required' => 'Nama poli harus diisi',
        'kd_display.required' => 'Pilih lokasi display',
        'posisi_display_poli.required' => 'Pilih posisi poli didisplay',
    ];
    public function addPoli()
    {
        $this->validate();
        try {
            DB::table('bw_ruang_poli')->insert([
                'kd_ruang_poli' => $this->kd_ruang_poli,
                'nama_ruang_poli' => $this->nama_ruang_poli,
                'kd_display' => $this->kd_display,
                'posisi_display_poli' => $this->posisi_display_poli,
            ]);
            $this->reset(['kd_ruang_poli', 'nama_ruang_poli', 'kd_display']);
            $this->flashMessage('Loket berhasil ditambahkan!', 'success', 'check');
            $this->emit('mount'); // Triger ke komponen SettingPosisiDokter
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat menambahkan loket.', 'danger', 'ban');
        }
    }

    // EDIT POLI
    public function editPoli($key, $kd_ruang_poli)
    {
        try {
            DB::table('bw_ruang_poli')->where('kd_ruang_poli', $kd_ruang_poli)
                ->update([
                    'nama_ruang_poli' => $this->getPoli[$key]['nama_ruang_poli'],
                    'kd_display' => $this->getPoli[$key]['kd_display'],
                    'posisi_display_poli' => $this->getPoli[$key]['posisi_display_poli'],
                ]);
            $this->flashMessage('Loket berhasil diupdate!', 'success', 'check');
            $this->emit('mount');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat update Loket.', 'danger', 'ban');
        }
    }

    // HAPUS deletePoli
    public function deletePoli($kd_ruang_poli) {
        try {
            DB::table('bw_ruang_poli')
                ->where('kd_ruang_poli', $kd_ruang_poli)
                ->delete();
            $this->flashMessage('Poli berhasil dihapus!', 'warning', 'check');
            $this->emit('mount');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat menghapus Poli.', 'danger', 'ban');
        }
    }
}
