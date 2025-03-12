<?php

namespace App\Http\Controllers\Bpjs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingBpjs extends Controller
{
    function settingBpjsCasemix() {
        return view('bpjs.setting-bpjs');
    }
}
