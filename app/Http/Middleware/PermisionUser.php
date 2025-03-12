<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermisionUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $idUser = session('auth')['id_user'];
        $permissionValue  = DB::table('user')
            ->whereRaw("aes_decrypt(user.id_user, 'nur') = ? ", [$idUser])
            ->value($permission);
            session(['permissionValue' => $permissionValue]);
        if ($permissionValue === 'true') {
            return $next($request);
        }else{
            return back();
        }
    }
}
