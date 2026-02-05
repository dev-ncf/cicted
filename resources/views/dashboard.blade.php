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
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
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
    <style>[x-cloak] { display: none !important; }</style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased" 
      x-data="{ 
          currentTab: 'dashboard', 
          sidebarOpen: false, 
          
          // Controle de Modais
          showUserModal: false, 
          showAreaModal: false, 
          showAbstractModal: false,
          showDateModal: false,
          showProofModal: false,

          // Dados Selecionados (Para Edição/Visualização)
          selectedReg: null,
          selectedDate: { id: null, data: '', descricao: '' },
          selectedProof: null,
          
          // DADOS DO UTILIZADOR (Para Criar e Editar com Relacionamento)
          userForm: {
              id: null,
              name: '',
              email: '',
              role_id: '4', // Padrão: Autor
              thematic_area_id: ''
          },
          
          // Função para resetar o form de user
          resetUserForm() {
              this.userForm = { id: null, name: '', email: '', role_id: '4', thematic_area_id: '' };
          },
          
          // Função para carregar user para edição
          editUser(user) {
              this.userForm = {
                  id: user.id,
                  name: user.name,
                  email: user.email,
                  role_id: user.role_id,
                  thematic_area_id: user.thematic_area_id // Aqui carrega a relação existente
              };
              this.showUserModal = true;
          }
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
                    <span class="text-lg font-bold tracking-wide">CICTED <span class="text-unirovuma-gold">ADMIN</span></span>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Gestão Geral</p>

                <a href="#" @click.prevent="currentTab = 'dashboard'; sidebarOpen = false"
                    :class="currentTab === 'dashboard' ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-chart-pie w-6 text-lg text-center"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <a href="#" @click.prevent="currentTab = 'dates'; sidebarOpen = false"
                    :class="currentTab === 'dates' ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-calendar-alt w-6 text-lg text-center"></i>
                    <span class="ml-3">Datas Importantes</span>
                </a>

                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-4">Científico</p>

                <a href="#" @click.prevent="currentTab = 'registrations'; sidebarOpen = false"
                    :class="currentTab === 'registrations' ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-layer-group w-6 text-lg text-center"></i>
                    <span class="ml-3">Resumos / Submissões</span>
                </a>

                <a href="#" @click.prevent="currentTab = 'payments'; sidebarOpen = false"
                    :class="currentTab === 'payments' ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-receipt w-6 text-lg text-center"></i>
                    <span class="ml-3">Comprovativos</span>
                </a>

                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-4">Configuração</p>

                <a href="#" @click.prevent="currentTab = 'users'; sidebarOpen = false"
                    :class="currentTab === 'users' ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-users w-6 text-lg text-center"></i>
                    <span class="ml-3">Utilizadores</span>
                </a>

                <a href="#" @click.prevent="currentTab = 'areas'; sidebarOpen = false"
                    :class="currentTab === 'areas' ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-tags w-6 text-lg text-center"></i>
                    <span class="ml-3">Áreas Temáticas</span>
                </a>
            </nav>

            <div class="p-4 border-t border-unirovuma-800 bg-unirovuma-900">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-white text-unirovuma-900 flex items-center justify-center font-bold">A</div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-white">Administrador</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button class="w-full flex items-center justify-center px-4 py-2 text-xs font-medium text-red-300 bg-unirovuma-800 rounded-md hover:bg-red-900 hover:text-white transition-colors">
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

                <!-- Mensagens -->
                @if (session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r shadow-sm flex items-start animate-fade-in-down">
                        <div class="flex-shrink-0 text-green-500"><i class="fas fa-check-circle"></i></div>
                        <div class="ml-3"><p class="text-sm text-green-700 font-medium">{{ session('success') }}</p></div>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r shadow-sm">
                        <ul class="text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- TAB 1: DASHBOARD -->
                <div x-show="currentTab === 'dashboard'" x-transition:enter="transition ease-out duration-300">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Visão Geral</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <div><p class="text-sm text-gray-500 font-medium uppercase">Resumos Submetidos</p><p class="text-3xl font-bold text-gray-800">{{ $resumos->count() ?? 0 }}</p></div>
                            <div class="p-3 bg-blue-50 text-blue-600 rounded-lg"><i class="fas fa-file-alt text-xl"></i></div>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <div><p class="text-sm text-gray-500 font-medium uppercase">Aguardando Avaliação</p><p class="text-3xl font-bold text-yellow-600">{{ $pending_count ?? 0 }}</p></div>
                            <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg"><i class="fas fa-clock text-xl"></i></div>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <div><p class="text-sm text-gray-500 font-medium uppercase">Utilizadores</p><p class="text-3xl font-bold text-gray-800">{{ $users->count() ?? 0 }}</p></div>
                            <div class="p-3 bg-purple-50 text-purple-600 rounded-lg"><i class="fas fa-users text-xl"></i></div>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                            <div><p class="text-sm text-gray-500 font-medium uppercase">Pagamentos Pendentes</p><p class="text-3xl font-bold text-red-600">{{ $payments_pending_count ?? 0 }}</p></div>
                            <div class="p-3 bg-red-50 text-red-600 rounded-lg"><i class="fas fa-receipt text-xl"></i></div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: DATAS IMPORTANTES -->
                <div x-show="currentTab === 'dates'" x-transition:enter="transition ease-out duration-300">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Datas Importantes</h2>
                        <button @click="showDateModal = true; selectedDate = {id: null, data: '', descricao: ''}" 
                            class="bg-unirovuma-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-800 shadow flex items-center">
                            <i class="fas fa-plus mr-2"></i> Adicionar Data
                        </button>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="px-6 py-4">Descrição do Evento</th>
                                    <th class="px-6 py-4">Data</th>
                                    <th class="px-6 py-4 text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($datas ?? [] as $data)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-800">{{ $data->descricao }}</td>
                                        <td class="px-6 py-4 text-blue-600 font-bold">{{ $data->data }}</td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <button @click="showDateModal = true; selectedDate = {id: '{{ $data->id }}', data: '{{ $data->data }}', descricao: '{{ $data->descricao }}'}" class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></button>
                                            <form action="{{ route('dates.destroy', $data->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apagar esta data?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-6 py-8 text-center text-gray-400">Nenhuma data registada.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 3: RESUMOS / SUBMISSÕES -->
                <div x-show="currentTab === 'registrations'" x-transition:enter="transition ease-out duration-300">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Gestão de Submissões</h2>
                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 flex items-center shadow">
                            <i class="fas fa-file-excel mr-2"></i> Exportar Lista
                        </button>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="px-6 py-4">Título / Autor</th>
                                    <th class="px-6 py-4">Eixo Temático</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Avaliador</th>
                                    <th class="px-6 py-4 text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($registrations ?? [] as $reg)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-gray-800 text-sm truncate w-64">{{ $reg->abstract_title }}</p>
                                            <p class="text-xs text-gray-500">{{ $reg->full_names }}</p>
                                        </td>
                                        <td class="px-6 py-4"><span class="px-2 py-1 rounded bg-blue-50 text-blue-700 text-xs font-medium">{{ $reg->thematic_axis }}</span></td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusColors = [
                                                    'submetido' => 'bg-gray-100 text-gray-600',
                                                    'em_avaliacao' => 'bg-yellow-100 text-yellow-800',
                                                    'aceite' => 'bg-green-100 text-green-800',
                                                    'devolvido' => 'bg-red-100 text-red-800',
                                                    'aceite_correcoes' => 'bg-blue-100 text-blue-800'
                                                ];
                                            @endphp
                                            <span class="px-2 py-1 rounded-full text-xs font-bold {{ $statusColors[$reg->status] ?? 'bg-gray-100' }}">
                                                {{ ucfirst(str_replace('_', ' ', $reg->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $reg->evaluator->name ?? 'Não Atribuído' }}
                                        </td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            <button @click="showAbstractModal = true; selectedReg = {{ json_encode($reg) }}" class="text-gray-400 hover:text-unirovuma-500"><i class="fas fa-eye"></i></button>
                                            @if($reg->abstract_filepath)
                                                <a href="{{ asset($reg->abstract_filepath) }}" target="_blank" class="text-gray-400 hover:text-blue-600"><i class="fas fa-download"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">Nenhum resumo encontrado.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 4: COMPROVATIVOS -->
                <div x-show="currentTab === 'payments'" x-transition:enter="transition ease-out duration-300">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Comprovativos de Pagamento</h2>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="px-6 py-4">Autor</th>
                                    <th class="px-6 py-4">Resumo Aceite</th>
                                    <th class="px-6 py-4 text-right">Comprovativo</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($payments ?? [] as $pay)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-800">{{ $pay->full_names }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600 truncate max-w-xs">{{ $pay->abstract_title }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <button @click="showProofModal = true; selectedProof = '{{ asset($pay->payment_proof) }}'; selectedReg = {{ json_encode($pay) }}" 
                                                class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-xs font-bold hover:bg-blue-200 transition">
                                                <i class="fas fa-search mr-1"></i> Visualizar
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-6 py-12 text-center text-gray-400">Nenhum comprovativo enviado.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 5: UTILIZADORES (Config) -->
                <div x-show="currentTab === 'users'" x-transition:enter="transition ease-out duration-300">
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
                        </table>
                    </div>
                </div>

                <!-- TAB 6: ÁREAS TEMÁTICAS -->
                <div x-show="currentTab === 'areas'" x-transition:enter="transition ease-out duration-300">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Áreas Temáticas</h2>
                        <button @click="showAreaModal = true" class="bg-unirovuma-gold text-unirovuma-900 px-4 py-2 rounded-lg text-sm font-bold hover:bg-yellow-400 shadow">
                            <i class="fas fa-plus mr-2"></i> Nova Área
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($thematic_areas ?? [] as $area)
                            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition group relative">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="font-bold text-lg text-unirovuma-900">{{ $area->name }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($area->description, 50) }}</p>
                                    </div>
                                    <div class="bg-blue-50 p-2 rounded-lg text-blue-600"><i class="fas fa-tag"></i></div>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <form action="{{ route('thematic_areas.destroy', $area->id) }}" method="POST" onsubmit="return confirm('Apagar esta área?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-sm text-red-400 hover:text-red-600">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                                <p class="text-gray-500">Nenhuma área temática cadastrada.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- ==================== MODAIS ==================== -->
    <div x-show="showUserModal || showAreaModal || showAbstractModal || showDateModal || showProofModal"
        class="fixed inset-0 z-40 bg-gray-900 bg-opacity-60 backdrop-blur-sm" x-cloak></div>

    <!-- 1. MODAL USER (CRIAR E EDITAR) -->
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
                    <div x-show="userForm.role_id == '2' || userForm.role_id == '3'" x-transition>
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

    <!-- 2. MODAL AREA -->
    <div x-show="showAreaModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden" @click.away="showAreaModal = false">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Nova Área Temática</h3>
                <button @click="showAreaModal = false" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
            </div>
            <form action="{{ route('thematic_areas.store') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <input type="text" name="name" placeholder="Nome da Área" required class="w-full border-gray-300 rounded-lg p-2 border">
                    <textarea name="description" placeholder="Descrição (Opcional)" rows="3" class="w-full border-gray-300 rounded-lg p-2 border"></textarea>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showAreaModal = false" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-unirovuma-gold text-unirovuma-900 font-bold rounded-lg hover:bg-yellow-400 shadow">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. MODAL DETALHES RESUMO -->
    <div x-show="showAbstractModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden" @click.away="showAbstractModal = false">
            <div class="bg-unirovuma-900 px-6 py-4 flex justify-between items-center">
                <h3 class="text-white font-semibold">Detalhes Completos</h3>
                <button @click="showAbstractModal = false" class="text-gray-300 hover:text-white"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[75vh]">
                <h2 class="text-xl font-bold text-gray-800 mb-2" x-text="selectedReg?.abstract_title"></h2>
                
                <div class="flex flex-wrap gap-2 mb-4 text-sm text-gray-600">
                    <span><strong>Autor:</strong> <span x-text="selectedReg?.full_names"></span></span> |
                    <span><strong>Eixo:</strong> <span x-text="selectedReg?.thematic_axis"></span></span>
                </div>

                <template x-if="selectedReg?.feedback">
                    <div class="mb-4 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r">
                        <p class="text-xs font-bold text-yellow-800 uppercase mb-1">Parecer do Avaliador</p>
                        <p class="text-sm text-gray-800 italic" x-text="selectedReg?.feedback"></p>
                    </div>
                </template>

                <div class="border-t pt-4">
                    <p class="text-gray-700 text-justify leading-relaxed whitespace-pre-line" x-text="selectedReg?.abstract_content"></p>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <button @click="showAbstractModal = false" class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-white">Fechar</button>
            </div>
        </div>
    </div>

    <!-- 4. MODAL DATA IMPORTANTE (Criar/Editar) -->
    <div x-show="showDateModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden" @click.away="showDateModal = false">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800" x-text="selectedDate.id ? 'Editar Data' : 'Nova Data Importante'"></h3>
                <button @click="showDateModal = false" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
            </div>
            
            <form :action="selectedDate.id ? '/important-dates/' + selectedDate.id : '{{ route('dates.store') }}'" method="POST" class="p-6">
                @csrf
                <template x-if="selectedDate.id">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Descrição</label>
                        <input type="text" name="descricao" x-model="selectedDate.descricao" placeholder="Ex: Início das Submissões" required class="w-full border-gray-300 rounded-lg p-2 border">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Data</label>
                        <input type="date" name="data" x-model="selectedDate.data" required class="w-full border-gray-300 rounded-lg p-2 border">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showDateModal = false" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-unirovuma-900 text-white font-bold rounded-lg hover:bg-blue-900 shadow">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 5. MODAL VER COMPROVATIVO -->
    <div x-show="showProofModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl overflow-hidden h-[90vh] flex flex-col" @click.away="showProofModal = false">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center shrink-0">
                <h3 class="font-bold text-gray-800">Comprovativo: <span x-text="selectedReg?.full_names" class="text-blue-600"></span></h3>
                <button @click="showProofModal = false" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
            </div>
            
            <div class="flex-1 bg-gray-200 p-4 flex items-center justify-center overflow-auto">
                <template x-if="selectedProof">
                    <iframe :src="selectedProof" class="w-full h-full border rounded shadow-sm bg-white"></iframe>
                </template>
            </div>

            <div class="bg-white px-6 py-4 border-t border-gray-100 flex justify-end gap-3 shrink-0">
                <button @click="showProofModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Fechar</button>
                <a :href="selectedProof" target="_blank" download class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow">
                    <i class="fas fa-download mr-1"></i> Baixar
                </a>
            </div>
        </div>
    </div>

</body>
</html>