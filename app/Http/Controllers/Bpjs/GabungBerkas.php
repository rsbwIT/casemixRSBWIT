<?php

namespace App\Http\Controllers\Bpjs;

use setasign\Fpdi\Fpdi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GabungBerkas extends Controller
{
    function gabungBerkas(Request $request){
        $cekINACBG = DB::table('bw_file_casemix_inacbg')->where('no_rawat', $request->cariNorawat)->first();
        $cekRESUMEDLL = DB::table('bw_file_casemix_remusedll')->where('no_rawat', $request->cariNorawat)->first();
        $cekSCAN = DB::table('bw_file_casemix_scan')->where('no_rawat', $request->cariNorawat)->first();

        try {
            $pdfPathINACBG = $cekINACBG ? storage_path('app/public/file_inacbg/'.$cekINACBG->file) : null;
            $pdfPathRESUMEDLL = $cekRESUMEDLL ? storage_path('app/public/resume_dll/'.$cekRESUMEDLL->file) : null;
            $pdfPathSCAN = $cekSCAN ? storage_path('app/public/file_scan/'.$cekSCAN->file) : null;

            // Validasi ketiga file harus ada
            $missingFiles = [];
            if (!$pdfPathINACBG || !file_exists($pdfPathINACBG)) {
                $missingFiles[] = 'INACBG';
            }
            if (!$pdfPathSCAN || !file_exists($pdfPathSCAN)) {
                $missingFiles[] = 'SCAN';
            }
            if (!$pdfPathRESUMEDLL || !file_exists($pdfPathRESUMEDLL)) {
                $missingFiles[] = 'RESUMEDLL';
            }

            if (!empty($missingFiles)) {
                throw new \Exception('Berkas wajib tidak lengkap: ' . implode(', ', $missingFiles));
            }

            $pdf = new Fpdi();

            function importPages($pdf, $filePath) {
                if (!$filePath || !file_exists($filePath)) {
                    return false;
                }

                try {
                    $fileInfo = pathinfo($filePath);
                    $extension = strtolower($fileInfo['extension'] ?? '');

                    if ($extension === 'pdf') {
                        $pageCount = $pdf->setSourceFile($filePath);
                        for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
                            $template = $pdf->importPage($pageNumber);
                            $size = $pdf->getTemplateSize($template);
                            $pdf->AddPage($size['orientation'], $size);
                            $pdf->useTemplate($template);
                        }
                    } elseif (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                        $pdf->AddPage();
                        $pdf->Image($filePath, 10, 10, 190);
                    }
                    return true;
                } catch (\Exception $e) {
                    Log::error("Error import file: " . $e->getMessage());
                    return false;
                }
            }

            $importOrder = [
                'INACBG' => $pdfPathINACBG,
                'RESUMEDLL' => $pdfPathRESUMEDLL,
                'SCAN' => $pdfPathSCAN,
            ];

            foreach ($importOrder as $type => $filePath) {
                $importResult = importPages($pdf, $filePath);
                if (!$importResult) {
                    throw new \Exception("Gagal mengimpor berkas $type");
                }
            }

            $no_rawatSTR = str_replace('/', '', $request->cariNorawat);
            $path_file = 'HASIL-' . $no_rawatSTR.'.pdf';
            $outputDir = public_path('hasil_pdf');

            if (!file_exists($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            $outputPath = $outputDir . '/' . $path_file;
            $pdf->Output($outputPath, 'F');

            DB::table('bw_file_casemix_hasil')->updateOrInsert(
                ['no_rawat' => $request->cariNorawat],
                [
                    'no_rkm_medis' => $cekINACBG->no_rkm_medis ?? $cekSCAN->no_rkm_medis,
                    'file' => $path_file
                ]
            );

            if ($request->has('preview')) {
                return response()->file($outputPath);
            } else {
                return response()->download($outputPath)->deleteFileAfterSend(true);
            }

        } catch (\Exception $e) {
            Log::error("Gagal gabung berkas: " . $e->getMessage());
            return redirect()->back()->with('errorBundling', 'Gagal: ' . $e->getMessage());
        }
    }
}
