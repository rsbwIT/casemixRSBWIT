<?php

namespace App\Http\Controllers\Farmasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MinimalStokController extends Controller
{
    function MinimalStokObat(Request $request) {
        $bangsal = '';
        return view('farmasi.minimal-stok-obat',[
            'bangsal'=>$bangsal
        ]);
    }
}
