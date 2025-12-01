<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inscrições CICTED</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Configuração do Tailwind para usar as cores da UniRovuma
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
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen">
        <!-- Cabeçalho do Dashboard -->
        <header class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <h1 class="text-xl font-bold text-unirovuma-blue">Painel de Controlo CICTED</h1>
                    <!-- Formulário de Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Conteúdo Principal -->
        <main class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- Cartões de Estatísticas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <h3 class="text-lg font-medium text-gray-500">Total de Inscrições</h3>
                        <p class="mt-1 text-4xl font-bold text-unirovuma-blue">{{ $stats['total'] }}</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <h3 class="text-lg font-medium text-gray-500">Oradores</h3>
                        <p class="mt-1 text-4xl font-bold text-unirovuma-blue">{{ $stats['speakers'] }}</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <h3 class="text-lg font-medium text-gray-500">Ouvintes</h3>
                        <p class="mt-1 text-4xl font-bold text-unirovuma-blue">{{ $stats['attendees'] }}</p>
                    </div>
                </div>

                <!-- Tabela de Inscrições -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-unirovuma-blue-dark mb-4">Lista de Inscritos</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Instituição</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($registrations as $reg)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $reg->full_names }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            @if($reg->participant_type == 'orador')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Orador</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Ouvinte</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $reg->institution_country }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $reg->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <details class="relative">
                                                <summary class="cursor-pointer font-medium text-indigo-600 hover:text-indigo-900">Ver Detalhes</summary>
                                                <div class="absolute z-10 mt-2 p-4 bg-white border border-gray-200 rounded-lg shadow-lg w-96 right-0 space-y-2">
                                                    <p><strong>Nível Académico:</strong> {{ ucfirst($reg->academic_level) }}</p>
                                                    <p><strong>Ocupação:</strong> {{ ucfirst(str_replace('_', ' ', $reg->occupation)) }}</p>
                                                    @if ($reg->participant_type == 'orador')
                                                        <hr class="my-2">
                                                        <p><strong>Modalidade:</strong> {{ ucfirst(str_replace('_', ' ', $reg->presentation_modality)) }}</p>
                                                        <p><strong>Eixo Temático:</strong> {{ $reg->thematic_axis }}</p>
                                                        <p><strong>Palavras-chave:</strong> {{ $reg->keywords }}</p>
                                                        <p class="text-sm text-gray-600 mt-1"><strong>Resumo:</strong> {{ $reg->abstract_content }}</p>
                                                        @if ($reg->abstract_filepath)
                                                            <a href="{{ asset('storage/' . $reg->abstract_filepath) }}" target="_blank" class="mt-2 inline-block text-sm font-semibold text-blue-600 hover:underline">
                                                                Baixar Ficheiro do Resumo
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </details>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">Ainda não existem inscrições.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <!-- Links de Paginação -->
                    <div class="p-6 bg-white border-t border-gray-200">
                        {{ $registrations->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>