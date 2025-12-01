<?php


use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetLocale; // <-- 1. Importe o middleware aqui
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;

Route::middleware(['auth'])->group(function () {
    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rotas para Gerir Inscrições (Apagar)
    Route::delete('/registrations/{id}', [DashboardController::class, 'destroyRegistration'])->name('registration.destroy');
    
    // Rotas para Gerir Utilizadores (Criar, Listar, Apagar)
    Route::resource('users', UserController::class);
    Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rota para redirecionar o acesso à raiz (/) para o idioma padrão do browser ou o fallback
Route::get('/', function () {
    // Pode adicionar uma lógica mais inteligente aqui se quiser
    $locale = config('app.fallback_locale'); 
    return redirect()->route('welcome', ['locale' => $locale]);
});


// 2. Crie o grupo de rotas com o prefixo e aplique o middleware
Route::prefix('{locale}')
    ->where(['locale' => '[a-z]{2}']) // Garante que {locale} seja 2 letras
    ->middleware(SetLocale::class)    // <-- 3. Aplique o middleware diretamente aqui
    ->group(function () {
        
        // A sua página de boas-vindas
        Route::get('/', function () {
            return view('welcome');
        })->name('welcome'); // O nome da rota é essencial para o seletor de idiomas
        Route::get('/inscricao', function () {
            return view('inscricao');
        })->name('registration.form');

          Route::post('/inscricao', [RegistrationController::class, 'store'])->name('registration.store');

        // Adicione aqui as suas outras rotas que também serão multilingues
        // Ex: Route::get('/inscricao', ...)->name('registration.form');
        // Ex: Route::get('/termos', ...)->name('terms');
    });

    // Rota para mostrar o formulário de login
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');

// Rota para processar o login
Route::post('login', [AuthenticatedSessionController::class, 'store']);

// Rota para fazer logout
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rota do Dashboard PROTEGIDA
