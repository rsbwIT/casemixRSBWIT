<?php

namespace App\Http\Controllers\Keperawatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengawasKeperawatan extends Controller
{
    function PengawasKeperawatan() {
        return view('keperawatan.keperawatan');
    }

    function InputKegiatanLain() {
         return view('keperawatan.kegiatan-lain-keperawatan');
    }

    function InputKegiatankaru() {
         return view('keperawatan.kegiatan-karu');
    }
}
