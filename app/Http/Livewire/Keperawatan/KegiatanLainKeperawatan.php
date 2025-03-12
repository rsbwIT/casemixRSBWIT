<?php

namespace App\Http\Livewire\Keperawatan;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KegiatanLainKeperawatan extends Component
{
    public function mount(){
        $this->getPegaway();
        $this->getJenisKegiatan();
        $this->getListKegiatan();
        $this->tanggal = date('Y-m-d');
        $this->tanggal1 = date('Y-m-d');
        $this->tanggal2= date('Y-m-d');
    }
    public function render()
    {
        $this->getPegaway();
        $this->getJenisKegiatan();
        $this->getListKegiatan();
        return view('livewire.keperawatan.kegiatan-lain-keperawatan');
    }
// ===================================================================================================================
    // Get Jenis Kegiatan
    public $getJenisKegiatan;
    public function getJenisKegiatan() {
        $this->getJenisKegiatan = DB::table('bw_jenis_lookbook_kegiatan_lain')
        ->select('bw_jenis_lookbook_kegiatan_lain.id_kegiatan', 'bw_jenis_lookbook_kegiatan_lain.nama_kegiatan')
        ->orderBy('bw_jenis_lookbook_kegiatan_lain.id_kegiatan','desc')
        ->get();
    }

    // Get Pegawai
    public $getPegawai;
    public function getPegaway() {
        $this->getPegawai = DB::table('pegawai')
        ->select('pegawai.nik', 'pegawai.nama', 'pegawai.jk', 'pegawai.tmp_lahir', 'pegawai.tgl_lahir', 'pegawai.photo')
        ->where('pegawai.nik', session('auth')['id_user'])
        ->get();
    }
// ===================================================================================================================
    // INPUT KEGIATAN
    public $id_kegiatan;
    public $tanggal;
    public $judul;
    public $deskripsi;
    public $mandiri = true;
    public $supervisi = false;
    protected $rules = [
        'id_kegiatan' => 'required',
        'judul' => 'required',
        'tanggal' => 'required',
        'deskripsi' => 'required',
    ];
    public  function simpanKegiatan($id_user) {
        $this->validate();
        try {
            DB::table('bw_logbook_keperawatan_kegiatanlain')->insert([
                'id_kegiatan' => $this->id_kegiatan,
                'judul' => $this->judul,
                'tanggal' => $this->tanggal,
                'deskripsi' => $this->deskripsi,
                'user' => $id_user,
                'mandiri' => $this->mandiri,
                'supervisi' => $this->supervisi,
            ]);
            Session::flash('succsesInputKegiatan');
            $this->reset(['id_kegiatan', 'judul', 'deskripsi']);
        } catch (\Throwable $th) {
        }
    }

    // GET LIST KEGIATAN
    public $edit_mandiri = [];
    public $edit_dibawahsupervisi = [];
    public $getListKegiatan;
    public $cariKodeListKegiatan;
    public $tanggal1;
    public $tanggal2;
    public function getListKegiatan() {
        $cariKode = $this->cariKodeListKegiatan;
        $this->getListKegiatan = DB::table('bw_logbook_keperawatan_kegiatanlain')
        ->select('bw_logbook_keperawatan_kegiatanlain.id_kegiatan_keperawatanlain','bw_logbook_keperawatan_kegiatanlain.id_kegiatan','bw_jenis_lookbook_kegiatan_lain.nama_kegiatan', 'bw_logbook_keperawatan_kegiatanlain.judul', 'bw_logbook_keperawatan_kegiatanlain.deskripsi', 'bw_logbook_keperawatan_kegiatanlain.mandiri', 'bw_logbook_keperawatan_kegiatanlain.supervisi', 'bw_logbook_keperawatan_kegiatanlain.tanggal')
        ->join('bw_jenis_lookbook_kegiatan_lain','bw_logbook_keperawatan_kegiatanlain.id_kegiatan','=','bw_jenis_lookbook_kegiatan_lain.id_kegiatan')
        ->where('bw_logbook_keperawatan_kegiatanlain.user', session('auth')['id_user'])
        ->whereBetween('bw_logbook_keperawatan_kegiatanlain.tanggal',[$this->tanggal1, $this->tanggal2])
        ->where(function ($query) use ($cariKode) {
            $query->orwhere('bw_jenis_lookbook_kegiatan_lain.nama_kegiatan', 'LIKE', "%$cariKode%")
                ->orWhere('bw_logbook_keperawatan_kegiatanlain.judul', 'LIKE', "%$cariKode%");
        })
        ->get();
        foreach ($this->getListKegiatan as $key => $kegiatan) {
            $this->edit_mandiri[$key] = $kegiatan->mandiri == '0' ? false : true;
            $this->edit_dibawahsupervisi[$key] = $kegiatan->supervisi == '0' ? false : true;
        }
    }

    // EDIT LIST KEGIATAN
    public $select;
    public function editListKegiatan($key, $id_kegiatan_keperawatanlain) {
        try {
            $this->select = $this->getListKegiatan[$key]['id_kegiatan'];
            DB::table('bw_logbook_keperawatan_kegiatanlain')->where('id_kegiatan_keperawatanlain', $id_kegiatan_keperawatanlain)
                ->update([
                    'id_kegiatan' => $this->getListKegiatan[$key]['id_kegiatan'],
                    'tanggal' => $this->getListKegiatan[$key]['tanggal'],
                    'judul' => $this->getListKegiatan[$key]['judul'],
                    'deskripsi' => $this->getListKegiatan[$key]['deskripsi'],
                    'mandiri' => $this->edit_mandiri[$key],
                    'supervisi' => $this->edit_dibawahsupervisi[$key],
                ]);
            Session::flash('succsesEditKegiatan');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // HAPUS LIST KEGIATAN
    public function hapusListKegiatan($key, $id_kegiatan_keperawatanlain){
        try {
            DB::table('bw_logbook_keperawatan_kegiatanlain')
            ->where('id_kegiatan_keperawatanlain', $id_kegiatan_keperawatanlain)
            ->delete();
            Session::flash('succsesDeleteKegiatan');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
