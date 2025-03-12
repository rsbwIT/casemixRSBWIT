<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class AuthRsbw
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (session()->has('auth')) {
            $idUser = session('auth')['id_user'];
            $paswdUser = session('auth')['password'];
        } else {
            Session::flash('reqLogin', 'Anda harus login');
            return redirect('/login');
        }

        // // UNTUK AUTHORIZE USER
        $cacheKey = 'user_permissions_' . $idUser;
        if (Cache::has($cacheKey)) {
            $permissionValue = Cache::get($cacheKey);
        } else {
            $permissionValue = DB::table('user')
            ->select('penyakit', 'obat', 'pasien', 'inacbg_klaim_baru_otomatis', 'edit_registrasi', 'registrasi')
            ->whereRaw("aes_decrypt(user.id_user, 'nur') = ? ", [$idUser])
            ->first();
            Cache::put($cacheKey, $permissionValue, 720);
        }
        // dd(Cache::get($cacheKey));
        session([
            'penyakit' => $permissionValue->penyakit,
            'obat' => $permissionValue->obat,
            'pasien' => $permissionValue->pasien,
            'inacbg_klaim_baru_otomatis' => $permissionValue->inacbg_klaim_baru_otomatis,
            'edit_registrasi' => $permissionValue->edit_registrasi,
            'registrasi' => $permissionValue->registrasi,
        ]);

        $result = DB::table('user')
        ->select('id_user', 'password')
        ->whereRaw("aes_decrypt(user.id_user, 'nur') = ? AND aes_decrypt(user.password, 'windi') = ?", [$idUser, $paswdUser])
        ->first();

        if(!$result){
            return redirect('/login');
        }else{
            return $next($request);
        }

    }
}
