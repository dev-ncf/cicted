<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration; // Importa o nosso Model
use App\Models\Submission; // Importa o nosso Model
use App\Models\User; // Importa o nosso Model
use Illuminate\Support\Facades\Validator; // Importa a Facade de Validação
 use App\Mail\EnviarEmail;
 use Illuminate\Support\Facades\App; // CORRETO

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
        $locale = $request->get('lang'); // pega ?lang=pt ou default pt
         App::setLocale($locale);

        //  dd($locale);
        // 1. VALIDAÇÃO DOS DADOS
        // dd($request->all());
         // 2. Mensagens personalizadas, condicionadas pelo locale
        $messages = [
            'full_names.required' => __('validation.full_names.required'),
            'full_names.string' => __('validation.full_names.string'),
            'full_names.max' => __('validation.full_names.max'),

             'academic_level.required' => __('validation.academic_level_required'),
            'academic_level.in' => __('validation.academic_level_in'),

             'occupation.required' => __('validation.occupation_required'),
            'occupation.in' => __('validation.occupation_in'),

            'email.required' => __('validation.email.required'),
            'email.email' => __('validation.email.email'),

            'tipo_participante.required' => __('validation.tipo_participante.required'),
            'tipo_participante.in' => __('validation.tipo_participante.in'),

            'presentation_modality.required_if' => __('validation.presentation_modality.required_if'),
            'presentation_modality.in' => __('validation.presentation_modality.in'),

            'thematic_axis.required_if' => __('validation.thematic_axis.required_if'),
            'thematic_axis.in' => __('validation.thematic_axis.in'),

            'abstract_content.required_if' => __('validation.abstract_content.required_if'),
            'abstract_content.max' => __('validation.abstract_content.max'),

            'keywords.required_if' => __('validation.keywords.required_if'),
            'keywords.max' => __('validation.keywords.max'),

            'resumo_file.required_if' => __('validation.resumo_file.required_if'),
            'resumo_file.file' => __('validation.resumo_file.file'),
            'resumo_file.mimes' => __('validation.resumo_file.mimes'),
            'resumo_file.max' => __('validation.resumo_file.max'),
        ];

        // 3. Validação
        $validator = Validator::make($request->all(), [
            'full_names' => 'required|string|max:255',
            'tratamento' => 'required|string|in:Dr.,Dra.,Sr.,Sra.,Prof. Doutora,Prof. Doutor',
            'academic_level' => 'required|string|in:doutor,mestre,licenciado,medio',
            'occupation' => 'required|string|in:estudante_graduacao,estudante_pos_graduacao,docente,investigador',
            'institution' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'tipo_participante' => 'required|string|in:orador,ouvinte',
            'email' => 'required|email',

            // Campos condicionais para oradores
            'title' => 'required_if:tipo_participante,orador|string',
            'presentation_modality' => 'required_if:tipo_participante,orador|string|in:mesa_redonda,comunicacao_oral,poster',
            'thematic_axis' => 'required_if:tipo_participante,orador|string|in:1,2,3,4,5,6',
            'abstract_content' => 'required_if:tipo_participante,orador|string|max:5000|nullable',
            'keywords' => 'required_if:tipo_participante,orador|string|max:255|nullable',
            'resumo_file' => 'required_if:tipo_participante,orador|file|mimes:doc,docx|max:10240',
        ], $messages);

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
            'tratamento' => $validatedData['tratamento'],
            'academic_level' => $validatedData['academic_level'],
            'occupation' => $validatedData['occupation'],
            'institution' => $validatedData['institution'],
            'country' => $validatedData['country'],
            'participant_type' => $validatedData['tipo_participante'],
            'presentation_modality' => $validatedData['presentation_modality'] ?? null,
            'thematic_axis' => $validatedData['thematic_axis'] ?? null,
            'abstract_content' => $validatedData['abstract_content'] ?? null,
            'keywords' => $validatedData['keywords'] ?? null,
            'abstract_filepath' => $filePath,
        ]);
        if ($validatedData['tipo_participante']=='orador') {
            # code...
            $senha = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $user = User::create([
                'name'=>$validatedData['full_names'],
                'email'=>$validatedData['email'],
                'role_id'=>'4',
            
                'password'=>bcrypt($senha),
            ]);
            $submission = Submission::create([
                'title'=>$validatedData['title'],
                'abstract'=>$validatedData['abstract_content'],
                'author_id'=>$user->id,
                'thematic_area_id'=>$validatedData['thematic_axis'],
                

            ]);
            Mail::to($validatedData['email'])->send(new EnviarEmail(
            $validatedData['full_names'],
            $validatedData['tipo_participante'],
            $user['email'],
            $senha,
        ));
        }else{
            Mail::to($validatedData['email'])->send(new EnviarEmail(
            $validatedData['full_names'],
            $validatedData['tipo_participante'],
            null,
            'null',
        ));

        }
        // 4. REDIRECIONAMENTO COM MENSAGEM DE SUCESSO
        return redirect()->back()->with('success', 'Inscrição submetida com sucesso! Um email de confirmacao foi enviado para o endeco fornecido! Obrigado por se juntar a nós.');
    }
}