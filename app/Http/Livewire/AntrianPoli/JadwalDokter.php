<?php

namespace App\Http\Livewire\AntrianPoli;

use Livewire\Component;
use App\Services\DayListService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class JadwalDokter extends Component
{
    public  function mount()
    {
        $dayList = DayListService::getDayList();
        $this->pilih_hari = $dayList[date('l')];
    }
    public function render()
    {
        $this->jdawalDokter();
        $this->cariDokter();
        $this->getPoli();
        return view('livewire.antrian-poli.jadwal-dokter');
    }

    public $getDokter;
    public $cari_dokter;
    public $pilih_hari;
    public function jdawalDokter()
    {
        $cariKode = $this->cari_dokter;
        $this->getDokter =  DB::table('bw_jadwal_dokter')
            ->select(
                'dokter.nm_dokter',
                'bw_jadwal_dokter.kd_dokter',
                'bw_jadwal_dokter.hari_kerja',
                'bw_jadwal_dokter.jam_mulai',
                'bw_jadwal_dokter.jam_selesai',
                'poliklinik.nm_poli'
            )
            ->join('dokter', 'bw_jadwal_dokter.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('poliklinik', 'bw_jadwal_dokter.kd_poli', '=', 'poliklinik.kd_poli')
            ->where('bw_jadwal_dokter.hari_kerja', $this->pilih_hari)
            ->where(function ($query) use ($cariKode) {
                $query->orwhere('dokter.kd_dokter', 'LIKE', "%$cariKode%")
                    ->orWhere('dokter.nm_dokter', 'LIKE', "%$cariKode%")
                    ->orWhere('poliklinik.nm_poli', 'LIKE', "%$cariKode%");
            })
            ->get();
    }

    public function ubahJadwalDokter($key, $hari_kerja, $jam_mulai, $jam_selesai)
    {
        try {
            DB::table('bw_jadwal_dokter')
                ->where('hari_kerja', $hari_kerja)
                ->where('jam_mulai', $jam_mulai)
                ->where('jam_selesai', $jam_selesai)
                ->update([
                    'jam_mulai' => $this->getDokter[$key]['jam_mulai'],
                    'jam_selesai' => $this->getDokter[$key]['jam_selesai'],
                ]);
            Session::flash('succsesEditJadwal');
        } catch (\Throwable $th) {
        }
    }
    public function hapusJadwalDokter($key, $hari_kerja, $jam_mulai, $jam_selesai)
    {
        try {
            DB::table('bw_jadwal_dokter')
                ->where('hari_kerja', $hari_kerja)
                ->where('jam_mulai', $jam_mulai)
                ->where('jam_selesai', $jam_selesai)
                ->delete();
        Session::flash('sucsessHapusDokter', 'Berhasil');
        } catch (\Throwable $th) {
        }
    }

    // ===================================================================
    public $getPoli;
    public function getPoli() {
        $this->getPoli = DB::table('poliklinik')
            ->select('poliklinik.kd_poli', 'poliklinik.nm_poli')
            ->where('poliklinik.status','=','1')
            ->get();
    }
    public $cari_kode_dokter;
    public $getTambahDokter;
    public function cariDokter() {
        $cariKode = $this->cari_kode_dokter;
        $this->getTambahDokter = DB::table('dokter')
        ->select('dokter.kd_dokter', 'dokter.nm_dokter', 'dokter.status')
        ->where('dokter.status','=','1')
        ->where(function ($query) use ($cariKode) {
            $query->orwhere('dokter.kd_dokter', 'LIKE', "%$cariKode%")
            ->orwhere('dokter.nm_dokter', 'LIKE', "%$cariKode%");
        })
        ->take(1)
        ->get();
    }

    public $jam_mulai = [];
    public $jam_selesai = [];
    public $poli = [];
    public function tambahJadwalDokter($key, $kd_dokter) {
        $this->validate([
            'jam_mulai.' . $key => 'required',
            'jam_selesai.' . $key => 'required',
            'poli.' . $key => 'required',
        ]);
        DB::table('bw_jadwal_dokter')->insert([
            'kd_dokter' => $kd_dokter,
            'hari_kerja' => $this->pilih_hari,
            'jam_mulai' => $this->jam_mulai[$key].':00',
            'jam_selesai' => $this->jam_selesai[$key].':00',
            'kd_poli' => $this->poli[$key],
        ]);
        Session::flash('sucsess'.$key, 'Berhasil');
    }
}
