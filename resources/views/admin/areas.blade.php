@extends('admin.dashboard')
@section('admin.content')
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
@endsection
@section('modal')
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

@endsection