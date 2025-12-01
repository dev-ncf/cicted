<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin - CICTED UniRovuma</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Ícones (Heroicons/FontAwesome) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'unirovuma-blue': '#0A2D57',
                        'unirovuma-blue-dark': '#06203E',
                        'unirovuma-gold': '#F2B900',
                    }
                }
            }
        }
    </script>
</head>
<!-- ALTERAÇÃO 1: Adicionei 'showUserModal: false' ao x-data -->
<body class="bg-gray-100 font-sans" x-data="{ currentTab: 'dashboard', showModal: false, showUserModal: false, selectedReg: null }">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- BARRA LATERAL (SIDEBAR) -->
        <aside class="w-64 bg-unirovuma-blue-dark text-white flex-shrink-0 hidden md:flex flex-col">
            <div class="h-16 flex items-center justify-center border-b border-gray-700">
                <span class="text-xl font-bold tracking-wider text-unirovuma-gold">CICTED ADMIN</span>
            </div>
            <nav class="flex-1 px-2 py-4 space-y-2">
                <button @click="currentTab = 'dashboard'" 
                    :class="{'bg-unirovuma-blue border-l-4 border-unirovuma-gold': currentTab === 'dashboard', 'hover:bg-gray-700': currentTab !== 'dashboard'}"
                    class="w-full group flex items-center px-2 py-3 text-sm font-medium rounded-r-md transition-colors">
                    <i class="fas fa-chart-pie mr-3 text-lg"></i> Visão Geral
                </button>

                <button @click="currentTab = 'registrations'" 
                    :class="{'bg-unirovuma-blue border-l-4 border-unirovuma-gold': currentTab === 'registrations', 'hover:bg-gray-700': currentTab !== 'registrations'}"
                    class="w-full group flex items-center px-2 py-3 text-sm font-medium rounded-r-md transition-colors">
                    <i class="fas fa-users mr-3 text-lg"></i> Inscrições
                </button>

                <button @click="currentTab = 'users'" 
                    :class="{'bg-unirovuma-blue border-l-4 border-unirovuma-gold': currentTab === 'users', 'hover:bg-gray-700': currentTab !== 'users'}"
                    class="w-full group flex items-center px-2 py-3 text-sm font-medium rounded-r-md transition-colors">
                    <i class="fas fa-user-shield mr-3 text-lg"></i> Gestão de Utilizadores
                </button>
            </nav>
            <div class="p-4 border-t border-gray-700">
                <div class="flex items-center">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-white">Admin</p>
                        <p class="text-xs text-gray-400">admin@unirovuma.ac.mz</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ÁREA PRINCIPAL -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <header class="bg-white shadow h-16 flex justify-between items-center px-6 z-10">
                <h2 class="text-xl font-semibold text-gray-800" x-text="currentTab === 'dashboard' ? 'Painel de Controlo' : (currentTab === 'registrations' ? 'Gestão de Inscrições' : 'Gestão de Utilizadores')"></h2>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm flex items-center gap-2">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </button>
                </form>
            </header>
                          

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                  <!-- Área de Mensagens (Sucesso/Erro) -->
                <div class="text-center mb-8 md:mb-12">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-md text-left shadow-sm" role="alert">
                            <p class="font-bold">Sucesso</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded-md text-left shadow-sm" role="alert">
                            <p class="font-bold">Por favor, corrija os erros abaixo:</p>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                
                <!-- VISTA 1: DASHBOARD -->
                <div x-show="currentTab === 'dashboard'" x-transition:enter="transition ease-out duration-300">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4"> <i class="fas fa-users text-2xl"></i> </div>
                                <div> <p class="text-sm text-gray-500 font-medium">Total Inscritos</p> <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] ?? 0 }}</p> </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4"> <i class="fas fa-microphone text-2xl"></i> </div>
                                <div> <p class="text-sm text-gray-500 font-medium">Oradores</p> <p class="text-2xl font-bold text-gray-800">{{ $stats['speakers'] ?? 0 }}</p> </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4"> <i class="fas fa-eye text-2xl"></i> </div>
                                <div> <p class="text-sm text-gray-500 font-medium">Ouvintes</p> <p class="text-2xl font-bold text-gray-800">{{ $stats['attendees'] ?? 0 }}</p> </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VISTA 2: LISTA DE INSCRIÇÕES -->
                <div x-show="currentTab === 'registrations'" x-transition:enter="transition ease-out duration-300">
                    <div class="bg-white shadow rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900">Registos Recentes</h3>
                            <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm flex items-center gap-2">
                                <i class="fas fa-file-excel"></i> Exportar Excel
                            </button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instituição</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resumo</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if(isset($registrations) && $registrations->count() > 0)
                                        @foreach ($registrations as $reg)
                                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $reg->full_names }}</div>
                                                <div class="text-sm text-gray-500">{{ $reg->email ?? 'Sem email' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($reg->participant_type == 'orador')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Orador</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Ouvinte</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $reg->institution_country }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($reg->participant_type == 'orador' && $reg->abstract_filepath)
                                                    <a href="{{ asset($reg->abstract_filepath) }}" target="_blank" class="text-unirovuma-blue hover:text-blue-700 font-semibold flex items-center gap-1">
                                                        <i class="fas fa-download"></i> Baixar
                                                    </a>
                                                @elseif($reg->participant_type == 'orador')
                                                    <span class="text-red-400 text-xs italic">Pendente</span>
                                                @else
                                                    <span class="text-gray-300">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                                <button @click="showModal = true; selectedReg = {{ json_encode($reg) }}" class="text-indigo-600 hover:text-indigo-900" title="Ver Detalhes">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <form action="{{ route('registration.destroy', $reg->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja apagar?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 bg-gray-50">
                                                <div class="flex flex-col items-center justify-center">
                                                    <i class="fas fa-folder-open text-4xl mb-3 text-gray-300"></i>
                                                    <p>Sem registos encontrados.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 bg-white border-t border-gray-200">
                            {{ $registrations->links() }}
                        </div>
                    </div>
                </div>

                <!-- VISTA 3: GESTÃO DE UTILIZADORES -->
                <div x-show="currentTab === 'users'" x-transition:enter="transition ease-out duration-300">
                    <div class="bg-white shadow rounded-lg p-6">
                        <div class="flex justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Administradores do Sistema</h3>
                            <!-- ALTERAÇÃO 2: Botão agora ativa showUserModal -->
                            <button @click="showUserModal = true" class="bg-unirovuma-blue hover:bg-blue-900 text-white px-4 py-2 rounded text-sm transition">
                                <i class="fas fa-plus mr-1"></i> Adicionar Utilizador
                            </button>
                        </div>
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-gray-500 border-b">
                                    <th class="py-2">Nome</th>
                                    <th class="py-2">Email</th>
                                    <th class="py-2">Data Criação</th>
                                    <th class="py-2 text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($users) && count($users) > 0)
                                    @foreach($users as $user)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 font-medium">{{ $user->name }}</td>
                                        <td class="py-3 text-gray-600">{{ $user->email }}</td>
                                        <td class="py-3 text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td class="py-3 text-right">
                                            <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 font-medium">Admin Padrão</td>
                                        <td class="py-3 text-gray-600">admin@unirovuma.ac.mz</td>
                                        <td class="py-3 text-gray-500">01/10/2023</td>
                                        <td class="py-3 text-right">
                                            <span class="text-xs text-gray-400">Sistema</span>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- MODAL 1: DETALHES DA INSCRIÇÃO -->
    <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-xl leading-6 font-medium text-unirovuma-blue" id="modal-title">Detalhes da Inscrição</h3>
                            <div class="mt-4 border-t border-gray-200 pt-4 grid grid-cols-2 gap-4">
                                <div> <p class="text-xs text-gray-500 uppercase">Nome</p> <p class="font-medium text-gray-900" x-text="selectedReg?.full_names"></p> </div>
                                <div> <p class="text-xs text-gray-500 uppercase">Nível Académico</p> <p class="text-gray-900" x-text="selectedReg?.academic_level"></p> </div>
                                <div> <p class="text-xs text-gray-500 uppercase">Instituição</p> <p class="text-gray-900" x-text="selectedReg?.institution_country"></p> </div>
                                <div> <p class="text-xs text-gray-500 uppercase">Ocupação</p> <p class="text-gray-900" x-text="selectedReg?.occupation"></p> </div>
                                <template x-if="selectedReg?.participant_type == 'orador'">
                                    <div class="col-span-2 bg-blue-50 p-4 rounded-lg mt-2">
                                        <h4 class="font-bold text-blue-800 mb-2">Dados da Apresentação</h4>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div> <p class="text-xs text-gray-500">Eixo Temático</p> <p class="text-sm font-semibold" x-text="selectedReg?.thematic_axis"></p> </div>
                                            <div> <p class="text-xs text-gray-500">Modalidade</p> <p class="text-sm" x-text="selectedReg?.presentation_modality"></p> </div>
                                            <div class="col-span-2"> <p class="text-xs text-gray-500">Resumo</p> <p class="text-sm text-gray-700 mt-1" x-text="selectedReg?.abstract_content"></p> </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <template x-if="selectedReg?.abstract_filepath">
                        <a :href="'{{ asset('') }}' + selectedReg?.abstract_filepath" target="_blank" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-unirovuma-blue text-base font-medium text-white hover:bg-blue-900 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            <i class="fas fa-download mr-2 mt-1"></i> Baixar Ficheiro
                        </a>
                    </template>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showModal = false">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ALTERAÇÃO 3: NOVO MODAL PARA ADICIONAR USUÁRIO -->
    <div x-show="showUserModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="showUserModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showUserModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal Panel -->
            <div x-show="showUserModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                
                <!-- IMPORTANTE: Defina a rota correta do Laravel aqui (ex: route('users.store') ou route('register')) -->
                <form action="{{ route('users.store') }}" method="POST"> 
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-xl leading-6 font-medium text-unirovuma-blue border-b pb-2 mb-4">
                                    <i class="fas fa-user-plus mr-2"></i>Novo Administrador
                                </h3>
                                
                                <div class="space-y-4">
                                    <!-- Nome -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700">Nome Completo</label>
                                        <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-unirovuma-blue focus:ring focus:ring-unirovuma-blue focus:ring-opacity-50 border p-2">
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email Institucional</label>
                                        <input type="email" name="email" id="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-unirovuma-blue focus:ring focus:ring-unirovuma-blue focus:ring-opacity-50 border p-2">
                                    </div>

                                    <!-- Senha -->
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                                        <input type="password" name="password" id="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-unirovuma-blue focus:ring focus:ring-unirovuma-blue focus:ring-opacity-50 border p-2">
                                    </div>

                                    <!-- Confirmar Senha -->
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-unirovuma-blue focus:ring focus:ring-unirovuma-blue focus:ring-opacity-50 border p-2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-unirovuma-blue text-base font-medium text-white hover:bg-blue-900 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Criar Utilizador
                        </button>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showUserModal = false">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>