<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Avaliador - CICTED</title>

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
    currentTab: 'assignments',
    sidebarOpen: false,
    showEvaluationModal: false,
    selectedReg: null,

    // Lógica de Pontuação
    scores: {
        intro: 0,
        objectives: 0,
        methodology: 0,
        results: 0,
        conclusions: 0,
        keywords: 0,
        style: 0
    },
    get totalScore() {
        return parseInt(this.scores.intro) +
            parseInt(this.scores.objectives) +
            parseInt(this.scores.methodology) +
            parseInt(this.scores.results) +
            parseInt(this.scores.conclusions) +
            parseInt(this.scores.keywords) +
            parseInt(this.scores.style);
    },
    resetScores() {
        this.scores = { intro: 0, objectives: 0, methodology: 0, results: 0, conclusions: 0, keywords: 0, style: 0 };
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
                <div class="flex items-center gap-2">
                    <i class="fas fa-glasses text-unirovuma-gold text-2xl"></i>
                    <span class="text-lg font-bold tracking-wide">CICTED <span
                            class="text-unirovuma-gold">AVALIADOR</span></span>
                </div>
            </div>

            <!-- Info Área -->
            <div class="px-4 py-4 bg-unirovuma-800 border-b border-unirovuma-900">
                <p class="text-xs text-gray-400 uppercase font-bold">Especialidade</p>
                <p class="text-sm font-bold text-white mt-1">
                    <i class="fas fa-bookmark mr-1 text-unirovuma-gold"></i> {{ Auth::user()->thematic_area }}
                </p>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="#" @click.prevent="currentTab = 'assignments'"
                    :class="currentTab === 'assignments' ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' :
                        'text-gray-300 hover:bg-unirovuma-800'"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-list-check w-6 text-lg text-center"></i>
                    <span class="ml-3">Minhas Avaliações</span>
                </a>

                <a href="#" @click.prevent="currentTab = 'history'"
                    :class="currentTab === 'history' ? 'bg-unirovuma-800 border-r-4 border-unirovuma-gold text-white' :
                        'text-gray-300 hover:bg-unirovuma-800'"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all">
                    <i class="fas fa-history w-6 text-lg text-center"></i>
                    <span class="ml-3">Histórico</span>
                </a>
            </nav>

            <div class="p-4 border-t border-unirovuma-800 bg-unirovuma-900">
                <div class="flex items-center mb-3">
                    <div
                        class="w-10 h-10 rounded-full bg-white text-unirovuma-900 flex items-center justify-center font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400">Avaliador</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="w-full flex items-center justify-center px-4 py-2 text-xs font-medium text-red-300 bg-unirovuma-800 rounded-md hover:bg-red-900 hover:text-white transition-colors">
                        <i class="fas fa-sign-out-alt mr-2"></i> Sair
                    </button>
                </form>
            </div>
        </aside>

        <!-- CONTEÚDO PRINCIPAL -->
        <div class="flex-1 flex flex-col overflow-hidden relative">

            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-4 lg:hidden z-10">
                <button @click="sidebarOpen = true" class="text-gray-500"><i class="fas fa-bars text-2xl"></i></button>
                <span class="font-bold text-unirovuma-900">Área de Avaliação</span>
                <div class="w-6"></div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 lg:p-8">

                <!-- Mensagens -->
                @if (session('success'))
                    <div
                        class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r shadow-sm text-sm text-green-700 font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- TAB 1: LISTA DE AVALIAÇÕES PENDENTES -->
                <div x-show="currentTab === 'assignments'" x-transition:enter="transition ease-out duration-300">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Resumos Atribuídos</h2>
                        <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100 text-sm">
                            <span class="text-gray-500">Pendentes:</span>
                            <span class="font-bold text-unirovuma-900 ml-1">{{ $assignments->count() ?? 0 }}</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="px-6 py-4">Título do Resumo</th>
                                    <th class="px-6 py-4">Data Atribuição</th>
                                    <th class="px-6 py-4">Prazo</th>
                                    <th class="px-6 py-4 text-right">Ação</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($assignments ?? [] as $reg)
                                    <tr class="hover:bg-gray-50 transition group">
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-gray-800 text-sm mb-1 line-clamp-2">
                                                {{ $reg->title }}</p>
                                            <div class="flex gap-2">
                                                <span
                                                    class="text-xs bg-blue-50 text-blue-700 px-2 py-0.5 rounded border border-blue-100">{{ $reg->thematic->name }}</span>

                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $reg->updated_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="text-xs font-bold text-red-500 bg-red-50 px-2 py-1 rounded">{{ $reg->prazo ? \Carbon\Carbon::parse($reg->prazo)->format('d/m/Y') : null }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button
                                                @click="showEvaluationModal = true; selectedReg = {{ json_encode($reg) }}; resetScores()"
                                                class="bg-unirovuma-900 text-white hover:bg-blue-800 px-4 py-2 rounded-lg text-sm font-bold shadow-md transition-transform transform active:scale-95 flex items-center ml-auto">
                                                <i class="fas fa-edit mr-2"></i> Avaliar
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                            <i class="fas fa-check-circle text-4xl mb-3 text-green-100"></i>
                                            <p>Parabéns! Não tem avaliações pendentes.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- ================= MODAL DE AVALIAÇÃO (SPLIT SCREEN) ================= -->
    <div x-show="showEvaluationModal" class="fixed inset-0 z-50 flex items-center justify-center p-2 sm:p-4" x-cloak>
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm" @click="showEvaluationModal = false">
        </div>

        <!-- Container Principal -->
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-7xl h-[95vh] z-10 flex flex-col overflow-hidden">

            <!-- Header -->
            <div class="bg-unirovuma-900 px-6 py-4 flex justify-between items-center shrink-0">
                <h3 class="text-white font-bold text-lg flex items-center">
                    <i class="fas fa-clipboard-check mr-3 text-unirovuma-gold"></i> Ficha de Avaliação
                </h3>
                <button @click="showEvaluationModal = false" class="text-gray-300 hover:text-white"><i
                        class="fas fa-times fa-lg"></i></button>
            </div>

            <!-- Corpo (Split) -->
            <div class="flex flex-col lg:flex-row flex-1 overflow-hidden">

                <!-- COLUNA ESQUERDA: O RESUMO (Leitura) -->
                <div class="w-full lg:w-5/12 bg-gray-50 border-r border-gray-200 overflow-y-auto p-6">
                    <div class="mb-4">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Título do
                            Trabalho</span>
                        <h2 class="text-lg font-bold text-gray-900 leading-snug mt-1"
                            x-text="selectedReg?.title"></h2>
                    </div>

                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="bg-white border px-2 py-1 rounded text-xs text-gray-600 font-medium shadow-sm">
                            <i class="fas fa-tag mr-1 text-blue-500"></i> <span
                                x-text="selectedReg?.thematic.name"></span>
                        </span>
                        <!-- Palavras-chave -->
                        <span class="bg-white border px-2 py-1 rounded text-xs text-gray-600 font-medium shadow-sm">
                            <i class="fas fa-key mr-1 text-yellow-600"></i> <span
                                x-text="selectedReg?.keywords || 'Sem palavras-chave'"></span>
                        </span>
                    </div>

                    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm mb-6">
                        <span
                            class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 block">Conteúdo</span>
                        <div class="text-sm text-gray-800 text-justify leading-relaxed whitespace-pre-line"
                            x-text="selectedReg?.abstract"></div>
                    </div>

                    <template x-if="selectedReg?.abstract_filepath">
                        <a :href="'{{ asset('') }}' + selectedReg?.abstract_filepath" target="_blank"
                            class="flex items-center justify-center w-full py-3 bg-blue-100 text-blue-800 rounded-lg hover:bg-blue-200 transition font-bold text-sm">
                            <i class="fas fa-file-word mr-2"></i> Baixar o Documento
                        </a>
                    </template>
                </div>

                <!-- COLUNA DIREITA: FORMULÁRIO DE AVALIAÇÃO -->
                <div class="w-full lg:w-7/12 bg-white overflow-y-auto p-6">

                    <form action="{{ route('evaluations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="registration_id" :value="selectedReg?.id">

                        <!-- 1. ESTRUTURA E CONTEÚDO (Binário) -->
                        <div class="mb-8">
                            <h4 class="font-bold text-gray-800 border-b pb-2 mb-4">1. Critérios Eliminatórios</h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Estrutura (Título, 300
                                        palavras, etc)</label>
                                    <div class="flex gap-4">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="structure_ok" value="1"
                                                class="w-4 h-4 text-green-600 focus:ring-green-500" required>
                                            <span class="ml-2 text-sm text-gray-700">Sim (Conforme)</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="structure_ok" value="0"
                                                class="w-4 h-4 text-red-600 focus:ring-red-500">
                                            <span class="ml-2 text-sm text-gray-700">Não</span>
                                        </label>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pertinência
                                        Temática</label>
                                    <div class="flex gap-4">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="content_ok" value="1"
                                                class="w-4 h-4 text-green-600 focus:ring-green-500" required>
                                            <span class="ml-2 text-sm text-gray-700">Sim</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" name="content_ok" value="0"
                                                class="w-4 h-4 text-red-600 focus:ring-red-500">
                                            <span class="ml-2 text-sm text-gray-700">Não</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-red-500 mt-2 italic">* Se responder "Não" em algum destes, o resumo
                                será automaticamente devolvido.</p>
                        </div>

                        <!-- 2. ANÁLISE DETALHADA (Pontuação) -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center border-b pb-2 mb-4">
                                <h4 class="font-bold text-gray-800">2. Avaliação Quantitativa</h4>
                                <div class="bg-unirovuma-900 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    Total: <span x-text="totalScore">0</span> / 100
                                </div>
                            </div>

                            <div class="space-y-4">
                                <!-- Introdução -->
                                <div class="grid grid-cols-12 gap-4 items-center bg-gray-50 p-3 rounded">
                                    <div class="col-span-8 md:col-span-10">
                                        <p class="text-sm font-medium text-gray-700">Introdução (Contexto, Problema,
                                            Justificativa)</p>
                                        <p class="text-xs text-gray-500">0-3 (Fraco) | 4-7 (Aceitável) | 8-15 (Bom)</p>
                                    </div>
                                    <div class="col-span-4 md:col-span-2">
                                        <input type="number" name="score_intro" x-model="scores.intro"
                                            min="0" max="15"
                                            class="w-full border-gray-300 rounded-md text-center font-bold focus:ring-unirovuma-500"
                                            required>
                                    </div>
                                </div>

                                <!-- Objectivos -->
                                <div
                                    class="grid grid-cols-12 gap-4 items-center bg-white p-3 rounded border border-gray-100">
                                    <div class="col-span-8 md:col-span-10">
                                        <p class="text-sm font-medium text-gray-700">Objectivos (Clareza)</p>
                                        <p class="text-xs text-gray-500">Máx: 15 pontos</p>
                                    </div>
                                    <div class="col-span-4 md:col-span-2">
                                        <input type="number" name="score_objectives" x-model="scores.objectives"
                                            min="0" max="15"
                                            class="w-full border-gray-300 rounded-md text-center font-bold focus:ring-unirovuma-500"
                                            required>
                                    </div>
                                </div>

                                <!-- Metodologia -->
                                <div class="grid grid-cols-12 gap-4 items-center bg-gray-50 p-3 rounded">
                                    <div class="col-span-8 md:col-span-10">
                                        <p class="text-sm font-medium text-gray-700">Metodologia (Adequação)</p>
                                        <p class="text-xs text-gray-500">Máx: 15 pontos</p>
                                    </div>
                                    <div class="col-span-4 md:col-span-2">
                                        <input type="number" name="score_methodology" x-model="scores.methodology"
                                            min="0" max="15"
                                            class="w-full border-gray-300 rounded-md text-center font-bold focus:ring-unirovuma-500"
                                            required>
                                    </div>
                                </div>

                                <!-- Resultados -->
                                <div
                                    class="grid grid-cols-12 gap-4 items-center bg-white p-3 rounded border border-gray-100">
                                    <div class="col-span-8 md:col-span-10">
                                        <p class="text-sm font-medium text-gray-700">Resultados (Ligação com
                                            Metodologia)</p>
                                        <p class="text-xs text-gray-500">0-5 (Fraco) | 6-10 (Aceitável) | 11-20 (Bom)
                                        </p>
                                    </div>
                                    <div class="col-span-4 md:col-span-2">
                                        <input type="number" name="score_results" x-model="scores.results"
                                            min="0" max="20"
                                            class="w-full border-gray-300 rounded-md text-center font-bold focus:ring-unirovuma-500"
                                            required>
                                    </div>
                                </div>

                                <!-- Conclusões -->
                                <div class="grid grid-cols-12 gap-4 items-center bg-gray-50 p-3 rounded">
                                    <div class="col-span-8 md:col-span-10">
                                        <p class="text-sm font-medium text-gray-700">Conclusões (Coerência)</p>
                                        <p class="text-xs text-gray-500">Máx: 15 pontos</p>
                                    </div>
                                    <div class="col-span-4 md:col-span-2">
                                        <input type="number" name="score_conclusions" x-model="scores.conclusions"
                                            min="0" max="15"
                                            class="w-full border-gray-300 rounded-md text-center font-bold focus:ring-unirovuma-500"
                                            required>
                                    </div>
                                </div>

                                <!-- Palavras-chave -->
                                <div
                                    class="grid grid-cols-12 gap-4 items-center bg-white p-3 rounded border border-gray-100">
                                    <div class="col-span-8 md:col-span-10">
                                        <p class="text-sm font-medium text-gray-700">Palavras-chave (Pertinência)</p>
                                        <p class="text-xs text-gray-500">Máx: 10 pontos</p>
                                    </div>
                                    <div class="col-span-4 md:col-span-2">
                                        <input type="number" name="score_keywords" x-model="scores.keywords"
                                            min="0" max="10"
                                            class="w-full border-gray-300 rounded-md text-center font-bold focus:ring-unirovuma-500"
                                            required>
                                    </div>
                                </div>

                                <!-- Escrita -->
                                <div class="grid grid-cols-12 gap-4 items-center bg-gray-50 p-3 rounded">
                                    <div class="col-span-8 md:col-span-10">
                                        <p class="text-sm font-medium text-gray-700">Estilo de Escrita e Gramática</p>
                                        <p class="text-xs text-gray-500">Máx: 10 pontos</p>
                                    </div>
                                    <div class="col-span-4 md:col-span-2">
                                        <input type="number" name="score_style" x-model="scores.style"
                                            min="0" max="10"
                                            class="w-full border-gray-300 rounded-md text-center font-bold focus:ring-unirovuma-500"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. FEEDBACK QUALITATIVO & ARQUIVO -->
                        <div class="mb-8">
                            <h4 class="font-bold text-gray-800 border-b pb-2 mb-4">3. Parecer e Recomendações</h4>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Comentários do Revisor
                                    <span class="text-red-500">*</span></label>
                                <textarea name="feedback" rows="5"
                                    class="w-full border-gray-300 rounded-lg p-3 text-sm focus:ring-unirovuma-500"
                                    placeholder="Indique os pontos fortes, fracos e as correções necessárias..." required></textarea>
                            </div>

                            <div class="mb-4 bg-blue-50 p-4 rounded-lg border border-blue-100">
                                <label class="block text-sm font-bold text-blue-800 mb-2"><i
                                        class="fas fa-upload mr-2"></i>Submeter Resumo Corrigido (Opcional)</label>
                                <p class="text-xs text-gray-600 mb-2">Se fez anotações no ficheiro do autor ou tem uma
                                    versão sugerida, carregue aqui.</p>
                                <input type="file" name="reviewer_file"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-white file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>

                        <!-- 4. DECISÃO FINAL -->
                        <div class="mb-8 p-5 bg-gray-100 rounded-xl border border-gray-200">
                            <h4 class="font-bold text-gray-800 mb-4 uppercase text-sm">4. Veredito Final</h4>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Recomendação de
                                    Apresentação</label>
                                <div class="flex gap-6">
                                    <label class="flex items-center">
                                        <input type="radio" name="recommendation_type" value="Oral"
                                            class="text-unirovuma-900 focus:ring-unirovuma-500" required>
                                        <span class="ml-2 text-sm">Oral</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="recommendation_type" value="Poster"
                                            class="text-unirovuma-900 focus:ring-unirovuma-500">
                                        <span class="ml-2 text-sm">Poster</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Decisão</label>
                                <select name="status"
                                    class="w-full border-gray-300 rounded-lg p-3 font-bold focus:ring-unirovuma-500"
                                    required>
                                    <option value="">Selecione...</option>
                                    <option value="aceite" class="text-green-600">Aceite (Sem alterações)</option>
                                    <option value="aceite_correcoes" class="text-blue-600">Aceite com Correções
                                    </option>
                                    <option value="devolvido" class="text-red-600">Devolvido (Rejeitado)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="flex justify-end gap-3 pt-4 border-t">
                            <button type="button" @click="showEvaluationModal = false"
                                class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">Cancelar</button>
                            <button type="submit"
                                class="px-8 py-3 bg-unirovuma-900 text-white rounded-lg font-bold hover:bg-blue-900 shadow-lg transform transition hover:-translate-y-0.5">
                                Submeter Avaliação
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
