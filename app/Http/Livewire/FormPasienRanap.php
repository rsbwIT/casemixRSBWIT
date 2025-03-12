<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Exception;

class FormPasienRanap extends Component
{
    public $keluhan_utama, $keluhan_tambahan, $sejak_kapan, $indikasi_rawat_inap;
    public $tekanan_darah, $heart_rate, $respiratory_rate, $suhu, $skala_nyeri;
    public $diagnosa_kerja, $penyebab_utama, $riwayat_penyakit;
    public $riwayat_penyakit_sekarang, $pemeriksaan_penunjang;
    public $jenis_perawatan, $nama_tindakan, $jenis_bius;
    public $sewa_ok = 0, $biaya_operator = 0, $obat_obatan = 0, $total_biaya = 0;
    public $showOperasiInput = false;

    protected $rules = [
        'keluhan_utama' => 'required|string',
        'keluhan_tambahan' => 'required|string',
        'sejak_kapan' => 'required|string',
        'indikasi_rawat_inap' => 'required|string',
        'tekanan_darah' => 'required|string',
        'heart_rate' => 'required|string',
        'respiratory_rate' => 'required|string',
        'suhu' => 'required|string',
        'skala_nyeri' => 'required|string',
        'diagnosa_kerja' => 'required|string',
        'penyebab_utama' => 'required|string',
        'riwayat_penyakit' => 'required|string',
        'riwayat_penyakit_sekarang' => 'required|string',
        'pemeriksaan_penunjang' => 'required|string',
        'jenis_perawatan' => 'required|string',
        'nama_tindakan' => 'nullable|string',
        'jenis_bius' => 'nullable|string',
        'sewa_ok' => 'nullable|numeric',
        'biaya_operator' => 'nullable|numeric',
        'obat_obatan' => 'nullable|numeric',
        'total_biaya' => 'nullable|numeric',
    ];

    public function updated($field)
    {
        $this->validateOnly($field);

        // Tampilkan/sembunyikan input operasi berdasarkan jenis perawatan
        if ($field === 'jenis_perawatan') {
            $this->showOperasiInput = ($this->jenis_perawatan === 'operasi');
            
            // Reset nilai terkait operasi jika bukan jenis perawatan operasi
            if (!$this->showOperasiInput) {
                $this->nama_tindakan = null;
                $this->jenis_bius = null;
                $this->sewa_ok = 0;
                $this->biaya_operator = 0;
                $this->obat_obatan = 0;
                $this->total_biaya = 0;
            }
        }

        // Hitung total biaya setiap kali salah satu komponen biaya berubah
        if (in_array($field, ['sewa_ok', 'biaya_operator', 'obat_obatan'])) {
            $this->calculateTotal();
        }
    }

    public function calculateTotal()
    {
        $this->sewa_ok = (float) $this->sewa_ok;
        $this->biaya_operator = (float) $this->biaya_operator;
        $this->obat_obatan = (float) $this->obat_obatan;
        $this->total_biaya = $this->sewa_ok + $this->biaya_operator + $this->obat_obatan;
    }

    public function submit()
    {
        $this->validate();
        
        try {
            // Hitung total untuk memastikan nilai benar sebelum disimpan
            $this->calculateTotal();
            
            DB::table('pasien_ranap')->insert([
                'keluhan_utama' => $this->keluhan_utama,
                'keluhan_tambahan' => $this->keluhan_tambahan,
                'sejak_kapan' => $this->sejak_kapan,
                'indikasi_rawat_inap' => $this->indikasi_rawat_inap,
                'tekanan_darah' => $this->tekanan_darah,
                'heart_rate' => $this->heart_rate,
                'respiratory_rate' => $this->respiratory_rate,
                'suhu' => $this->suhu,
                'skala_nyeri' => $this->skala_nyeri,
                'diagnosa_kerja' => $this->diagnosa_kerja,
                'penyebab_utama' => $this->penyebab_utama,
                'riwayat_penyakit' => $this->riwayat_penyakit,
                'riwayat_penyakit_sekarang' => $this->riwayat_penyakit_sekarang,
                'pemeriksaan_penunjang' => $this->pemeriksaan_penunjang,
                'jenis_perawatan' => $this->jenis_perawatan,
                'nama_tindakan' => $this->nama_tindakan,
                'jenis_bius' => $this->jenis_bius,
                'sewa_ok' => $this->sewa_ok,
                'biaya_operator' => $this->biaya_operator,
                'obat_obatan' => $this->obat_obatan,
                'total_biaya' => $this->total_biaya,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            session()->flash('message', 'Form berhasil dikirim!');
            $this->reset();
            $this->showOperasiInput = false;
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.form-pasien-ranap');
    }
}