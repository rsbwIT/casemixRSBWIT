<?php

namespace App\Http\Controllers\DetailTindakanUmum;

use Illuminate\Http\Request;
use App\Services\CacheService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PeriksaRadiologiUm extends Controller
{
    protected $cacheService;
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }
    function PeriksaRadiologiUm(Request $request) {
        $action = '/periksa-radiologi-umum';
        $petugas = $this->cacheService->getPetugas();
        $dokter = $this->cacheService->getDokter();

        $kdPetugas = ($request->input('kdPetugas') == null) ? "" : explode(',', $request->input('kdPetugas'));
        $kdDokter = ($request->input('kdDokter')  == null) ? "" : explode(',', $request->input('kdDokter'));
        $cariNomor = $request->cariNomor;
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;

        $getPeriksaRadiologi = DB::table('periksa_radiologi')
            ->select(
                'periksa_radiologi.no_rawat',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'periksa_radiologi.kd_jenis_prw',
                'jns_perawatan_radiologi.nm_perawatan',
                'periksa_radiologi.kd_dokter',
                'dokter.nm_dokter',
                'periksa_radiologi.nip',
                'petugas.nama',
                'periksa_radiologi.dokter_perujuk',
                'perujuk.nm_dokter AS perujuk',
                'periksa_radiologi.tgl_periksa',
                'periksa_radiologi.jam',
                'penjab.png_jawab',
                'periksa_radiologi.bagian_rs',
                'periksa_radiologi.bhp',
                'periksa_radiologi.tarif_perujuk',
                'periksa_radiologi.tarif_tindakan_dokter',
                'periksa_radiologi.tarif_tindakan_petugas',
                'periksa_radiologi.kso',
                'periksa_radiologi.menejemen',
                'reg_periksa.status_lanjut',
                'periksa_radiologi.biaya',
                DB::raw("IF(periksa_radiologi.status = 'Ralan', (SELECT nm_poli FROM poliklinik WHERE poliklinik.kd_poli = reg_periksa.kd_poli), (SELECT bangsal.nm_bangsal FROM kamar_inap INNER JOIN kamar INNER JOIN bangsal ON kamar_inap.kd_kamar = kamar.kd_kamar AND kamar.kd_bangsal = bangsal.kd_bangsal WHERE kamar_inap.no_rawat = periksa_radiologi.no_rawat LIMIT 1)) AS ruangan"),
                'billing.tgl_byr'
            )
            ->join('reg_periksa', 'periksa_radiologi.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('dokter', 'periksa_radiologi.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('dokter AS perujuk', 'periksa_radiologi.dokter_perujuk', '=', 'perujuk.kd_dokter')
            ->join('petugas', 'periksa_radiologi.nip', '=', 'petugas.nip')
            ->join('penjab', 'reg_periksa.kd_pj', '=', 'penjab.kd_pj')
            ->join('jns_perawatan_radiologi', 'periksa_radiologi.kd_jenis_prw', '=', 'jns_perawatan_radiologi.kd_jenis_prw')
            ->join('billing','billing.no_rawat','=','reg_periksa.no_rawat')
            ->where('billing.no','=','No.Nota')
            ->where('penjab.kd_pj','UMU')
            ->whereBetween('billing.tgl_byr',[$tanggl1, $tanggl2])
            ->where(function ($query) use ( $kdPetugas, $kdDokter) {
                if ($kdPetugas) {
                    $query->whereIn('petugas.nip', $kdPetugas);
                }
                if ($kdDokter) {
                    $query->whereIn('periksa_radiologi.kd_dokter', $kdDokter);
                }
            })
            ->where(function($query) use ($cariNomor) {
                $query->orWhere('reg_periksa.no_rawat', 'like', '%' . $cariNomor . '%');
                $query->orWhere('reg_periksa.no_rkm_medis', 'like', '%' . $cariNomor . '%');
                $query->orWhere('pasien.nm_pasien', 'like', '%' . $cariNomor . '%');
            })
            ->get();



        return view('detail-tindakan-umum.periksa-radiologi-um', [
            'action'=>$action,
            'petugas'=>$petugas,
            'dokter'=>$dokter,
            'getPeriksaRadiologi'=>$getPeriksaRadiologi,
        ]);
    }
}
