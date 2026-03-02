@extends('admin.dashboard')
@section('admin.content')
     <div x-transition:enter="transition ease-out duration-300">
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
                                @forelse($resumos ?? [] as $reg)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <p class="font-semibold text-gray-800 text-sm truncate w-64">{{ $reg->title }}</p>
                                            <p class="text-xs text-gray-500">{{ $reg->user->name }}</p>
                                        </td>
                                        <td class="px-6 py-4"><span class="px-2 py-1 rounded bg-blue-50 text-blue-700 text-xs font-medium">{{ $reg->thematic->name }}</span></td>
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
                        {{ $resumos->links() }}
                    </div>
                </div>
    
@endsection
@section('modal')
<div x-show="showAbstractModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden" @click.away="showAbstractModal = false">
            <div class="bg-unirovuma-900 px-6 py-4 flex justify-between items-center">
                <h3 class="text-white font-semibold">Detalhes Completos</h3>
                <button @click="showAbstractModal = false" class="text-gray-300 hover:text-white"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[75vh]">
                <h2 class="text-xl font-bold text-gray-800 mb-2" x-text="selectedReg?.title"></h2>
                
                <div class="flex flex-wrap gap-2 mb-4 text-sm text-gray-600">
                    <span><strong>Autor:</strong> <span x-text="selectedReg?.user.name"></span></span> |
                    <span><strong>Eixo:</strong> <span x-text="selectedReg?.thematic.name"></span></span>
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
    
@endsection