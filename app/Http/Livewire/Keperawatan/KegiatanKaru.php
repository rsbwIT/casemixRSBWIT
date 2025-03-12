<?php

namespace App\Http\Livewire\Keperawatan;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KegiatanKaru extends Component
{

    public $tanggal;
    public function mount()
    {
        $this->getPegaway();
        $this->getListKegiatan();
        $this->tanggal = date('Y-m-d');
        $this->tanggal1 = date('Y-m-d');
        $this->tanggal2 = date('Y-m-d');
    }
    public function render()
    {
        $this->getListKegiatan();
        $this->getPegaway();
        $this->carinamaKegiatan();
        return view('livewire.keperawatan.kegiatan-karu');
    }
    // 1 Get Pegawai
    public $getPegawai;
    public function getPegaway()
    {
        $this->getPegawai = DB::table('pegawai')
            ->select('pegawai.nik', 'pegawai.nama', 'pegawai.jk', 'pegawai.tmp_lahir', 'pegawai.tgl_lahir', 'pegawai.photo')
            ->where('pegawai.nik', session('auth')['id_user'])
            ->get();
    }

    // 2 Get Nama Kegiatan
    public $mandiri = [];
    public $dibawahsupervisi = [];
    public $getKegiatan;
    public $cari_kode_kegiatan;
    public function carinamaKegiatan()
    {
        $cariKode = $this->cari_kode_kegiatan;
        $this->getKegiatan = DB::table('bw_nm_kegiatan_karu')
            ->select(
                'bw_nm_kegiatan_karu.kd_kegiatan',
                'bw_nm_kegiatan_karu.nama_kegiatan',
                'bw_nm_kegiatan_karu.kd_jns_kegiatan_karu',
                'bw_nm_kegiatan_karu.default_mandiri',
                'bw_nm_kegiatan_karu.default_supervisi'
            )
            ->where(function ($query) use ($cariKode) {
                $query->orwhere('bw_nm_kegiatan_karu.kd_kegiatan', 'LIKE', "%$cariKode%")
                    ->orWhere('bw_nm_kegiatan_karu.nama_kegiatan', 'LIKE', "%$cariKode%");
            })
            ->get();
        foreach ($this->getKegiatan as $key => $kegiatan) {
            $this->mandiri[$key] = $kegiatan->default_mandiri == 'false' ? false : true;
            $this->dibawahsupervisi[$key] = $kegiatan->default_supervisi == 'false' ? false : true;
        }
    }

    // 3 Simpan Kegiatan
    public function simpanKegiatan($key, $kd_kegiatan, $user)
    {
        DB::table('bw_logbook_karu')->insert([
            'kd_kegiatan' => $kd_kegiatan,
            'user' => $user,
            'mandiri' => $this->mandiri[$key],
            'supervisi' => $this->dibawahsupervisi[$key],
            'tanggal' => $this->tanggal,
        ]);
        Session::flash('sucsess' . $key, 'Berhasil');
    }

    // Get Lis Kegiatan karu
    public $getListKegiatan;
    public $cariKodeListKegiatan;
    public $tanggal1;
    public $tanggal2;
    public function getListKegiatan()
    {
        $cariKode = $this->cariKodeListKegiatan;
        $this->getListKegiatan = DB::table('bw_logbook_karu')
            ->select('bw_logbook_karu.id_logbook', 'bw_logbook_karu.user', 'bw_nm_kegiatan_karu.nama_kegiatan', 'bw_logbook_karu.tanggal', 'bw_logbook_karu.supervisi', 'bw_logbook_karu.mandiri')
            ->join('bw_nm_kegiatan_karu', 'bw_logbook_karu.kd_kegiatan', '=', 'bw_nm_kegiatan_karu.kd_kegiatan')
            ->where('bw_logbook_karu.user', session('auth')['id_user'])
            ->whereBetween('bw_logbook_karu.tanggal', [$this->tanggal1, $this->tanggal2])
            ->where(function ($query) use ($cariKode) {
                $query->orwhere('bw_nm_kegiatan_karu.nama_kegiatan', 'LIKE', "%$cariKode%")
                    ->orWhere('bw_logbook_karu.id_logbook', 'LIKE', "%$cariKode%");
            })
            ->get();
        }
        // HAPUS LIST KEGIATAN
        public function hapusListKegiatan($key, $id_logbook)
        {
            try {
                DB::table('bw_logbook_karu')
                ->where('id_logbook', $id_logbook)
                ->delete();
                Session::flash('succsesDeleteKegiatan');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
