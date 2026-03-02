@extends('admin.dashboard')
@section('admin.content')
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
@endsection
@section('modal')
     

@endsection