<?php

namespace App\Http\Controllers;

use App\Models\Comprovativo;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;

class ComprovativoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Submission $submission)
    {
        //
 $validatedData = $request->validate([
        'submission_id' => 'required|exists:submissions,id',
        'file' => 'required|file|mimes:pdf|max:2048', 
    ]);

    // 🔹 Só mexe no ficheiro SE o usuário enviar um novo
    if ($request->hasFile('file')) {

        // Faz upload do novo ficheiro
         $file = $request->file('file');
        $user = User::find(auth()->id());
        $newName = 'comprovativo_' . $user->name . '.' . $file->getClientOriginalExtension();

         $path = $file->storeAs('comprovativos', $newName, 'public');

        // Guarda o novo caminho
        $submission->abstract_filepath = $path;
    }
    $comprovativo = Comprovativo::create([
        'submission_id'=>$validatedData['submission_id'],
        'file'=>$path

    ]);

    return back()->with('success', 'Comprovativo submetido com sucesso!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Comprovativo $comprovativo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comprovativo $comprovativo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comprovativo $comprovativo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comprovativo $comprovativo)
    {
        //
    }
}
