<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Redirect;
use Closure;
use Auth;
use Session;
use Illuminate\Http\Request;

class EnsureActiveUser
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
        if($request->user()->status != 'active') {
            Session::flash('unactive', 'برجاء العلم ان حسابكم غير مفعل يرجي التواصل مع الاداره');
            Auth::logout();
            return redirect('login');
        }
        return $next($request);
    }
}
