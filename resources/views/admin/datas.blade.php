@extends('admin.dashboard')
@section('admin.content')
     <div >
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
                        {{ $datas->links() }}
                    </div>
                </div>
@endsection
@section('modal')
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
@endsection