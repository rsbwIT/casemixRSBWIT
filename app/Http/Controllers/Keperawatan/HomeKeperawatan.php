<?php

namespace App\Http\Controllers\Keperawatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeKeperawatan extends Controller
{
    function HomeKeperawatan() {
        return view('keperawatan.home-keprawtan');
    }
}
