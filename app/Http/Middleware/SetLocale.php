<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL; // Importe a Facade URL

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Pega o parâmetro 'locale' da rota
        $locale = $request->route('locale');

        // Verifica se o locale é suportado e define-o
        if (in_array($locale, ['pt', 'en', 'fr'])) {
            App::setLocale($locale);
            // Define o locale padrão para os URLs gerados (importante para o language switcher)
            URL::defaults(['locale' => $locale]);
        } else {
             // Caso contrário, usa o idioma padrão
            App::setLocale(config('app.fallback_locale'));
        }

        return $next($request);
    }
}