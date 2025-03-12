<?php

namespace App\Http\Controllers\AntrianObat;

use Illuminate\Http\Request;
use App\Services\CacheService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use url;

class AntrianObat extends Controller
{
    protected $cacheService;
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }
    public function AntrianObat()
    {
        $antrianObat = DB::table('bw_display_farmasi')
            ->select('bw_display_farmasi.kd_display_farmasi', 'bw_display_farmasi.nama_display_farmasi')
            ->get();
        $antrianObat->map(function ($item) {
            $item->getLoket = DB::table('bw_loket_farmasi')
                ->select(
                    'bw_loket_farmasi.kd_loket_farmasi',
                    'bw_loket_farmasi.nama_loket_farmasi',
                    'bw_loket_farmasi.kd_display_farmasi',
                    'bw_loket_farmasi.posisi_display_farmasi'
                )
                ->where('bw_loket_farmasi.kd_display_farmasi', $item->kd_display_farmasi)
                ->get();
        });
        return view('antrian-obat.antrian-obat', [
            'antrianObat' => $antrianObat
        ]);
    }
    public function displayFarmasi()
    {
        $getSetting = $this->cacheService->getSetting();
        return view('antrian-obat.display-farmasi', [
            'getSetting' => $getSetting
        ]);
    }
    public function panggilobat()
    {
        return view('antrian-obat.panggilobat');
    }
    public function settingObat()
    {
        return view('antrian-obat.setting-obat');
    }

    public function downloadAutorun(Request $request)
    {
        $kdDisplayFarmasi = $request->kd_display_farmasi;
        $url = url('/display-farmasi?kd_display_farmasi='.$kdDisplayFarmasi);
        $fileName = 'autorun-display-obat-' . $kdDisplayFarmasi . '.bat';
        $content = <<<BAT
            @echo off
            set URL={$url}
            REM Jalankan Microsoft Edge dengan URL dalam mode fullscreen
            start msedge --start-fullscreen %URL%
            REM Tutup script ini setelah selesai
            exit
            BAT;
        $filePath = storage_path($fileName);
        File::put($filePath, $content);

        return response()->download($filePath, $fileName)->deleteFileAfterSend(true);
    }

    public function ambilAntrian()
    {
        return view('antrian-obat.ambil-antrian');
    }
}
