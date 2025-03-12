<?php

namespace App\Http\Controllers\Bpjs;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
// Import PDF processing libraries
use setasign\Fpdi\Fpdi;
use GuzzleHttp\Client;

class BpjsController extends Controller
{
    function claimBpjs(Request $request) {
        $cariNorawat = $request->input('cariNorawat');
        $cariNoSep = $request->input('cariNoSep');

        // Ambil data pasien berdasarkan nomor rawat atau SEP
        $getPasien = null;
        $berkasList = [];
        $selectedBerkasIndex = null;

        if ($cariNorawat || $cariNoSep) {
            $query = DB::table('reg_periksa')
                ->select(
                    'reg_periksa.no_rkm_medis',
                    'reg_periksa.no_rawat',
                    'reg_periksa.status_bayar',
                    DB::raw('COALESCE(bridging_sep.no_sep, "-") as no_sep'),
                    'pasien.nm_pasien',
                    'bridging_sep.tglsep'
                )
                ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
                ->leftJoin('bridging_sep', 'bridging_sep.no_rawat', '=', 'reg_periksa.no_rawat');

            if ($cariNorawat) {
                $query->where('reg_periksa.no_rawat', $cariNorawat);
            } elseif ($cariNoSep) {
                $query->where('bridging_sep.no_sep', $cariNoSep);
            }

            $getPasien = $query->first();

            // Jika pasien ditemukan, ambil berkas digital
            if ($getPasien) {
                // Ambil berkas dari database
                $berkas = DB::select("SELECT * FROM berkas_digital_perawatan WHERE no_rawat = ?", [$getPasien->no_rawat]);

                // Format data untuk konsistensi
                foreach ($berkas as $item) {
                    $berkasList[] = [
                        'id' => $item->id ?? null,
                        'kode' => $item->kode ?? null,
                        'lokasi_file' => $item->lokasi_file ?? null,
                        'no_rawat' => $item->no_rawat ?? null
                    ];
                }

                // Set index berkas pertama sebagai default jika ada
                $selectedBerkasIndex = count($berkasList) > 0 ? 0 : null;
            }
        }

        return view('bpjs.ulploadFileClaim', compact('getPasien', 'berkasList', 'selectedBerkasIndex'));
    }

