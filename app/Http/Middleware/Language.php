<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class Language
{

    public function handle($request, Closure $next, $guard = null)
    {  
       if($request->session()->has('language')){  
           App::setLocale($request->session()->get('language'));  
       }else{  
           App::setLocale(Config::get('app.fallback_locale'));  
       }  
       return $next($request);  
    } 
}
