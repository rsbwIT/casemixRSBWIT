<?php

namespace App\Http\Controllers\AntrianPoli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BwJadwaldokter extends Controller
{
    public function BwJadwaldokter() {
        return view('antrian-poli.jadwal-dokter');
    }
}
