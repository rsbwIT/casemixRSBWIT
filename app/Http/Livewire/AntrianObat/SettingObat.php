<?php

namespace App\Http\Livewire\AntrianObat;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SettingObat extends Component
{
    protected $listeners = ['mount'];

    public  function mount()
    {
        $this->getLoket();
        $this->getDisplay();
    }
    public function render()
    {
        $this->getDisplay();
        $this->getLoket();
        return view('livewire.antrian-obat.setting-obat');
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
        $this->getDisplay = DB::table('bw_display_farmasi')
            ->select('bw_display_farmasi.kd_display_farmasi', 'bw_display_farmasi.nama_display_farmasi')
            ->get();
    }

    // GET Loket
    public $getLoket;
    private function getLoket()
    {
        $this->getLoket = DB::table('bw_loket_farmasi')
            ->select(
                'bw_loket_farmasi.kd_loket_farmasi',
                'bw_loket_farmasi.nama_loket_farmasi',
                'bw_loket_farmasi.kd_display_farmasi',
                'bw_loket_farmasi.posisi_display_farmasi',
                'bw_display_farmasi.nama_display_farmasi'
            )
            ->join('bw_display_farmasi', 'bw_loket_farmasi.kd_display_farmasi', '=', 'bw_display_farmasi.kd_display_farmasi')
            ->get();
    }

    // ADD Loket
    public $kd_loket_farmasi;
    public $nama_loket_farmasi;
    public $kd_display_farmasi;
    public $posisi_display_farmasi;
    protected $rules = [
        'kd_loket_farmasi' => 'required',
        'nama_loket_farmasi' => 'required',
        'kd_display_farmasi' => 'required',
        'posisi_display_farmasi' => 'required',
    ];
    protected $messages = [
        'kd_loket_farmasi.required' => 'Kode loket harus diisi',
        'nama_loket_farmasi.required' => 'Nama loket harus diisi',
        'kd_display_farmasi.required' => 'Pilih lokasi display',
        'posisi_display_farmasi.required' => 'Pilih posisi loket didisplay',
    ];
    public function addLoket()
    {
        $this->validate();
        try {
            DB::table('bw_loket_farmasi')->insert([
                'kd_loket_farmasi' => $this->kd_loket_farmasi,
                'nama_loket_farmasi' => $this->nama_loket_farmasi,
                'kd_display_farmasi' => $this->kd_display_farmasi,
                'posisi_display_farmasi' => $this->posisi_display_farmasi,
            ]);
            $this->reset(['kd_loket_farmasi', 'nama_loket_farmasi', 'kd_display_farmasi']);
            $this->flashMessage('Loket berhasil ditambahkan!', 'success', 'check');
            $this->emit('mount'); // Triger ke komponen SettingPosisiDokter
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat menambahkan loket.', 'danger', 'ban');
        }
    }

    // EDIT Loket
    public function editLoket($key, $kd_loket_farmasi)
    {
        try {
            DB::table('bw_loket_farmasi')->where('kd_loket_farmasi', $kd_loket_farmasi)
                ->update([
                    'nama_loket_farmasi' => $this->getLoket[$key]['nama_loket_farmasi'],
                    'kd_display_farmasi' => $this->getLoket[$key]['kd_display_farmasi'],
                    'posisi_display_farmasi' => $this->getLoket[$key]['posisi_display_farmasi'],
                ]);
            $this->flashMessage('Loket berhasil diupdate!', 'success', 'check');
            $this->emit('mount');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat update Loket.', 'danger', 'ban');
        }
    }

    // HAPUS Loket
    public function deleteLoket($kd_loket_farmasi) {
        try {
            DB::table('bw_loket_farmasi')
                ->where('kd_loket_farmasi', $kd_loket_farmasi)
                ->delete();
            $this->flashMessage('Loket berhasil dihapus!', 'warning', 'check');
            $this->emit('mount');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat menghapus Loket.', 'danger', 'ban');
        }
    }
}
