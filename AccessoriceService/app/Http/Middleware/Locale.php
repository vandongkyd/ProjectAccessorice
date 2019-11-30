<?php

namespace App\Http\Middleware;

use Closure;


class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        $language = 'en';
//
//        config(['app.locale' => $language]);
//        \App::setLocale($language);

        return $next($request);
    }
}
