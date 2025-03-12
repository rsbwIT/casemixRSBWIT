<?php

namespace App\Http\Controllers\Laporan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

// use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function Pasien()
    {
        // TANGGAL
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();

        // JUMLAH PASIEN BERDASARKAN JENIS BAYAR
        $pasein = DB::table('reg_periksa')
            ->join("penjab", function($join){
                $join->on('reg_periksa.kd_pj', '=', 'penjab.kd_pj');
            })
            ->select('penjab.png_jawab', DB::raw('count(penjab.kd_pj) as total'))
            ->whereBetween('reg_periksa.tgl_registrasi', [$startDate, $endDate])
            ->groupBy('penjab.png_jawab')
            ->get();

        // JUMLAH PASIEN PERBULAN
        $dataCounts = DB::table('reg_periksa')
            ->whereBetween('tgl_registrasi', [$startDate, $endDate])
            ->groupBy('tgl_registrasi')
            ->select('tgl_registrasi', DB::raw('COUNT(*) as jumlah_pas'))
            ->get();

        return view('laporan.jumlahPasien', [
            'pasein'=>$pasein,
            'dataCounts'=>$dataCounts,
        ]);
    }
}
