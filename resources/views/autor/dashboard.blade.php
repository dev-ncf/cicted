<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Resumo - CICTED</title>

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
          sidebarOpen: false, 
          showEditModal: false,
          showPaymentModal: false,
          // Assumindo que o backend envia UM único objeto 'registration'
          reg: {{ $registration ?? null}} 
      }">

    <div class="flex h-screen overflow-hidden">

        <!-- OVERLAY MOBILE -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak
             class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 lg:hidden transition-opacity"></div>

        <!-- SIDEBAR SIMPLIFICADA -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-gray-200 transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0 flex flex-col">
            
            <div class="h-20 flex items-center justify-center border-b border-gray-100 bg-unirovuma-900">
                <div class="flex items-center gap-2">
                    <i class="fas fa-feather-alt text-unirovuma-gold text-2xl"></i>
                    <span class="text-lg font-bold tracking-wide text-white">CICTED <span class="text-unirovuma-gold">AUTOR</span></span>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                <!-- Único Link -->
                <a href="#" class="flex items-center px-4 py-3 text-sm rounded-lg bg-blue-50 text-unirovuma-900 font-bold border-r-4 border-unirovuma-900">
                    <i class="fas fa-file-alt w-6 text-lg text-center"></i>
                    <span class="ml-3">Meu Resumo</span>
                </a>
            </nav>

            <div class="p-4 border-t border-gray-100">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full bg-unirovuma-900 text-white flex items-center justify-center font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full flex items-center justify-center px-4 py-2 text-xs font-bold text-red-500 border border-red-100 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
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
                <span class="font-bold text-unirovuma-900">Meu Resumo</span>
                <div class="w-6"></div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 lg:p-8">

                <!-- FEEDBACK MESSAGE -->
                @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center shadow-sm animate-fade-in-down">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <div><p class="font-bold">Sucesso!</p><p class="text-sm">{{ session('success') }}</p></div>
                </div>
                @endif

                <!-- ÁREA DO RESUMO ÚNICO -->
                <template x-if="reg">
                    <div class="max-w-4xl mx-auto space-y-6">
                        
                        <!-- 1. BARRA DE STATUS -->
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                            <div>
                                <h2 class="text-sm font-bold text-gray-400 uppercase tracking-wide mb-1">Situação Atual</h2>
                                
                                <!-- Lógica de Exibição do Status -->
                                <div class="flex items-center gap-2">
                                    <!-- Status: Submetido -->
                                    <template x-if="reg.status == 'submetido'">
                                        <div class="flex items-center text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                                            <span class="w-2 h-2 bg-gray-500 rounded-full mr-2"></span>
                                            <span class="font-bold">Submetido (Aguardando Análise)</span>
                                        </div>
                                    </template>
                                    <!-- Status: Em Avaliação -->
                                    <template x-if="reg.status == 'em_avaliacao'">
                                        <div class="flex items-center text-yellow-700 bg-yellow-50 px-3 py-1 rounded-full border border-yellow-100">
                                            <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></span>
                                            <span class="font-bold">Em Avaliação</span>
                                        </div>
                                    </template>
                                    <!-- Status: Aceite -->
                                    <template x-if="reg.status == 'aceite'">
                                        <div class="flex items-center text-green-700 bg-green-50 px-3 py-1 rounded-full border border-green-100">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            <span class="font-bold">Aceite</span>
                                        </div>
                                    </template>
                                    <!-- Status: Correções / Devolvido -->
                                    <template x-if="reg.status == 'aceite_correcoes' || reg.status == 'devolvido'">
                                        <div class="flex items-center text-red-700 bg-red-50 px-3 py-1 rounded-full border border-red-100">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            <span class="font-bold" x-text="reg.status == 'devolvido' ? 'Devolvido' : 'Correções Necessárias'"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Botões de Ação Principais -->
                            <div class="flex gap-3">
                                <!-- Botão EDITAR (Só se permitido) -->
                                <template x-if="['submetido', 'devolvido', 'aceite_correcoes'].includes(reg.status)">
                                    <button @click="showEditModal = true" class="bg-white border border-gray-300 text-gray-700 hover:text-unirovuma-900 hover:border-unirovuma-900 px-4 py-2 rounded-lg font-bold transition shadow-sm flex items-center">
                                        <i class="fas fa-edit mr-2"></i> Editar Resumo
                                    </button>
                                </template>

                                <!-- Botão PAGAMENTO (Só se aceite) -->
                                <template x-if="reg.status == 'aceite'">
                                    <button @click="showPaymentModal = true" class="bg-green-600 text-white hover:bg-green-700 px-5 py-2 rounded-lg font-bold transition shadow-md flex items-center animate-bounce-short">
                                        <i class="fas fa-upload mr-2"></i> Enviar Comprovativo
                                    </button>
                                </template>
                            </div>
                        </div>

                        <!-- 2. CARTÃO DE FEEDBACK (Se existir) -->
                        <template x-if="reg.feedback">
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-r shadow-sm">
                                <h3 class="text-yellow-800 font-bold uppercase text-sm mb-2 flex items-center">
                                    <i class="fas fa-comment-dots mr-2"></i> Parecer da Comissão
                                </h3>
                                <div class="bg-white p-4 rounded border border-yellow-100 text-gray-800 italic" x-text="reg.feedback"></div>
                                <p class="text-xs text-yellow-700 mt-2 font-medium">Por favor, utilize o botão "Editar Resumo" acima para aplicar as alterações solicitadas.</p>
                            </div>
                        </template>

                        <!-- 3. DETALHES DO RESUMO -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                                <h3 class="font-bold text-gray-800 text-lg">Dados da Submissão</h3>
                            </div>
                            <div class="p-8 space-y-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Título do Trabalho</label>
                                    <h1 class="text-xl font-bold text-unirovuma-900 leading-tight" x-text="reg.abstract_title"></h1>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Área Temática</label>
                                        <p class="text-gray-800 font-medium bg-gray-50 p-2 rounded border border-gray-100 inline-block" x-text="reg.thematic_axis"></p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Data de Envio</label>
                                        <!-- Formatação de data simples via JS se necessário, ou vindo do PHP -->
                                        <p class="text-gray-800 font-medium" x-text="new Date(reg.created_at).toLocaleDateString('pt-PT')"></p>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Texto do Resumo</label>
                                    <div class="text-gray-700 text-justify leading-relaxed bg-gray-50 p-6 rounded-lg border border-gray-100 whitespace-pre-line" x-text="reg.abstract_content"></div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Ficheiro Anexado</label>
                                    <template x-if="reg.abstract_filepath">
                                        <a :href="'{{ asset('') }}' + reg.abstract_filepath" target="_blank" class="inline-flex items-center px-4 py-3 bg-white border border-gray-200 rounded-lg text-gray-700 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition group">
                                            <div class="w-10 h-10 rounded-full bg-red-100 text-red-500 flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                                <i class="fas fa-file-pdf text-lg"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-sm">Visualizar Documento Original</p>
                                                <p class="text-xs text-gray-400">Clique para abrir</p>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </div>

                            <!-- Área de Comprovativo (Rodapé do Card) -->
                            <div class="bg-gray-50 px-8 py-6 border-t border-gray-100 flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase">Estado do Pagamento</p>
                                    <template x-if="reg.payment_proof">
                                        <p class="text-green-600 font-bold flex items-center"><i class="fas fa-check-circle mr-1"></i> Comprovativo Enviado</p>
                                    </template>
                                    <template x-if="!reg.payment_proof">
                                        <p class="text-gray-500 italic text-sm">Ainda não enviado</p>
                                    </template>
                                </div>
                            </div>
                        </div>

                    </div>
                </template>

                <!-- CASO NÃO EXISTA RESUMO (Fallback) -->
                <template x-if="!reg">
                    <div class="flex flex-col items-center justify-center h-full text-center p-8 bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-400">
                            <i class="fas fa-folder-open text-4xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Nenhum Resumo Encontrado</h2>
                        <p class="text-gray-500 max-w-md mx-auto">Não encontramos nenhuma submissão associada à sua conta. Entre em contacto com a organização se acredita que isto é um erro.</p>
                    </div>
                </template>

            </main>
        </div>
    </div>

    <!-- MODAL DE EDIÇÃO -->
    <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm" @click="showEditModal = false"></div>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl overflow-hidden z-10 relative transform transition-all">
            <div class="bg-unirovuma-900 px-6 py-4 flex justify-between items-center">
                <h3 class="text-white font-bold text-lg"><i class="fas fa-edit mr-2"></i>Editar Resumo</h3>
                <button @click="showEditModal = false" class="text-gray-300 hover:text-white"><i class="fas fa-times"></i></button>
            </div>
            
            <form :action="'{{ url('registrations') }}/' + reg?.id" method="POST" enctype="multipart/form-data" class="p-8 overflow-y-auto max-h-[80vh]">
                @csrf
                @method('PUT')
                
                <div class="mb-6 bg-blue-50 text-blue-800 p-4 rounded-lg text-sm border border-blue-100 flex items-start">
                    <i class="fas fa-info-circle mr-2 mt-0.5"></i>
                    <p>Você está editando o resumo existente. As alterações substituirão a versão anterior e o status voltará para <strong>"Submetido"</strong> para nova análise.</p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Título do Trabalho</label>
                        <input type="text" name="abstract_title" x-model="reg.abstract_title" required class="w-full border-gray-300 rounded-lg p-3 border focus:ring-2 focus:ring-unirovuma-500">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Conteúdo do Resumo</label>
                        <textarea name="abstract_content" x-model="reg.abstract_content" rows="8" required class="w-full border-gray-300 rounded-lg p-3 border focus:ring-2 focus:ring-unirovuma-500 text-sm leading-relaxed"></textarea>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Substituir Ficheiro (Opcional)</label>
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <input type="file" name="abstract_file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Carregue apenas se desejar substituir o PDF atual.</p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" @click="showEditModal = false" class="px-5 py-2.5 text-gray-600 hover:bg-gray-100 rounded-lg font-medium">Cancelar</button>
                    <button type="submit" class="px-6 py-2.5 bg-unirovuma-900 text-white font-bold rounded-lg hover:bg-blue-900 shadow-lg transform transition hover:-translate-y-0.5">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL PAGAMENTO -->
    <div x-show="showPaymentModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm" @click="showPaymentModal = false"></div>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden z-10 relative">
            <div class="bg-green-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-white font-bold text-lg"><i class="fas fa-receipt mr-2"></i>Enviar Comprovativo</h3>
                <button @click="showPaymentModal = false" class="text-green-100 hover:text-white"><i class="fas fa-times"></i></button>
            </div>
            
            <form action="{{ route('submissions.upload_proof') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <input type="hidden" name="registration_id" :value="reg?.id">
                
                <div class="text-center mb-6">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3 text-xl">
                        <i class="fas fa-check"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Resumo Aceite!</h4>
                    <p class="text-sm text-gray-500 mt-1">
                        Para finalizar sua participação, anexe o comprovativo de pagamento abaixo.
                    </p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Ficheiro (Imagem ou PDF)</label>
                    <input type="file" name="payment_proof" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" @click="showPaymentModal = false" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm font-medium">Cancelar</button>
                    <button type="submit" class="px-5 py-2 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 shadow text-sm">Enviar Comprovativo</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>