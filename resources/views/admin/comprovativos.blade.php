@extends('admin.dashboard')
@section('admin.content')
 <div x-transition:enter="transition ease-out duration-300">
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
                                @forelse($comprovativos ?? [] as $pay)
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
                        {{ $comprovativos->links() }}
                    </div>
                </div>

    
@endsection
@section('modal')
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
    
@endsection