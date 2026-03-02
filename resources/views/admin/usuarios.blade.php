@extends('admin.dashboard')
@section('admin.content')
     <div  x-transition:enter="transition ease-out duration-300">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Utilizadores</h2>
                        <button @click="showUserModal = true; resetUserForm()" 
                            class="bg-unirovuma-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-800 shadow flex items-center">
                            <i class="fas fa-user-plus mr-2"></i> Novo Utilizador
                        </button>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="px-6 py-4">Nome</th>
                                    <th class="px-6 py-4">Email</th>
                                    <th class="px-6 py-4">Role</th>
                                    <th class="px-6 py-4">Área Temática</th>
                                    <th class="px-6 py-4 text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($users ?? [] as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-800">{{ $user->name }}</td>
                                        <td class="px-6 py-4 text-gray-500 text-sm">{{ $user->email }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 rounded text-xs font-bold bg-gray-100 text-gray-700 uppercase">
                                                @if($user->role_id == '1') Admin 
                                                @elseif($user->role_id == '2') Diretor
                                                @elseif($user->role_id == '3') Avaliador
                                                @else Autor @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($user->thematic_area)
                                                <span class="px-2 py-1 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                                    {{ $user->thematic_area->name }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <!-- Botão Editar -->
                                            <button @click="editUser({{ json_encode($user) }})" class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></button>
                                            
                                            <!-- Botão Excluir -->
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Sem registos.</td></tr>
                                @endforelse
                            </tbody>
                            {{ $users->links() }}
                        </table>
                    </div>
                </div>
@endsection
@section('modal')
<div x-show="showUserModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden" @click.away="showUserModal = false">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800" x-text="userForm.id ? 'Editar Utilizador' : 'Novo Utilizador'"></h3>
                <button @click="showUserModal = false" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
            </div>
            
            <!-- FORMULÁRIO COM LÓGICA DE UPDATE/CREATE -->
            <form :action="userForm.id ? '/users/' + userForm.id : '{{ route('users.store') }}'" method="POST" class="p-6">
                @csrf
                <template x-if="userForm.id"><input type="hidden" name="_method" value="PUT"></template>

                <div class="space-y-4">
                    <input type="text" name="name" x-model="userForm.name" placeholder="Nome Completo" required class="w-full border-gray-300 rounded-lg p-2 border">
                    <input type="email" name="email" x-model="userForm.email" placeholder="Email Institucional" required class="w-full border-gray-300 rounded-lg p-2 border">
                    
                    <select name="role_id" x-model="userForm.role_id" class="w-full border-gray-300 rounded-lg p-2 border bg-white">
                        <option value="4">Autor</option>
                        <option value="3">Avaliador</option>
                        <option value="2">Diretor de Área</option>
                        <option value="1">Administrador</option>
                    </select>

                    <!-- SELEÇÃO DE ÁREA TEMÁTICA (Obrigatoriedade Relacionamento) -->
                    <div x-transition>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Área de Atuação <span class="text-red-500">*</span></label>
                        <select name="thematic_area_id" x-model="userForm.thematic_area_id" class="w-full border-gray-300 rounded-lg p-2 border bg-white" :required="userForm.role_id == '2' || userForm.role_id == '3'">
                            <option value="">Selecione...</option>
                            @foreach ($thematic_areas ?? [] as $area)
                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-400 mt-1">Este campo vincula o utilizador aos resumos desta área.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-gray-400 mb-1" x-text="userForm.id ? 'Nova Senha (Opcional)' : 'Senha'"></label>
                            <input type="password" name="password" :required="!userForm.id" class="w-full border-gray-300 rounded-lg p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-400 mb-1">Confirmar</label>
                            <input type="password" name="password_confirmation" :required="!userForm.id" class="w-full border-gray-300 rounded-lg p-2 border">
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showUserModal = false" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-unirovuma-900 text-white rounded-lg hover:bg-blue-900 shadow">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    
@endsection