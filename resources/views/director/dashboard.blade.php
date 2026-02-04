<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direção de Área - CICTED</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        'unirovuma': {
                            900: '#0A2D57',
                            800: '#0E3A6E',
                            gold: '#F2B900',
                        }
                    }
                }
            }
        }
    </script>
    <style>[x-cloak] { display: none !important; }</style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased" 
      x-data="{ 
          currentTab: 'dashboard', 
          sidebarOpen: false, 
          showDetailModal: false,
          showAssignModal: false,
          selectedReg: null
      }">

    <div class="flex h-screen overflow-hidden">

        <!-- OVERLAY MOBILE -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak
             class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 lg:hidden transition-opacity"></div>

        <!-- SIDEBAR -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-30 w-64 bg-unirovuma-900 text-white transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-2xl">
            
            <div class="h-20 flex items-center justify-center border-b border-unirovuma-800 bg-unirovuma-900">
                <div class="flex items-center gap-2">
                    <i class="fas fa-briefcase text-unirovuma-gold text-2xl"></i>
                    <span class="text-lg font-bold tracking-wide">CICTED <span class="text-unirovuma-gold">DIRETOR</span></span>
                </div>
            </div>

            <!-- Info da Área Temática -->
            <div class="px-4 py-4 bg-unirovuma-800 border-b border-unirovuma-900">
                <p class="text-xs text-gray-400 uppercase font-bold">Área de Gestão</p>
                <p class="text-sm font-bold text-white mt-1 truncate">
                    @foreach ( Auth::user()->thematicAreas as $area)
                        
                    <i class="fas fa-tag mr-1 text-unirovuma-gold"></i> {{ $area->name }}
                    @endforeach
                </p>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <!-- Dashboard -->
                <a href="#" @click.prevent="currentTab = 'dashboard'; sidebarOpen = false" 
                   :class="currentTab === 'dashboard' ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-chart-line w-6 text-lg text-center"></i>
                    <span class="ml-3">Visão Geral</span>
                </a>

                <!-- Atribuições -->
                <a href="#" @click.prevent="currentTab = 'assignments'; sidebarOpen = false" 
                   :class="currentTab === 'assignments' ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-tasks w-6 text-lg text-center"></i>
                    <span class="ml-3">Gerir Atribuições</span>
                </a>

                <!-- Avaliadores da Área -->
                <a href="#" @click.prevent="currentTab = 'team'; sidebarOpen = false" 
                   :class="currentTab === 'team' ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-users w-6 text-lg text-center"></i>
                    <span class="ml-3">Meus Avaliadores</span>
                </a>
            </nav>

            <div class="p-4 border-t border-unirovuma-800 bg-unirovuma-900">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 rounded-full bg-white text-unirovuma-900 flex items-center justify-center font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">Diretor de Área</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full flex items-center justify-center px-4 py-2 text-xs font-medium text-red-300 bg-unirovuma-800 rounded-md hover:bg-red-900 hover:text-white transition-colors">
                        <i class="fas fa-sign-out-alt mr-2"></i> Sair
                    </button>
                </form>
            </div>
        </aside>

        <!-- CONTEÚDO PRINCIPAL -->
        <div class="flex-1 flex flex-col overflow-hidden relative">
            
            <!-- Mobile Header -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-4 lg:hidden z-10">
                <button @click="sidebarOpen = true" class="text-gray-500"><i class="fas fa-bars text-2xl"></i></button>
                <span class="font-bold text-unirovuma-900">Painel do Diretor</span>
                <div class="w-6"></div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 lg:p-8">

                @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r shadow-sm flex items-start animate-fade-in-down">
                    <div class="flex-shrink-0 text-green-500"><i class="fas fa-check-circle"></i></div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                <!-- TAB 1: DASHBOARD -->
                <div x-show="currentTab === 'dashboard'" x-transition:enter="transition ease-out duration-300">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Painel de Controlo</h2>
                    <p class="text-gray-500 mb-6">Resumo da área: <span class="font-semibold text-unirovuma-900">{{ Auth::user()->thematic_area }}</span></p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Novos / Pendentes de Atribuição -->
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between border-l-4 border-l-red-500">
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase">Novas Submissões</p>
                                <p class="text-xs text-gray-400">Aguardando Avaliador</p>
                                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['unassigned'] ?? 0 }}</p>
                            </div>
                            <div class="p-3 bg-red-50 text-red-600 rounded-lg"><i class="fas fa-inbox text-xl"></i></div>
                        </div>

                        <!-- Em Avaliação -->
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between border-l-4 border-l-yellow-500">
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase">Em Andamento</p>
                                <p class="text-xs text-gray-400">Com avaliador definido</p>
                                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['pending_review'] ?? 0 }}</p>
                            </div>
                            <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg"><i class="fas fa-user-clock text-xl"></i></div>
                        </div>

                        <!-- Concluídos -->
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between border-l-4 border-l-green-500">
                            <div>
                                <p class="text-xs text-gray-500 font-bold uppercase">Finalizados</p>
                                <p class="text-xs text-gray-400">Decisão tomada</p>
                                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['completed'] ?? 0 }}</p>
                            </div>
                            <div class="p-3 bg-green-50 text-green-600 rounded-lg"><i class="fas fa-check-double text-xl"></i></div>
                        </div>
                    </div>

                    <!-- Lista Rápida: Pendentes de Atribuição -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-gray-800 text-lg">Requer Atenção Imediata (Sem Avaliador)</h3>
                            <button @click="currentTab = 'assignments'" class="text-sm text-unirovuma-500 hover:text-unirovuma-900 font-medium">Ver Todos</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-gray-50 text-gray-500 font-semibold">
                                    <tr>
                                        <th class="px-4 py-3 rounded-l-lg">Título</th>
                                        <th class="px-4 py-3">Autor</th>
                                        <th class="px-4 py-3 rounded-r-lg text-right">Ação</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($unassigned_registrations ?? [] as $reg)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-800 truncate max-w-xs">{{ $reg->abstract_title }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $reg->full_names }}</td>
                                        <td class="px-4 py-3 text-right">
                                            <button @click="showAssignModal = true; selectedReg = {{ json_encode($reg) }}" class="bg-unirovuma-900 text-white px-3 py-1 rounded text-xs hover:bg-blue-800 transition">
                                                Atribuir
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-6 text-center text-gray-400 italic">Tudo em dia! Nenhum resumo pendente de atribuição.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: GERIR ATRIBUIÇÕES (LISTA COMPLETA) -->
                <div x-show="currentTab === 'assignments'" x-transition:enter="transition ease-out duration-300">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Gestão de Atribuições</h2>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                                    <tr>
                                        <th class="px-6 py-4">Resumo / Autor</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4">Avaliador Responsável</th>
                                        <th class="px-6 py-4 text-right">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($registrations ?? [] as $reg)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-gray-800 text-sm truncate w-64" title="{{ $reg->abstract_title }}">{{ $reg->abstract_title }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $reg->full_names }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if(!$reg->evaluator_id)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                                    Não Atribuído
                                                </span>
                                            @elseif($reg->status == 'em_avaliacao')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                                    Aguardando Parecer
                                                </span>
                                            @elseif($reg->status == 'aceite' || $reg->status == 'aceite_correcoes' || $reg->status == 'devolvido')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                    Avaliado
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($reg->evaluator)
                                                <div class="flex items-center">
                                                    <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold mr-2">
                                                        {{ substr($reg->evaluator->name, 0, 1) }}
                                                    </div>
                                                    <span class="text-sm text-gray-700 font-medium">{{ $reg->evaluator->name }}</span>
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-sm italic">-- Nenhum --</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <button @click="showDetailModal = true; selectedReg = {{ json_encode($reg) }}" class="text-gray-400 hover:text-unirovuma-900" title="Ler Resumo">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            
                                            <!-- Botão Atribuir / Reatribuir -->
                                            <button @click="showAssignModal = true; selectedReg = {{ json_encode($reg) }}" 
                                                    class="px-3 py-1 rounded text-xs font-bold shadow-sm transition-colors border
                                                    {{ !$reg->evaluator_id ? 'bg-unirovuma-900 text-white border-transparent hover:bg-blue-900' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50' }}">
                                                <i class="fas fa-user-tag mr-1"></i> {{ !$reg->evaluator_id ? 'Atribuir' : 'Alterar' }}
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">Nenhum resumo nesta área temática.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: EQUIPE (AVALIADORES) -->
                <div x-show="currentTab === 'team'" x-transition:enter="transition ease-out duration-300">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Equipe de Avaliação - {{ Auth::user()->thematic_area }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($evaluators ?? [] as $evaluator)
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center font-bold text-xl">
                                {{ substr($evaluator->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800">{{ $evaluator->name }}</h3>
                                <p class="text-xs text-gray-500">{{ $evaluator->email }}</p>
                                <p class="text-xs text-blue-500 mt-1 bg-blue-50 inline-block px-2 py-0.5 rounded">Avaliador</p>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-3 text-center py-10 bg-white rounded-xl border border-dashed border-gray-300">
                            <p class="text-gray-500">Nenhum avaliador cadastrado nesta área temática.</p>
                            <p class="text-xs text-gray-400">Contacte o Administrador para adicionar utilizadores.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- 1. MODAL DETALHES -->
    <div x-show="showDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm" @click="showDetailModal = false"></div>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden z-10 relative">
            <div class="bg-unirovuma-900 px-6 py-4 flex justify-between items-center">
                <h3 class="text-white font-bold text-lg">Visualizar Resumo</h3>
                <button @click="showDetailModal = false" class="text-gray-300 hover:text-white"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <h2 class="text-xl font-bold text-gray-800 mb-2" x-text="selectedReg?.abstract_title"></h2>
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-sm font-semibold text-gray-500">Autor:</span>
                    <span class="text-sm text-gray-800" x-text="selectedReg?.full_names"></span>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-100 text-sm text-justify leading-relaxed whitespace-pre-line" x-text="selectedReg?.abstract_content"></div>
                
                <div class="mt-4 flex gap-3">
                    <template x-if="selectedReg?.abstract_filepath">
                        <a :href="'{{ asset('') }}' + selectedReg?.abstract_filepath" target="_blank" class="text-blue-600 hover:underline text-sm font-medium flex items-center">
                            <i class="fas fa-file-pdf mr-1"></i> Abrir PDF Original
                        </a>
                    </template>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
                <button @click="showDetailModal = false" class="px-4 py-2 border rounded text-gray-600 hover:bg-white">Fechar</button>
                <button @click="showDetailModal = false; showAssignModal = true" class="px-4 py-2 bg-unirovuma-900 text-white rounded hover:bg-blue-900 shadow">
                    Atribuir Avaliador
                </button>
            </div>
        </div>
    </div>

    <!-- 2. MODAL ATRIBUIR AVALIADOR -->
    <div x-show="showAssignModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm" @click="showAssignModal = false"></div>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden z-10 relative">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 text-lg">Atribuir Avaliador</h3>
                <p class="text-xs text-gray-500 mt-1">Selecione um especialista da área <strong>{{ Auth::user()->thematic_area }}</strong>.</p>
            </div>
            
            <form action="{{ route('abstracts.assign') }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="registration_id" :value="selectedReg?.id">
                
                <div class="mb-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Resumo</label>
                    <p class="text-sm font-medium text-gray-800 truncate p-2 bg-gray-50 rounded border border-gray-200" x-text="selectedReg?.abstract_title"></p>
                </div>

                <div class="mt-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Selecione o Avaliador</label>
                    <div class="relative">
                        <select name="evaluator_id" required class="block w-full rounded-lg border-gray-300 py-3 px-4 shadow-sm focus:border-unirovuma-500 focus:ring-unirovuma-500 sm:text-sm border bg-white">
                            <option value="">-- Escolha da lista --</option>
                            @forelse($evaluators ?? [] as $evaluator)
                                <option value="{{ $evaluator->id }}">{{ $evaluator->name }}</option>
                            @empty
                                <option value="" disabled>Sem avaliadores disponíveis</option>
                            @endforelse
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" @click="showAssignModal = false" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm font-medium">Cancelar</button>
                    <button type="submit" class="px-5 py-2 bg-unirovuma-900 text-white font-bold rounded-lg hover:bg-blue-900 shadow text-sm">Confirmar Atribuição</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>