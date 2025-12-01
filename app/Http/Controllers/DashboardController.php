<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration; // Não se esqueça de importar o seu Model

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
        return view('dashboard', [
            'stats' => $stats,
            'registrations' => $registrations
        ]);
    }
}