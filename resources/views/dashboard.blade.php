<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - CICTED UniRovuma</title>

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
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    colors: {
                        'unirovuma': {
                            900: '#0A2D57',
                            800: '#0E3A6E',
                            500: '#1E5BB0',
                            gold: '#F2B900',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased" x-data="{
    currentTab: 'dashboard',
    sidebarOpen: false,
    showUserModal: false,
    showAreaModal: false,
    showAbstractModal: false,
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
                <div class="flex items-center gap-3">
                    <i class="fas fa-university text-unirovuma-gold text-2xl"></i>
                    <span class="text-lg font-bold tracking-wide">CICTED <span
                            class="text-unirovuma-gold">ADMIN</span></span>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Gestão</p>

                <!-- Dashboard -->
                <a href="#" @click.prevent="currentTab = 'dashboard'; sidebarOpen = false"
                    :class="currentTab === 'dashboard' ? 'bg-unirovuma-800 text-white border-r-4 border-unirovuma-gold' :
                        'text-gray-300 hover:bg-unirovuma-800'"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-chart-pie w-6 text-lg text-center"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <!-- Resumos -->
                <a href="#" @click.prevent="currentTab = 'registrations'; sidebarOpen = false"
                    :class="currentTab === 'registrations' ? 'bg-unirovuma-800 text-white border-r-4 border-unirovuma-gold' :
                        'text-gray-300 hover:bg-unirovuma-800'"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-layer-group w-6 text-lg text-center"></i>
                    <span class="ml-3">Todos os Resumos</span>
                </a>

                <!-- Utilizadores -->
                <a href="#" @click.prevent="currentTab = 'users'; sidebarOpen = false"
                    :class="currentTab === 'users' ? 'bg-unirovuma-800 text-white border-r-4 border-unirovuma-gold' :
                        'text-gray-300 hover:bg-unirovuma-800'"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-users w-6 text-lg text-center"></i>
                    <span class="ml-3">Utilizadores</span>
                </a>

                <!-- Áreas Temáticas (NOVO) -->
                <a href="#" @click.prevent="currentTab = 'areas'; sidebarOpen = false"
                    :class="currentTab === 'areas' ? 'bg-unirovuma-800 text-white border-r-4 border-unirovuma-gold' :
                        'text-gray-300 hover:bg-unirovuma-800'"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-tags w-6 text-lg text-center"></i>
                    <span class="ml-3">Áreas Temáticas</span>
                </a>
            </nav>

            <div class="p-4 border-t border-unirovuma-800 bg-unirovuma-900">
                <div class="flex items-center">
                    <div
                        class="w-10 h-10 rounded-full bg-white text-unirovuma-900 flex items-center justify-center font-bold">
                        A</div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-white">Administrador</p>
                        <p class="text-xs text-gray-400">admin@unirovuma.ac.mz</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button
                        class="w-full flex items-center justify-center px-4 py-2 text-xs font-medium text-red-300 bg-unirovuma-800 rounded-md hover:bg-red-900 hover:text-white transition-colors">
                        <i class="fas fa-sign-out-alt mr-2"></i> Sair
                    </button>
                </form>
            </div>
        </aside>

        <!-- CONTEÚDO -->
        <div class="flex-1 flex flex-col overflow-hidden relative">

            <!-- Header Mobile -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-4 lg:hidden z-10">
                <button @click="sidebarOpen = true" class="text-gray-500"><i class="fas fa-bars text-2xl"></i></button>
                <span class="font-bold text-unirovuma-900">CICTED Admin</span>
                <div class="w-6"></div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 lg:p-8">

                <!-- TAB 1: DASHBOARD -->
                <div x-show="currentTab === 'dashboard'" x-transition:enter="transition ease-out duration-300">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Visão Geral Administrativa</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Stats Card 1 -->
                        <div
                            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 font-medium uppercase">Total Utilizadores</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $users_count ?? 0 }}</p>
                            </div>
                            <div class="p-3 bg-blue-50 text-blue-600 rounded-lg"><i class="fas fa-users text-xl"></i>
                            </div>
                        </div>
                        <!-- Stats Card 2 -->
                        <div
                            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 font-medium uppercase">Total Resumos</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $abstracts_count ?? 0 }}</p>
                            </div>
                            <div class="p-3 bg-purple-50 text-purple-600 rounded-lg"><i
                                    class="fas fa-file-alt text-xl"></i></div>
                        </div>
                        <!-- Stats Card 3 -->
                        <div
                            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 font-medium uppercase">Áreas Temáticas</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $areas_count ?? 0 }}</p>
                            </div>
                            <div class="p-3 bg-green-50 text-green-600 rounded-lg"><i class="fas fa-tags text-xl"></i>
                            </div>
                        </div>
                        <!-- Stats Card 4 -->
                        <div
                            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 font-medium uppercase">Aguardando Avaliação</p>
                                <p class="text-3xl font-bold text-gray-800">{{ $pending_count ?? 0 }}</p>
                            </div>
                            <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg"><i
                                    class="fas fa-clock text-xl"></i></div>
                        </div>
                    </div>

                    <!-- Resumos Recentes (Mini Tabela) -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-lg mb-4 text-gray-800">Atividade Recente</h3>
                        <!-- Se não houver dados, mensagem de placeholder -->
                        <div
                            class="text-center py-10 text-gray-400 bg-gray-50 rounded-lg border-dashed border-2 border-gray-200">
                            <i class="fas fa-chart-line text-4xl mb-2 opacity-50"></i>
                            <p>Os dados de submissão aparecerão aqui.</p>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: TODOS OS RESUMOS -->
                <div x-show="currentTab === 'registrations'" x-transition:enter="transition ease-out duration-300">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Gestão de Resumos</h2>
                        <button
                            class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 flex items-center shadow">
                            <i class="fas fa-file-excel mr-2"></i> Exportar Relatório
                        </button>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                                    <tr>
                                        <th class="px-6 py-4">Título / Autor</th>
                                        <th class="px-6 py-4">Área Temática</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4 text-right">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($registrations ?? [] as $reg)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4">
                                                <p class="font-semibold text-gray-800 text-sm truncate w-64">
                                                    {{ $reg->abstract_title }}</p>
                                                <p class="text-xs text-gray-500">{{ $reg->full_names }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="px-2 py-1 rounded bg-blue-50 text-blue-700 text-xs font-medium border border-blue-100">{{ $reg->thematic->name ?? null }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <!-- Exemplo estático de status -->
                                                <span
                                                    class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-bold">Em
                                                    Análise</span>
                                            </td>
                                            <td class="px-6 py-4 text-right space-x-2">
                                                <button
                                                    @click="showAbstractModal = true; selectedReg = {{ json_encode($reg) }}"
                                                    class="text-gray-400 hover:text-unirovuma-500"><i
                                                        class="fas fa-eye"></i></button>
                                                <a href="#" class="text-gray-400 hover:text-gray-800"><i
                                                        class="fas fa-download"></i></a>
                                                <button class="text-gray-400 hover:text-red-600"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                                Nenhum resumo encontrado.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: UTILIZADORES -->
                <div x-show="currentTab === 'users'" x-transition:enter="transition ease-out duration-300">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Utilizadores</h2>
                        <button @click="showUserModal = true"
                            class="bg-unirovuma-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-800 shadow flex items-center">
                            <i class="fas fa-user-plus mr-2"></i> Adicionar Utilizador
                        </button>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="px-6 py-4">Nome</th>
                                    <th class="px-6 py-4">Email</th>
                                    <th class="px-6 py-4">Role</th>
                                    <th class="px-6 py-4 text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($users ?? [] as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-800">{{ $user->name }}</td>
                                        <td class="px-6 py-4 text-gray-500 text-sm">{{ $user->email }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 rounded text-xs font-bold bg-gray-100 text-gray-700 uppercase">{{ $user->role->description }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button class="text-red-500 hover:text-red-700 text-sm">Remover</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-400">Nenhum
                                            utilizador registado além de si.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 4: ÁREAS TEMÁTICAS (NOVA FUNCIONALIDADE) -->
                <div x-show="currentTab === 'areas'" x-transition:enter="transition ease-out duration-300">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Áreas Temáticas</h2>
                        <button @click="showAreaModal = true"
                            class="bg-unirovuma-gold text-unirovuma-900 px-4 py-2 rounded-lg text-sm font-bold hover:bg-yellow-400 shadow flex items-center">
                            <i class="fas fa-plus mr-2"></i> Nova Área
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Loop de Áreas (Simulado) -->
                        @forelse($thematic_areas ?? [] as $area)
                            <div
                                class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition relative group">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="font-bold text-lg text-unirovuma-900">{{ $area->name }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">Criado em:
                                            {{ $area->created_at->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="bg-blue-50 p-2 rounded-lg text-blue-600">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                </div>
                                <div
                                    class="mt-4 pt-4 border-t border-gray-100 flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button class="text-sm text-gray-500 hover:text-blue-600">Editar</button>
                                    <button class="text-sm text-red-400 hover:text-red-600">Excluir</button>
                                </div>
                            </div>
                        @empty
                            <div
                                class="col-span-3 text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                                <i class="fas fa-tags text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500">Nenhuma área temática cadastrada.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- ==================== MODAIS ==================== -->
    <div x-show="showUserModal || showAreaModal || showAbstractModal"
        class="fixed inset-0 z-40 bg-gray-900 bg-opacity-60 backdrop-blur-sm" x-cloak></div>

    <!-- 1. MODAL ADICIONAR UTILIZADOR -->
    <div x-show="showUserModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden"
            @click.away="showUserModal = false">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Novo Utilizador</h3>
                <button @click="showUserModal = false" class="text-gray-400 hover:text-gray-600"><i
                        class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST" class="p-6" x-data="{ role_id: 'D' }">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nome</label>
                        <input type="text" name="name" required
                            class="w-full border-gray-300 rounded-lg focus:ring-unirovuma-500 focus:border-unirovuma-500 p-2 border">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email</label>
                        <input type="email" name="email" required
                            class="w-full border-gray-300 rounded-lg focus:ring-unirovuma-500 focus:border-unirovuma-500 p-2 border">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Perfil (Role)</label>
                        <select name="role_id" x-model="role_id"
                            class="w-full border-gray-300 rounded-lg p-2 border bg-white">
                            <option value="4">Autor</option>
                            <option value="3">Avaliador</option>
                            <option value="2">Diretor de Área</option>
                            <option value="1">Administrador</option>
                        </select>
                    </div>

                    <!-- Seleção de Área Temática (Apenas se for Diretor ou Avaliador) -->
                    <div x-transition>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Associar a Área
                            Temática</label>
                        <select name="thematic_area_id" class="w-full border-gray-300 rounded-lg p-2 border bg-white">
                            <option value="">Selecione...</option>
                            @foreach ($thematic_areas ?? [] as $area)
                                <option value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Senha</label>
                            <input type="password" name="password" required
                                class="w-full border-gray-300 rounded-lg p-2 border">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Confirmar</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full border-gray-300 rounded-lg p-2 border">
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showUserModal = false"
                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancelar</button>
                    <button type="submit"
                        class="px-4 py-2 bg-unirovuma-900 text-white rounded-lg hover:bg-blue-900 shadow">Criar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. MODAL ADICIONAR ÁREA TEMÁTICA -->
    <div x-show="showAreaModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden"
            @click.away="showAreaModal = false">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Nova Área Temática</h3>
                <button @click="showAreaModal = false" class="text-gray-400 hover:text-gray-600"><i
                        class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('thematic_areas.store') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nome da Área</label>
                        <input type="text" name="name" placeholder="Ex: Educação e Sociedade" required
                            class="w-full border-gray-300 rounded-lg focus:ring-unirovuma-gold focus:border-unirovuma-gold p-2 border">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Descrição
                            (Opcional)</label>
                        <textarea name="description" rows="3" class="w-full border-gray-300 rounded-lg p-2 border"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showAreaModal = false"
                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancelar</button>
                    <button type="submit"
                        class="px-4 py-2 bg-unirovuma-gold text-unirovuma-900 font-bold rounded-lg hover:bg-yellow-400 shadow">Salvar
                        Área</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. MODAL VISUALIZAR RESUMO -->
    <div x-show="showAbstractModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden"
            @click.away="showAbstractModal = false">
            <div class="bg-unirovuma-900 px-6 py-4 flex justify-between items-center">
                <h3 class="text-white font-semibold">Detalhes do Resumo</h3>
                <button @click="showAbstractModal = false" class="text-gray-300 hover:text-white"><i
                        class="fas fa-times"></i></button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <h2 class="text-xl font-bold text-gray-800 mb-2" x-text="selectedReg?.abstract_title"></h2>
                <div class="flex items-center gap-2 mb-4">
                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs border border-blue-100"
                        x-text="selectedReg?.thematic_axis"></span>
                    <span class="text-gray-400 text-sm">|</span>
                    <span class="text-gray-600 text-sm" x-text="selectedReg?.full_names"></span>
                </div>
                <hr class="border-gray-100 mb-4">
                <p class="text-gray-700 text-justify leading-relaxed whitespace-pre-line"
                    x-text="selectedReg?.abstract_content"></p>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <button @click="showAbstractModal = false"
                    class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-white">Fechar</button>
            </div>
        </div>
    </div>
     @if ($errors->any())
        @include('componentes.error')
    @endif
    @if (session('success'))
        @include('componentes.success')
    @endif

</body>

</html>
