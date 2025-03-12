<?php

namespace App\Http\Controllers\Bpjs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListPasienRalan2 extends Controller
{
    public function lisPaseinRalan2() {
         return view('bpjs.listpasien-ralan2');
    }
}
