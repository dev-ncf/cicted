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
    showPasswordModal: false, 
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

                <a href="{{ route('dashboard-admin') }}"  false"
                    :class="{{request()->routeIs('dashboard-admin') ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'}}"
                    class="{{request()->routeIs('dashboard-admin') ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'}} flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-chart-pie w-6 text-lg text-center"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <a href="{{ route('admin.datas') }}" se"
                    :class="currentTab === 'dates' ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'"
                    class="{{request()->routeIs('admin.datas') ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'}} flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-calendar-alt w-6 text-lg text-center"></i>
                    <span class="ml-3">Datas Importantes</span>
                </a>

                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-4">Científico</p>

                <a href="{{ route('admin.resumos') }}" en = false"
                    :class="currentTab === 'registrations' ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'"
                    class="{{request()->routeIs('admin.resumos') ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'}} flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-layer-group w-6 text-lg text-center"></i>
                    <span class="ml-3">Resumos / Submissões</span>
                </a>

                <a href="{{ route('admin.comprovativos') }}" false"
                    :class="currentTab === 'payments' ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'"
                    class="{{request()->routeIs('admin.comprovativos') ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'}} flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-receipt w-6 text-lg text-center"></i>
                    <span class="ml-3">Comprovativos</span>
                </a>

                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-4">Configuração</p>

                <a href="{{ route('admin.users') }}" se"
                    :class="currentTab === 'users' ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'"
                    class=" {{request()->routeIs('admin.users') ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'}} flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-users w-6 text-lg text-center"></i>
                    <span class="ml-3">Utilizadores</span>
                </a>

                <a href="{{ route('admin.areas') }}" se"
                    :class="currentTab === 'areas' ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'"
                    class="{{request()->routeIs('admin.areas') ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' : 'text-gray-300 hover:bg-unirovuma-800'}} flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-tags w-6 text-lg text-center"></i>
                    <span class="ml-3">Áreas Temáticas</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full bg-unirovuma-900 border-2 text-white flex items-center justify-center font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-sm font-bold text-gray-400 truncate">{{ Auth::user()->name }}</p>
                    </div>
                </div>
                
                <!-- NOVO BOTÃO DE ALTERAR SENHA -->
                <button @click="showPasswordModal = true"
                    class="w-full flex items-center justify-center px-4 py-2 mb-2 text-xs font-bold text-unirovuma-900 border border-gray-200 bg-white rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-key mr-2"></i> Alterar Senha
                </button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full flex items-center justify-center px-4 py-2 text-xs font-bold text-red-500 border border-red-100 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
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

                

                @yield('admin.content')
               

            </main>
        </div>
    </div>

    <!-- ==================== MODAIS ==================== -->
    <div x-show="showUserModal || showAreaModal || showAbstractModal || showDateModal || showProofModal"
        class="fixed inset-0 z-40 bg-gray-900 bg-opacity-60 backdrop-blur-sm" x-cloak></div>
@yield('modal')
    
    <!-- MODAL ALTERAR SENHA -->
    <div x-show="showPasswordModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm" @click="showPasswordModal = false"></div>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden z-10 relative">
            <div class="bg-unirovuma-900 px-6 py-4 flex justify-between items-center">
                <h3 class="text-white font-bold text-lg"><i class="fas fa-lock mr-2"></i>Alterar Minha Senha</h3>
                <button @click="showPasswordModal = false" class="text-gray-300 hover:text-white"><i class="fas fa-times"></i></button>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Senha Atual</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-shield-alt"></i>
                            </span>
                            <input type="password" name="current_password" required
                                class="w-full border-gray-300 rounded-lg p-2.5 pl-10 border focus:ring-2 focus:ring-unirovuma-900 outline-none text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nova Senha</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-key"></i>
                            </span>
                            <input type="password" name="password" required
                                class="w-full border-gray-300 rounded-lg p-2.5 pl-10 border focus:ring-2 focus:ring-unirovuma-900 outline-none text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Confirmar Nova Senha</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <i class="fas fa-check-double"></i>
                            </span>
                            <input type="password" name="password_confirmation" required
                                class="w-full border-gray-300 rounded-lg p-2.5 pl-10 border focus:ring-2 focus:ring-unirovuma-900 outline-none text-sm">
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" @click="showPasswordModal = false"
                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm font-medium transition">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-unirovuma-gold text-unirovuma-900 font-bold rounded-lg hover:bg-yellow-500 shadow transition text-sm">
                        Atualizar Senha
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>