    // Buat fungsi baru untuk menggabungkan PDF
    private function gabungkanPDFs($selectedFiles, $no_rawat)
    {
        try {
            $pdf = new Fpdi();
            $filesPaths = [];
            $client = new Client();
            $tempDir = sys_get_temp_dir();

            foreach ($selectedFiles as $lokasi_file) {
                $cleanPath = ltrim($lokasi_file, '/');

                // Jika path sudah dimulai dengan 'pages/upload/', hapus bagian itu
                if (strpos($cleanPath, 'pages/upload/') === 0) {
                    $cleanPath = substr($cleanPath, strlen('pages/upload/'));
                }

                $fileUrl = 'http://192.168.5.88/webapps/berkasrawat/pages/upload/' . $cleanPath;
                $tempFilePath = $tempDir . '/' . basename($cleanPath);

                try {
                    $response = $client->get($fileUrl, [
                        'sink' => $tempFilePath,
                        'timeout' => 30,
                        'connect_timeout' => 30
                    ]);

                    if (!file_exists($tempFilePath)) {
                        throw new \Exception('File tidak berhasil didownload');
                    }
                    $filesPaths[] = $tempFilePath;
                } catch (\Exception $e) {
                    continue;
                }
            }

            foreach ($filesPaths as $filePath) {
                $fileInfo = pathinfo($filePath);
                $extension = strtolower($fileInfo['extension'] ?? '');

                if ($extension === 'pdf') {
                    try {
                        $pageCount = $pdf->setSourceFile($filePath);
                        for ($i = 1; $i <= $pageCount; $i++) {
                            $template = $pdf->importPage($i);
                            $size = $pdf->getTemplateSize($template);

                            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                            $pdf->useTemplate($template);
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                } else if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                    try {
                        $pdf->AddPage();
                        $pdf->Image($filePath, 10, 10, 190);
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }

            $outputFilename = 'Gabungan_' . count($filesPaths) . '_Berkas_' . str_replace('/', '_', $no_rawat) . '.pdf';
            $outputPath = $tempDir . '/' . $outputFilename;
            $pdf->Output('F', $outputPath);

            foreach ($filesPaths as $filePath) {
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            return $outputPath;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error gabungkanPDFs: " . $e->getMessage());
            throw $e;
        }
    }

    // Modifikasi fungsi uploadBerkas
    public function inputClaimBpjs(Request $request)
    {
        // Validasi wajib di awal
        if (!$request->hasFile('file_inacbg')) {
            return redirect()->back()->with('error', 'File INACBG wajib diupload');
        }

        if (!$request->hasFile('file_scan') && !$request->filled('selected_scan')) {
            return redirect()->back()->with('error', 'File SCAN wajib diupload atau dipilih dari berkas digital');
        }

        // Pindahkan validasi session token ke sini
        if (!Session::token() === $request->_token) {
            abort(419, 'Session expired');
        }

        $scanProvided = $request->hasFile('file_scan') || $request->filled('selected_scan');
        if (!$scanProvided) {
            Session::flash('error', 'File SCAN wajib diupload atau dipilih dari berkas digital');
            return redirect()->back();
        }

        // Berkas INACBG
        if ($request->hasFile('file_inacbg')) {
            $file = $request->file('file_inacbg');
            $no_rawatSTR = str_replace('/', '', $request->no_rawat);
            $path_file = 'INACBG' . '-' . $no_rawatSTR. '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('file_inacbg/' . $path_file, file_get_contents($file));
            $cekBerkas = DB::table('bw_file_casemix_inacbg')->where('no_rawat', $request->no_rawat)
                ->exists();
            if (!$cekBerkas){
                DB::table('bw_file_casemix_inacbg')->insert([
                    'no_rkm_medis' => $request->no_rkm_medis,
                    'no_rawat' => $request->no_rawat,
                    'file' => $path_file,
                ]);
            }
        }

        // Bagian untuk SCAN
        $scanProcessed = false;

        // Prioritas 1: Upload file manual
        if ($request->hasFile('file_scan') && $request->file('file_scan')->isValid()) {
            $file = $request->file('file_scan');
            $no_rawatSTR = str_replace('/', '', $request->no_rawat);
            $path_file = 'SCAN-' . $no_rawatSTR . '.' . $file->getClientOriginalExtension();

            // Pastikan direktori storage ada
            $storage_path = Storage::disk('public')->path('file_scan');
            if (!file_exists($storage_path)) {
                mkdir($storage_path, 0755, true);
            }

            Storage::disk('public')->put('file_scan/' . $path_file, file_get_contents($file));

            // Cek apakah file berhasil disimpan
            if (!Storage::disk('public')->exists('file_scan/' . $path_file)) {
                throw new \Exception('Gagal menyimpan file SCAN');
            }

            DB::table('bw_file_casemix_scan')->updateOrInsert(
                ['no_rawat' => $request->no_rawat],
                [
                    'no_rkm_medis' => $request->no_rkm_medis,
                    'file' => $path_file,
                ]
            );

            $scanProcessed = true;
        }

        // Prioritas 2: Berkas pilihan dari modal
        if (!$scanProcessed && $request->filled('selected_scan')) {
            try {
                $selectedScan = $request->selected_scan;
                $selectedFiles = json_decode($selectedScan, true) ?: [$selectedScan];

                if (count($selectedFiles) > 1) {
                    try {
                        $outputPath = $this->gabungkanPDFs($selectedFiles, $request->no_rawat);
                        // Simpan PDF gabungan
                        $no_rawatSTR = str_replace('/', '', $request->no_rawat);
                        $newFileName = 'SCAN-' . $no_rawatSTR . '.pdf';

                        // Pastikan direktori storage ada
                        $storage_path = Storage::disk('public')->path('file_scan');
                        if (!file_exists($storage_path)) {
                            mkdir($storage_path, 0755, true);
                        }

                        // Pindahkan file ke storage
                        if (!file_exists($outputPath)) {
                            throw new \Exception('File hasil gabungan tidak ditemukan: ' . $outputPath);
                        }

                        Storage::disk('public')->put('file_scan/' . $newFileName, file_get_contents($outputPath));

                        // Hapus file temporary
                        if (file_exists($outputPath)) {
                            unlink($outputPath);
                        }

                        // Simpan ke database dengan pengecekkan tambahan
                        $insertData = [
                            'no_rkm_medis' => $request->no_rkm_medis,
                            'file' => $newFileName,
                        ];

                        DB::table('bw_file_casemix_scan')->updateOrInsert(
                            ['no_rawat' => $request->no_rawat],
                            $insertData
                        );
                    } catch (\Exception $e) {
                        throw new \Exception('Gagal menggabungkan PDF: ' . $e->getMessage());
                    }
                } else {
                    // Jika hanya satu file, perlu mengunduh file terlebih dahulu
                    $fileUrl = $selectedFiles[0];
                    $no_rawatSTR = str_replace('/', '', $request->no_rawat);
                    $newFileName = 'SCAN-Single-' . $no_rawatSTR . '.pdf';

                    // Coba unduh file dari server Khanza
                    try {
                        $cleanPath = ltrim($fileUrl, '/');
                        // Jika path sudah dimulai dengan 'pages/upload/', hapus bagian itu
                        if (strpos($cleanPath, 'pages/upload/') === 0) {
                            $cleanPath = substr($cleanPath, strlen('pages/upload/'));
                        }

                        $fullUrl = 'http://192.168.5.88/webapps/berkasrawat/pages/upload/' . $cleanPath;

                        $client = new \GuzzleHttp\Client();
                        $tempFile = tempnam(sys_get_temp_dir(), 'scan_pdf_');

                        $response = $client->get($fullUrl, [
                            'sink' => $tempFile,
                            'timeout' => 30,
                            'connect_timeout' => 30
                        ]);

                        // Pastikan direktori storage ada
                        $storage_path = Storage::disk('public')->path('file_scan');
                        if (!file_exists($storage_path)) {
                            mkdir($storage_path, 0755, true);
                        }

                        // Simpan file yang diunduh ke storage
                        Storage::disk('public')->put('file_scan/' . $newFileName, file_get_contents($tempFile));

                        // Hapus file temporary
                        if (file_exists($tempFile)) {
                            unlink($tempFile);
                        }

                        // Simpan referensi file ke database
                        DB::table('bw_file_casemix_scan')->updateOrInsert(
                            ['no_rawat' => $request->no_rawat],
                            [
                                'no_rkm_medis' => $request->no_rkm_medis,
                                'file' => $newFileName,
                            ]
                        );
                    } catch (\Exception $e) {
                        throw new \Exception('Gagal mengunduh file: ' . $e->getMessage());
                    }
                }
            } catch (\Exception $e) {
                throw new \Exception('Gagal menyimpan berkas pilihan');
            }
        }

        Session::flash('successSaveINACBG', 'INACBG / SCAN');
        $redirectUrl = url('/casemix-home-cari');
        $csrfToken = Session::token();
        $cariNoSep = $request->no_sep;
        $cariNoRawat = $request->no_rawat;
        $redirectUrlWithToken = $redirectUrl . '?' . http_build_query(['_token' => $csrfToken, 'cariNorawat' => $cariNoSep, 'cariNorawat' => $cariNoRawat,]);
        return redirect($redirectUrlWithToken)->with('successSaveINACBG', 'INACBG / SCAN');
    }

    // Tambahkan metode untuk menangani pemilihan berkas
    public function showBerkas(Request $request)
    {
        try {
            $noRawat = $request->input('no_rawat');
            $index = $request->input('index');

            // Logika untuk menampilkan berkas
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Method untuk gabung dan download berkas langsung
    public function gabungDanDownloadBerkas(Request $request)
    {
        $no_rawat = $request->input('no_rawat');
        $selected_files = $request->input('selected_files', []);

        try {
            // Jika tidak ada file yang dipilih, ambil semua berkas
            if (empty($selected_files)) {
                $berkasList = DB::select("SELECT * FROM berkas_digital_perawatan WHERE no_rawat = ?", [$no_rawat]);
            } else {
                // Jika ada file yang dipilih, ambil hanya berkas yang dipilih
                $placeholders = implode(',', array_fill(0, count($selected_files), '?'));
                $params = array_merge([$no_rawat], $selected_files);
                $berkasList = DB::select(
                    "SELECT * FROM berkas_digital_perawatan WHERE no_rawat = ? AND lokasi_file IN ($placeholders)",
                    $params
                );
            }

            if (empty($berkasList)) {
                Session::flash('errorGabung', 'Tidak ada berkas digital yang tersedia');
                return redirect()->back();
            }

            // Buat file PDF gabungan menggunakan FPDI
            $pdf = new Fpdi();
            $pageCount = 0;
            $filesPaths = [];

            // Download semua file ke temporary directory
            $client = new Client();
            $tempDir = sys_get_temp_dir();
            $hasBerkas = false;

            foreach ($berkasList as $berkas) {
                $lokasi_file = $berkas->lokasi_file;
                $cleanPath = ltrim($lokasi_file, '/');

                // Jika path sudah dimulai dengan 'pages/upload/', hapus bagian itu
                if (strpos($cleanPath, 'pages/upload/') === 0) {
                    $cleanPath = substr($cleanPath, strlen('pages/upload/'));
                }

                $fileUrl = 'http://192.168.5.88/webapps/berkasrawat/pages/upload/' . $cleanPath;
                $tempFilePath = $tempDir . '/' . basename($cleanPath);

                try {
                    // Download file
                    $response = $client->get($fileUrl, [
                        'sink' => $tempFilePath,
                        'timeout' => 30,
                        'connect_timeout' => 30
                    ]);

                    if (!file_exists($tempFilePath)) {
                        throw new \Exception('File tidak berhasil didownload: ' . $tempFilePath);
                    }

                    $filesPaths[] = $tempFilePath;
                    $hasBerkas = true;
                } catch (\Exception $e) {
                    continue;
                }
            }

            if (!$hasBerkas) {
                Session::flash('errorGabung', 'Tidak dapat mengakses berkas digital');
                return redirect()->back();
            }

            // Tambahkan halaman dari file yang didownload
            foreach ($filesPaths as $filePath) {
                // Tentukan jenis file
                $fileInfo = pathinfo($filePath);
                $extension = strtolower($fileInfo['extension'] ?? '');

                // Jika file adalah PDF
                if ($extension === 'pdf') {
                    try {
                        $pageCount = $pdf->setSourceFile($filePath);

                        for ($i = 1; $i <= $pageCount; $i++) {
                            $template = $pdf->importPage($i);
                            $size = $pdf->getTemplateSize($template);

                            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                            $pdf->useTemplate($template);
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
                // Jika file adalah gambar
                else if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                    try {
                        $pdf->AddPage();
                        $pdf->Image($filePath, 10, 10, 190);
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }

            // Buat nama file untuk hasil gabungan
            $filesCount = count($filesPaths);
            $outputFilename = 'Gabungan_' . $filesCount . '_Berkas_' . str_replace('/', '_', $no_rawat) . '.pdf';

            // Output PDF langsung ke browser untuk download
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="'.$outputFilename.'"');
            header('Cache-Control: max-age=0');

            // Keluarkan output ke browser
            $pdf->Output('D', $outputFilename);

            // Bersihkan file temporary
            foreach ($filesPaths as $filePath) {
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Fungsi ini tidak perlu return karena output langsung ke browser
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error gabungDanDownload: " . $e->getMessage());
            throw $e;
        }
    }
}
