<?php

namespace App\Http\Livewire\Farmasi;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MinimalStokObat extends Component
{
    public $bangsal = 'DepRI';
    public $getListObat;
    public $stok_minimal_medis;
    public function mount()
    {
        $this->cariListobat();
        $this->submitForm();
        $this->bangsal = $this->bangsal;
    }

    public function render()
    {
        $this->cariListobat();
        $this->submitForm();
        return view('livewire.farmasi.minimal-stok-obat');
    }

    // GET LIST
    public function cariListobat() {
        $this->getListObat = DB::table('stok_minimal_medis')
        ->select('stok_minimal_medis.kode_brng', 'stok_minimal_medis.kd_bangsal', 'stok_minimal_medis.stok_minimal_medis', 'gudangbarang.stok', 'databarang.nama_brng', 'kodesatuan.satuan')
        ->join('gudangbarang',function($join) {
            $join->on('stok_minimal_medis.kode_brng','=','gudangbarang.kode_brng')
            ->on('gudangbarang.kd_bangsal','=','stok_minimal_medis.kd_bangsal');
        })
        ->join('databarang','databarang.kode_brng','=','gudangbarang.kode_brng')
        ->join('kodesatuan','kodesatuan.kode_sat','=','databarang.kode_sat')
        ->when($this->bangsal, function ($query) {
                        return $query->where('stok_minimal_medis.kd_bangsal', $this->bangsal);
                    })
        ->orderBy('stok','asc')
                    ->orderBy('nama_brng','asc')
        ->get();
    }

    // UPDATE LISt
    public function update($kd_brng)
    {
      return DB::table('stok_minimal_medis')
      ->where('kode_brng', $kd_brng)
      ->update(['stok_minimal_medis' => $this->stok_minimal_medis]);
    }

    // ADD LIST
    public $kode_barang;
    public $dataBarang;
    public function submitForm() {
        $this->dataBarang = DB::table('databarang')
            ->select('databarang.kode_brng', 'databarang.nama_brng', 'gudangbarang.kd_bangsal')
            ->join('gudangbarang','gudangbarang.kode_brng','=','databarang.kode_brng')
            ->where('databarang.kode_brng', $this->kode_barang)
            ->whereIn('gudangbarang.kd_bangsal', ['DepRI', 'DepRJ'])
            ->get();
    }

    public $add_stok_minimal = [];
    public function tambahListObat($key, $kode_brng, $kd_bangsal) {
        $this->validate([
            'add_stok_minimal.' . $key => 'required',
        ]);
        $cekTbleStokMinimal =  DB::table('stok_minimal_medis')
            ->where('kode_brng', $kode_brng)
            ->where('kd_bangsal', $kd_bangsal)
            ->count();
        if($cekTbleStokMinimal > 0)
        {
            Session::flash('ready'.$key, 'Data sudah ada');
        }
        else{
            DB::table('stok_minimal_medis')->insert([
                'kode_brng' => $kode_brng,
                'kd_bangsal' => $kd_bangsal,
                'stok_minimal_medis' => $this->add_stok_minimal[$key],
            ]);
            Session::flash('sucsess'.$key, 'Berhasil');
        }
    }

    public $confirmingEdit = false;
    public $kd_bangsal;
    public $kode_brng;
    public function deleteListObat($kode_brng, $kd_bangsal) {
        $this->confirmingEdit = true;
        $this->kode_brng = $kode_brng;
        $this->kd_bangsal = $kd_bangsal;
    }
    public function confirmDelteObat() {
        try {
            DB::table('stok_minimal_medis')
            ->where('kode_brng', $this->kode_brng)
            ->where('kd_bangsal', $this->kd_bangsal)
            ->delete();
            Session::flash('sucsessDelete', 'Anda Menghapus Obat '.$this->kode_brng);
            $this->confirmingEdit = false;
        } catch (\Throwable $th) {
            $this->confirmingEdit = false;
        }
        // AU000006360
    }
    public function cancelDeleteObat() {
        $this->confirmingEdit = false;
    }
}
