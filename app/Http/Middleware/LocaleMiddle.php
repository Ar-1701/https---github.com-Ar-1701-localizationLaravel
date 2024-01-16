<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Language;

class LocaleMiddle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang_id  = Session::get('langId');
        $lang  = Session::get('lang');
        if ($lang_id != '') {
            App::setLocale($lang);
        } else {
            App::setLocale(App::currentLocale());
            $l = Language::whereRaw('lang=?', App::currentLocale())->first();
            Session::put('langId', $l->id);
            Session::put('lang', $l->lang);
        }
        return $next($request);
    }
}
