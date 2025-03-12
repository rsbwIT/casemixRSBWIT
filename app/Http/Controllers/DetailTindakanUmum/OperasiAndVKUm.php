<?php

namespace App\Http\Controllers\DetailTindakanUmum;

use Illuminate\Http\Request;
use App\Services\CacheService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OperasiAndVKUm extends Controller
{
    protected $cacheService;
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }
    public function OperasiAndVKUm(Request $request) {
        $action = '/operasi-and-vk-umum';
        $petugas = $this->cacheService->getPetugas();
        $dokter = $this->cacheService->getDokter();

        $kdPetugas = ($request->input('kdPetugas') == null) ? "" : explode(',', $request->input('kdPetugas'));
        $kdDokter = ($request->input('kdDokter')  == null) ? "" : explode(',', $request->input('kdDokter'));
        $cariNomor = $request->cariNomor;
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;

        $OperasiAndVK = DB::table('operasi')
            ->select(
                'operasi.no_rawat',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'operasi.kode_paket',
                'paket_operasi.nm_perawatan',
                'operasi.tgl_operasi',
                'penjab.png_jawab',
                DB::raw('IF(operasi.status="Ralan", (SELECT nm_poli FROM poliklinik WHERE poliklinik.kd_poli=reg_periksa.kd_poli), (SELECT bangsal.nm_bangsal FROM kamar_inap INNER JOIN kamar ON kamar_inap.kd_kamar=kamar.kd_kamar INNER JOIN bangsal ON kamar.kd_bangsal=bangsal.kd_bangsal WHERE kamar_inap.no_rawat=operasi.no_rawat LIMIT 1)) AS ruangan'),
                'operator1.nm_dokter AS operator1',
                'operasi.biayaoperator1',
                'operator2.nm_dokter AS operator2',
                'operasi.biayaoperator2',
                'operator3.nm_dokter AS operator3',
                'operasi.biayaoperator3',
                'asisten_operator1.nama AS asisten_operator1',
                'operasi.biayaasisten_operator1',
                'asisten_operator2.nama AS asisten_operator2',
                'operasi.biayaasisten_operator2',
                'asisten_operator3.nama AS asisten_operator3',
                'operasi.biayaasisten_operator3',
                'instrumen.nama AS instrumen',
                'operasi.biayainstrumen',
                'dokter_anak.nm_dokter AS dokter_anak',
                'operasi.biayadokter_anak',
                'perawaat_resusitas.nama AS perawaat_resusitas',
                'operasi.biayaperawaat_resusitas',
                'dokter_anestesi.nm_dokter AS dokter_anestesi',
                'operasi.biayadokter_anestesi',
                'asisten_anestesi.nama AS asisten_anestesi',
                'operasi.biayaasisten_anestesi',
                DB::raw('(SELECT nama FROM petugas WHERE petugas.nip=operasi.asisten_anestesi2) AS asisten_anestesi2'),
                'operasi.biayaasisten_anestesi2',
                'bidan.nama AS bidan',
                'operasi.biayabidan',
                DB::raw('(SELECT nama FROM petugas WHERE petugas.nip=operasi.bidan2) AS bidan2'),
                'operasi.biayabidan2',
                DB::raw('(SELECT nama FROM petugas WHERE petugas.nip=operasi.bidan3) AS bidan3'),
                'operasi.biayabidan3',
                DB::raw('(SELECT nama FROM petugas WHERE petugas.nip=operasi.perawat_luar) AS perawat_luar'),
                'operasi.biayaperawat_luar',
                DB::raw('(SELECT nama FROM petugas WHERE petugas.nip=operasi.omloop) AS omloop'),
                'operasi.biaya_omloop',
                DB::raw('(SELECT nama FROM petugas WHERE petugas.nip=operasi.omloop2) AS omloop2'),
                'operasi.biaya_omloop2',
                DB::raw('(SELECT nama FROM petugas WHERE petugas.nip=operasi.omloop3) AS omloop3'),
                'operasi.biaya_omloop3',
                DB::raw('(SELECT nama FROM petugas WHERE petugas.nip=operasi.omloop4) AS omloop4'),
                'operasi.biaya_omloop4',
                DB::raw('(SELECT nama FROM petugas WHERE petugas.nip=operasi.omloop5) AS omloop5'),
                'operasi.biaya_omloop5',
                DB::raw('(SELECT nm_dokter FROM dokter WHERE dokter.kd_dokter=operasi.dokter_pjanak) AS dokter_pjanak'),
                'operasi.biaya_dokter_pjanak',
                DB::raw('(SELECT nm_dokter FROM dokter WHERE dokter.kd_dokter=operasi.dokter_umum) AS dokter_umum'),
                'operasi.biaya_dokter_umum',
                'operasi.biayaalat',
                'operasi.biayasewaok',
                'operasi.akomodasi',
                'operasi.bagian_rs',
                'operasi.biayasarpras',
                'billing.tgl_byr'
            )
            ->join('reg_periksa', 'operasi.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('paket_operasi', 'operasi.kode_paket', '=', 'paket_operasi.kode_paket')
            ->join('penjab', 'reg_periksa.kd_pj', '=', 'penjab.kd_pj')
            ->join('dokter as operator1', 'operator1.kd_dokter', '=', 'operasi.operator1')
            ->join('dokter as operator2', 'operator2.kd_dokter', '=', 'operasi.operator2')
            ->join('dokter as operator3', 'operator3.kd_dokter', '=', 'operasi.operator3')
            ->join('dokter as dokter_anak', 'dokter_anak.kd_dokter', '=', 'operasi.dokter_anak')
            ->join('dokter as dokter_anestesi', 'dokter_anestesi.kd_dokter', '=', 'operasi.dokter_anestesi')
            ->join('petugas as asisten_operator1', 'asisten_operator1.nip', '=', 'operasi.asisten_operator1')
            ->join('petugas as asisten_operator2', 'asisten_operator2.nip', '=', 'operasi.asisten_operator2')
            ->join('petugas as asisten_operator3', 'asisten_operator3.nip', '=', 'operasi.asisten_operator3')
            ->join('petugas as asisten_anestesi', 'asisten_anestesi.nip', '=', 'operasi.asisten_anestesi')
            ->join('petugas as bidan', 'bidan.nip', '=', 'operasi.bidan')
            ->join('petugas as instrumen', 'instrumen.nip', '=', 'operasi.instrumen')
            ->join('petugas as perawaat_resusitas', 'perawaat_resusitas.nip', '=', 'operasi.perawaat_resusitas')
            ->join('billing','billing.no_rawat','=','reg_periksa.no_rawat')
            ->where('billing.no','=','No.Nota')
            ->where('penjab.kd_pj','UMU')
            ->whereBetween('billing.tgl_byr',[$tanggl1, $tanggl2])
            ->where(function ($query) use ( $kdPetugas, $kdDokter) {
                if ($kdPetugas) {
                    $query->whereIn('asisten_operator1.nip', $kdPetugas);
                }
                if ($kdDokter) {
                    $query->whereIn('operator1.kd_dokter', $kdDokter);
                }
            })
            ->where(function($query) use ($cariNomor) {
                $query->orWhere('reg_periksa.no_rawat', 'like', '%' . $cariNomor . '%');
                $query->orWhere('reg_periksa.no_rkm_medis', 'like', '%' . $cariNomor . '%');
                $query->orWhere('pasien.nm_pasien', 'like', '%' . $cariNomor . '%');
            })
            ->get();
            return view('detail-tindakan-umum.cari-oprasi-vk',[
                'action'=>$action,
                'petugas'=>$petugas,
                'dokter'=>$dokter,
                'OperasiAndVK'=>$OperasiAndVK,
            ]);
    }
}
