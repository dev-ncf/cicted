<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration; // Não se esqueça de importar o seu Model
use App\Models\User; // Não se esqueça de importar o seu Model
use App\Models\Thematic_area; // Não se esqueça de importar o seu Model
use App\Http\Controllers\Storage;


class DashboardController extends Controller
{
    /**
     * Mostra a página principal do dashboard com estatísticas e a lista de inscrições.
     */
    public function index()
    {
        // --- 1. Calcular as Estatísticas ---
        $stats = [
            'total' => Registration::count(),
            'speakers' => Registration::where('participant_type', 'orador')->count(),
            'attendees' => Registration::where('participant_type', 'ouvinte')->count(),
        ];

        // --- 2. Obter a Lista de Inscrições ---
        // Usamos latest() para mostrar as mais recentes primeiro
        // Usamos paginate(15) para mostrar 15 resultados por página
        $registrations = Registration::latest()->paginate(15);

        // --- 3. Enviar os Dados para a View ---
        $users = User::all();
        $thematic_areas = Thematic_area::all();
        return view('dashboard', [
            'stats' => $stats,
            'registrations' => $registrations,
            'users' => $users,
            'thematic_areas' => $thematic_areas
        ]);
    }
    public function destroyRegistration($id)
{
    $registration = Registration::findOrFail($id);
    
    // Se tiver ficheiro, apagar do disco
    if ($registration->abstract_filepath) {
        Storage::disk('public')->delete($registration->abstract_filepath);
    }
    
    $registration->delete();
    
    return back()->with('success', 'Inscrição eliminada com sucesso!');
}
}