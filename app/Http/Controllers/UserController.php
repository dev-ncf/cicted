<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::paginate(5);
         return view('admin.usuarios',compact('users'));
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
        

         // Validação dos dados
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4|confirmed',
            'thematic_area_id' => 'required|exists:thematic_areas,id',
            'role_id' => 'required|exists:roles,id',
        ]);
        // dd($request->thematic_area_id);
        // Criação do usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id, // se você tiver uma coluna 'role' na tabela
        ]);
        if($request->role_id!=4){

            $user->thematicAreas()->sync($request->thematic_area_id);
            
        }

        

        // Redireciona com mensagem de sucesso
        return redirect()->back()->with('success', 'Usuario criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
     public function passwordUpdate(Request $request)
    {
        // 1. Validação
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'], // Verifica se a senha atual está correta
            'password' => [
                'required', 
                'confirmed', 
                Password::min(8) // Mínimo 8 caracteres
                    ->letters()   // Deve ter letras
                    ->numbers()   // Deve ter números
                    //->mixedCase() // Letras maiúsculas e minúsculas
            ],
        ], [
            // Mensagens personalizadas (Opcional)
            'current_password.current_password' => 'A senha atual digitada está incorreta.',
            'password.confirmed' => 'A confirmação da nova senha não coincide.',
            'password.min' => 'A nova senha deve ter pelo menos 8 caracteres.',
        ]);

        // 2. Atualização da Senha
        $user = $request->user();
        
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // 3. Retorno com mensagem de sucesso
        return back()->with('success', 'Senha alterada com sucesso!');
    }
}
