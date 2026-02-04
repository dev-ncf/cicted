<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SubmissionController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Submission $submission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submission $submission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Submission $submission)
    {
        //
        $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'abstract_content' => 'required|string|min:50',
        'abstract_filepath' => 'nullable|file|mimes:doc,docx|max:2048', // opcional
    ]);

    // Atualiza campos de texto primeiro
    $submission->title = $validatedData['title'];
    $submission->abstract = $validatedData['abstract_content'];

    // 🔹 Só mexe no ficheiro SE o usuário enviar um novo
    if ($request->hasFile('abstract_filepath')) {

        // Apaga o ficheiro antigo (se existir)
        if ($submission->abstract_filepath) {
            Storage::disk('public')->delete($submission->abstract_filepath);
        }

        // Faz upload do novo ficheiro
         $file = $request->file('abstract_filepath');
        $user = User::find(auth()->id());
        $newName = 'abstract_' . $user->name . '.' . $file->getClientOriginalExtension();

         $path = $file->storeAs('abstracts', $newName, 'public');

        // Guarda o novo caminho
        $submission->abstract_filepath = $path;
    }

    $submission->save();

    return back()->with('success', 'Atualizado com sucesso!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $submission)
    {
        //
    }
}
