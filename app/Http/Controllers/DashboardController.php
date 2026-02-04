<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration; 
use App\Models\Submission; 
use App\Models\User; 
use App\Models\Thematic_area; 
use App\Models\Comprovativo; 
use App\Models\Datas; 
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
        // dd(auth()->id());
        $registrations = Registration::latest()->paginate(15);
        $submission = Submission::where('author_id',auth()->id())->with('thematic')->first();
        $comprovativo = Comprovativo::where('submission_id',$submission->id??null)->first()??null;
        $datas = Datas::all();
        // dd($registration->thematic);

        // --- 3. Enviar os Dados para a View ---
        $users = User::all();
        $user = User::find(auth()->id());
    
        $thematic_areas = Thematic_area::all();
        return view('director.dashboard', [
            'stats' => $stats,
            'registrations' => $registrations,
            'users' => $users,
            'thematic_areas' => $thematic_areas,
            'registration' => $submission,
            'comprovativo' => $comprovativo,
            'datas' => $datas,
            'user' => $user,
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