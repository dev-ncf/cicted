<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration; // Importa o nosso Model
use Illuminate\Support\Facades\Validator; // Importa a Facade de Validação
 use App\Mail\EnviarEmail;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    /**
     * Armazena uma nova inscrição na base de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. VALIDAÇÃO DOS DADOS
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'full_names' => 'required|string|max:255',
            'academic_level' => 'required|string|in:doutor,mestre,licenciado,medio',
            'occupation' => 'required|string|in:estudante_graduacao,estudante_pos_graduacao,docente,investigador',
            'institution_country' => 'required|string|max:255',
            'tipo_participante' => 'required|string|in:orador,ouvinte',
            'email' => 'required|email',

            // Regras condicionais: só são obrigatórias se o participante for 'orador'
            'presentation_modality' => 'required_if:tipo_participante,orador|string|in:mesa_redonda,comunicacao_oral,poster',
            'thematic_axis' => 'required_if:tipo_participante,orador|string|in:1,2,3,4,5,6',
            'abstract_content' => 'required_if:tipo_participante,orador|string|max:5000|nullable', // max 5000 caracteres para o resumo
            'keywords' => 'required_if:tipo_participante,orador|string|max:255|nullable',
            'resumo_file' => 'required_if:tipo_participante,orador|file|mimes:doc,docx|max:10240', // max 10MB (10 * 1024)
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $validatedData = $validator->validated();
        
        $filePath = null;

        // 2. TRATAMENTO DO UPLOAD DO FICHEIRO
        if ($request->hasFile('resumo_file')) {
            // Armazena o ficheiro em 'storage/app/public/abstracts' e obtém o caminho
            $filePath = $request->file('resumo_file')->store('abstracts', 'public');
        }

        // 3. ARMAZENAMENTO NA BASE DE DADOS
        Registration::create([
            'full_names' => $validatedData['full_names'],
            // 'email' => $validatedData['email'],
            'academic_level' => $validatedData['academic_level'],
            'occupation' => $validatedData['occupation'],
            'institution_country' => $validatedData['institution_country'],
            'participant_type' => $validatedData['tipo_participante'],
            'presentation_modality' => $validatedData['presentation_modality'] ?? null,
            'thematic_axis' => $validatedData['thematic_axis'] ?? null,
            'abstract_content' => $validatedData['abstract_content'] ?? null,
            'keywords' => $validatedData['keywords'] ?? null,
            'abstract_filepath' => $filePath,
        ]);
        Mail::to($validatedData['email'])->send(new EnviarEmail(
        $validatedData['full_names'],
        $validatedData['tipo_participante'],
    ));
        // 4. REDIRECIONAMENTO COM MENSAGEM DE SUCESSO
        return redirect()->back()->with('success', 'Inscrição submetida com sucesso! Um email de confirmacao foi enviado para o endeco fornecido! Obrigado por se juntar a nós.');
    }
}