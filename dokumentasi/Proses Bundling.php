<?php
    $noRawat = $request->cariNorawat;
    $cekNorawat = DB::table('reg_periksa')
        ->select('reg_periksa.status_lanjut', 'pasien.nm_pasien', 'reg_periksa.no_rkm_medis')
        ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
        ->where('no_rawat', '=', $noRawat);
    $getpasien = $cekNorawat->first();
    // INACBG
    $cekINACBG = DB::table('file_casemix')->where('no_rawat', $noRawat)
            ->where('jenis_berkas', 'INACBG')
            ->first();
    // RESEUMEDLL
    $cekRESUMEDLL = DB::table('file_casemix')->where('no_rawat', $noRawat)
    ->where('jenis_berkas', 'RESUMEDLL')
    ->first();
    // SCAN
    $cekSCAN = DB::table('file_casemix')->where('no_rawat', $noRawat)
    ->where('jenis_berkas', 'SCAN')
    ->first();

 // PROSES BNDLING=============================================
     $pdf = new Fpdi();
     if (!$cekSCAN){
         $pdfPathINACBG = public_path('storage/file_inacbg/'.$cekINACBG->file);
         $pdfPathRESUMEDLL = public_path('storage/resume_dll/'.$cekRESUMEDLL->file);
         // INACBG
         $pageCountINACBG = $pdf->setSourceFile($pdfPathINACBG);
         for ($pageNumber = 1; $pageNumber <= $pageCountINACBG; $pageNumber++) {
             $template = $pdf->importPage($pageNumber);
             $size = $pdf->getTemplateSize($template);
             $pdf->AddPage($size['orientation'], $size);
             $pdf->useTemplate($template);
         }
         // RESEUMEDLL
         $pageCountRESUMEDLL = $pdf->setSourceFile($pdfPathRESUMEDLL);
         for ($pageNumber = 1; $pageNumber <= $pageCountRESUMEDLL; $pageNumber++) {
             $template = $pdf->importPage($pageNumber);
             $size = $pdf->getTemplateSize($template);
             $pdf->AddPage($size['orientation'], $size);
             $pdf->useTemplate($template);
         }
     }else{
         $pdfPathINACBG = public_path('storage/file_inacbg/'.$cekINACBG->file);
         $pdfPathRESUMEDLL = public_path('storage/resume_dll/'.$cekRESUMEDLL->file);
         $pdfPathSCAN = public_path('storage/file_scan/'.$cekSCAN->file);
         // INACBG
         $pageCountINACBG = $pdf->setSourceFile($pdfPathINACBG);
         for ($pageNumber = 1; $pageNumber <= $pageCountINACBG; $pageNumber++) {
             $template = $pdf->importPage($pageNumber);
             $size = $pdf->getTemplateSize($template);
             $pdf->AddPage($size['orientation'], $size);
             $pdf->useTemplate($template);
         }
         // RESEUMEDLL
         $pageCountRESUMEDLL = $pdf->setSourceFile($pdfPathRESUMEDLL);
         for ($pageNumber = 1; $pageNumber <= $pageCountRESUMEDLL; $pageNumber++) {
             $template = $pdf->importPage($pageNumber);
             $size = $pdf->getTemplateSize($template);
             $pdf->AddPage($size['orientation'], $size);
             $pdf->useTemplate($template);
         }
         // SCAN
         $pageCountSCAN = $pdf->setSourceFile($pdfPathSCAN);
         for ($pageNumber = 1; $pageNumber <= $pageCountSCAN; $pageNumber++) {
             $template = $pdf->importPage($pageNumber);
             $size = $pdf->getTemplateSize($template);
             $pdf->AddPage($size['orientation'], $size);
             $pdf->useTemplate($template);
         }
     }
     $no_rawatSTR = str_replace('/', '', $noRawat);
     $path_file = 'HASIL' . '-' . $no_rawatSTR.'.pdf';
     $outputPath = public_path('hasil_pdf/'.$path_file);
     $pdf->Output($outputPath, 'F');

     $cekBerkas = DB::table('file_casemix')->where('no_rawat', $noRawat)
         ->where('jenis_berkas', 'HASIL')
         ->exists();
     if (!$cekBerkas){
         DB::table('file_casemix')->insert([
             'no_rkm_medis' => $getpasien->no_rkm_medis,
             'no_rawat' => $noRawat,
             'nama_pasein' => $getpasien->nm_pasien,
             'jenis_berkas' => 'HASIL',
             'file' => $path_file,
         ]);
     }
     Session::forget('tgl1');
     Session::forget('tgl2');
     // Session::forget('page');
     Session::forget('statusLanjut');
     if ($request->statusLanjut === 'Ranap') {
         return redirect('/cari-list-pasein-ranap?tgl1=' . $request->tgl1 . '&tgl2=' . $request->tgl2);
     }else{
         return redirect('/cari-list-pasein-ralan?tgl1=' . $request->tgl1 . '&tgl2=' . $request->tgl2 /*. '&page='. $request->page*/);
     }




    //  ===============================================================
    // PROSES BUNDLING 2
    $cekNorawat = DB::table('reg_periksa')
            ->select('reg_periksa.status_lanjut', 'pasien.nm_pasien', 'reg_periksa.no_rkm_medis')
            ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->where('no_rawat', '=', $request->cariNorawat);
        $getpasien = $cekNorawat->first();

        $fileCasemix = DB::table('file_casemix')
            ->where('no_rawat', $request->cariNorawat)
            ->whereIn('jenis_berkas', ['INACBG', 'RESUMEDLL', 'SCAN'])
            ->get();
        $cekINACBG = $fileCasemix->where('jenis_berkas', 'INACBG')->first();
        $cekRESUMEDLL = $fileCasemix->where('jenis_berkas', 'RESUMEDLL')->first();
        $cekSCAN = $fileCasemix->where('jenis_berkas', 'SCAN')->first();

        // PROSES BNDLING=============================================
        try {
            $pdfPathINACBG = $cekINACBG ? public_path('storage/file_inacbg/'.$cekINACBG->file) : null;
            $pdfPathRESUMEDLL = $cekRESUMEDLL ? public_path('storage/resume_dll/'.$cekRESUMEDLL->file) : null;
            $pdfPathSCAN = $cekSCAN ? public_path('storage/file_scan/'.$cekSCAN->file) : null;
            $pdf = new Fpdi();
            function importPages($pdf, $pdfPath)
            {
                $pageCount = $pdf->setSourceFile($pdfPath);
                for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
                    $template = $pdf->importPage($pageNumber);
                    $size = $pdf->getTemplateSize($template);
                    $pdf->AddPage($size['orientation'], $size);
                    $pdf->useTemplate($template);
                }
            }
            importPages($pdf, $pdfPathINACBG);
            importPages($pdf, $pdfPathRESUMEDLL);

            if ($pdfPathSCAN) {
                importPages($pdf, $pdfPathSCAN);
            }
            $no_rawatSTR = str_replace('/', '', $request->cariNorawat);
            $path_file = 'HASIL' . '-' . $no_rawatSTR.'.pdf';
            $outputPath = public_path('hasil_pdf/'.$path_file);
            $pdf->Output($outputPath, 'F');
            DB::beginTransaction();

                $cekBerkas = DB::table('file_casemix')
                    ->where('no_rawat', $request->cariNorawat)
                    ->where('jenis_berkas', 'HASIL')
                    ->exists();
                if (!$cekBerkas) {
                    DB::table('file_casemix')->insert([
                        'no_rkm_medis' => $getpasien->no_rkm_medis,
                        'no_rawat' => $request->cariNorawat,
                        'nama_pasein' => $getpasien->nm_pasien,
                        'jenis_berkas' => 'HASIL',
                        'file' => $path_file,
                    ]);
                    DB::commit();
                }

            Session::forget('tgl1');
            Session::forget('tgl2');
            // Session::forget('page');
            Session::forget('statusLanjut');
            if ($request->statusLanjut === 'Ranap') {
                return redirect('/cari-list-pasein-ranap?tgl1=' . $request->tgl1 . '&tgl2=' . $request->tgl2);
            }else{
                return redirect('/cari-list-pasein-ralan?tgl1=' . $request->tgl1 . '&tgl2=' . $request->tgl2 /*. '&page='. $request->page*/);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('errorBundling', 'Gagal Menggabungkan Berkas, Silahkan Upload File Inacbg Dan simpan File Kahnza.');
        }
