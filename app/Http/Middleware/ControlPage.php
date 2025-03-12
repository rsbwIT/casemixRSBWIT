<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ControlPage
{
    /**
     * Handle an incoming request.
     *
     * // dd($encryptedData = Crypt::encryptString('d-m-Y'));
        // dd($encryptedData = Crypt::decryptString('?'));
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
            return $next($request);
    }
    private function checkPermision()
    {

    }
}
