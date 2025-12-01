<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('form.title') }}</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="shortcut icon" href="{{ asset('img/logotipo-unirovuma.fw.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Configuração Personalizada do Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                        'lato': ['Lato', 'sans-serif'],
                    },
                    colors: {
                        'unirovuma-blue': '#0A2D57',
                        'unirovuma-blue-dark': '#06203E',
                        'unirovuma-gold': '#F2B900',
                        'unirovuma-gold-dark': '#D9A400',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-lato text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- ===== HEADER SIMPLES ===== -->
    <header class="bg-unirovuma-blue shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 md:px-6 py-3 md:py-4 flex justify-between items-center">
            <div>
                <!-- Logo ajustável -->
                <img src="{{ asset('img/logo.jpg') }}" alt="Logotipo UniRovuma" class="h-10 md:h-14 rounded-full border border-white/20">
            </div>
            <a href="/{{ app()->getLocale() }}" class="text-white hover:text-unirovuma-gold font-semibold text-sm md:text-base flex items-center gap-2 transition-colors">
                <!-- Ícone de seta para voltar (opcional, ajuda na UX mobile) -->
             
                {{ __('form.header.back_link') }}
            </a>
        </div>
    </header>

    <main class="flex-grow py-10 md:py-20">
        <div class="container mx-auto px-4 md:px-6">
            <div class="max-w-4xl mx-auto">
                <!-- Cabeçalho do Formulário -->
                <div class="text-center mb-8 md:mb-12">
                    <h1 class="font-poppins text-2xl md:text-4xl font-bold text-unirovuma-blue leading-tight">{{ __('form.main_title') }}</h1>
                    <p class="text-base md:text-lg text-gray-600 mt-3 px-2">{{ __('form.description') }}</p>
                </div>
                
                <!-- Área de Mensagens (Sucesso/Erro) -->
                <div class="text-center mb-8 md:mb-12">
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-md text-left shadow-sm" role="alert">
                            <p class="font-bold">Sucesso</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded-md text-left shadow-sm" role="alert">
                            <p class="font-bold">Por favor, corrija os erros abaixo:</p>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Card do Formulário -->
                <div class="bg-white rounded-xl shadow-xl p-6 md:p-12 border-t-4 border-unirovuma-gold">
                    <form action="{{ route('registration.store', app()->getLocale()) }}" method="POST" enctype="multipart/form-data" class="space-y-6 md:space-y-8">
                        @csrf

                        <!-- Nomes -->
                        <input type="hidden" name="lang" value="{{ str_replace('_', '-', app()->getLocale()) }}">
                        <div>
                            <label for="autores" class="block font-poppins font-semibold text-unirovuma-blue-dark mb-2 text-sm md:text-base">{{ __('form.labels.full_name') }} <span class="text-red-500">*</span></label>
                            <input type="text" id="autores" name="full_names" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-unirovuma-gold transition-all" required>
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block font-poppins font-semibold text-unirovuma-blue-dark mb-2 text-sm md:text-base">{{ __('form.labels.email') }} <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-unirovuma-gold transition-all" required>
                        </div>

                        <!-- Grid para Nível Académico e Ocupação (Lado a lado em desktop) -->
                        <div class="grid md:grid-cols-2 gap-6 md:gap-8">
                            <!-- Nível Académico -->
                            <fieldset class="bg-gray-50 p-4 rounded-lg">
                                <legend class="font-poppins font-semibold text-unirovuma-blue-dark mb-3 text-sm md:text-base">{{ __('form.labels.academic_level') }} <span class="text-red-500">*</span></legend>
                                <div class="space-y-3">
                                    <label class="flex items-start cursor-pointer group">
                                        <div class="flex items-center h-5">
                                            <input type="radio" name="academic_level" value="doutor" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold border-gray-300">
                                        </div>
                                        <span class="ml-3 text-sm md:text-base group-hover:text-unirovuma-blue transition-colors">{{ __('form.options.level.phd') }}</span>
                                    </label>
                                    <label class="flex items-start cursor-pointer group">
                                        <div class="flex items-center h-5">
                                            <input type="radio" name="academic_level" value="mestre" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold border-gray-300">
                                        </div>
                                        <span class="ml-3 text-sm md:text-base group-hover:text-unirovuma-blue transition-colors">{{ __('form.options.level.master') }}</span>
                                    </label>
                                    <label class="flex items-start cursor-pointer group">
                                        <div class="flex items-center h-5">
                                            <input type="radio" name="academic_level" value="licenciado" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold border-gray-300">
                                        </div>
                                        <span class="ml-3 text-sm md:text-base group-hover:text-unirovuma-blue transition-colors">{{ __('form.options.level.bachelor') }}</span>
                                    </label>
                                    <label class="flex items-start cursor-pointer group">
                                        <div class="flex items-center h-5">
                                            <input type="radio" name="academic_level" value="medio" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold border-gray-300">
                                        </div>
                                        <span class="ml-3 text-sm md:text-base group-hover:text-unirovuma-blue transition-colors">{{ __('form.options.level.technician') }}</span>
                                    </label>
                                    <label class="flex items-start cursor-pointer group">
                                        <div class="flex items-center h-5">
                                            <input type="radio" name="academic_level" value="medio" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold border-gray-300">
                                        </div>
                                        <span class="ml-3 text-sm md:text-base group-hover:text-unirovuma-blue transition-colors">{{ __('form.options.level.outher') }}</span>
                                    </label>
                                </div>
                            </fieldset>

                            <!-- Ocupação -->
                            <fieldset class="bg-gray-50 p-4 rounded-lg">
                                <legend class="font-poppins font-semibold text-unirovuma-blue-dark mb-3 text-sm md:text-base">{{ __('form.labels.occupation') }} <span class="text-red-500">*</span></legend>
                                <div class="space-y-3">
                                    <label class="flex items-start cursor-pointer group">
                                        <div class="flex items-center h-5">
                                            <input type="radio" name="occupation" value="estudante_graduacao" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold border-gray-300">
                                        </div>
                                        <span class="ml-3 text-sm md:text-base group-hover:text-unirovuma-blue transition-colors">{{ __('form.options.occupation.ug_student') }}</span>
                                    </label>
                                    <label class="flex items-start cursor-pointer group">
                                        <div class="flex items-center h-5">
                                            <input type="radio" name="occupation" value="estudante_pos_graduacao" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold border-gray-300">
                                        </div>
                                        <span class="ml-3 text-sm md:text-base group-hover:text-unirovuma-blue transition-colors">{{ __('form.options.occupation.pg_student') }}</span>
                                    </label>
                                    <label class="flex items-start cursor-pointer group">
                                        <div class="flex items-center h-5">
                                            <input type="radio" name="occupation" value="docente" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold border-gray-300">
                                        </div>
                                        <span class="ml-3 text-sm md:text-base group-hover:text-unirovuma-blue transition-colors">{{ __('form.options.occupation.lecturer') }}</span>
                                    </label>
                                    <label class="flex items-start cursor-pointer group">
                                        <div class="flex items-center h-5">
                                            <input type="radio" name="occupation" value="investigador" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold border-gray-300">
                                        </div>
                                        <span class="ml-3 text-sm md:text-base group-hover:text-unirovuma-blue transition-colors">{{ __('form.options.occupation.researcher') }}</span>
                                    </label>
                                    </label>
                                    <label class="flex items-start cursor-pointer group">
                                        <div class="flex items-center h-5">
                                            <input type="radio" name="occupation" value="investigador" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold border-gray-300">
                                        </div>
                                        <span class="ml-3 text-sm md:text-base group-hover:text-unirovuma-blue transition-colors">{{ __('form.options.occupation.outher') }}</span>
                                    </label>
                                </div>
                            </fieldset>
                        </div>

                        <!-- Instituição e País -->
                        <div>
                            <label for="instituicao" class="block font-poppins font-semibold text-unirovuma-blue-dark mb-2 text-sm md:text-base">{{ __('form.labels.institution') }} <span class="text-red-500">*</span></label>
                            <input type="text" id="instituicao" name="institution_country" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-unirovuma-gold transition-all" required>
                        </div>
                        
                        <!-- Tipo de Participante -->
                        <fieldset class="bg-gray-50 p-4 rounded-lg">
                            <legend class="font-poppins font-semibold text-unirovuma-blue-dark mb-3 text-sm md:text-base">{{ __('form.labels.participant_type') }} <span class="text-red-500">*</span></legend>
                            <div class="flex flex-col sm:flex-row gap-4 sm:gap-8">
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="tipo_participante" value="orador" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold border-gray-300"> 
                                    <span class="ml-2 text-sm md:text-base group-hover:text-unirovuma-blue font-semibold transition-colors">{{ __('form.options.participant_type.speaker') }}</span>
                                </label>
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="tipo_participante" value="ouvinte" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold border-gray-300"> 
                                    <span class="ml-2 text-sm md:text-base group-hover:text-unirovuma-blue font-semibold transition-colors">{{ __('form.options.participant_type.attendee') }}</span>
                                </label>
                            </div>
                        </fieldset>

                        <!-- Campos Condicionais para Orador -->
                        <div id="campos-orador" class="hidden space-y-6 md:space-y-8 border-t-2 border-dashed border-gray-200 pt-8 animate-fade-in-down">
                            
                            <fieldset>
                                <legend class="block font-poppins font-semibold text-unirovuma-blue-dark mb-3 text-sm md:text-base">{{ __('form.labels.presentation_modality') }}</legend>
                                <div class="grid sm:grid-cols-3 gap-3">
                                    <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                        <input type="radio" name="presentation_modality" value="mesa_redonda" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold"> 
                                        <span class="ml-2 text-sm">{{ __('form.options.modality.round_table') }}</span>
                                    </label>
                                    <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                        <input type="radio" name="presentation_modality" value="comunicacao_oral" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold"> 
                                        <span class="ml-2 text-sm">{{ __('form.options.modality.oral_communication') }}</span>
                                    </label>
                                    <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                        <input type="radio" name="presentation_modality" value="poster" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold"> 
                                        <span class="ml-2 text-sm">{{ __('form.options.modality.poster') }}</span>
                                    </label>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend class="block font-poppins font-semibold text-unirovuma-blue-dark mb-3 text-sm md:text-base">{{ __('form.labels.thematic_axis') }}</legend>
                                <div class="grid md:grid-cols-2 gap-3">
                                    <label class="flex items-start p-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <div class="mt-1"><input type="radio" name="thematic_axis" value="1" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold"></div>
                                        <span class="ml-2 text-sm text-gray-700">{{ __('welcome.themes.area1') }}</span>
                                    </label>
                                    <label class="flex items-start p-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <div class="mt-1"><input type="radio" name="thematic_axis" value="2" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold"></div>
                                        <span class="ml-2 text-sm text-gray-700">{{ __('welcome.themes.area2') }}</span>
                                    </label>
                                    <label class="flex items-start p-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <div class="mt-1"><input type="radio" name="thematic_axis" value="3" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold"></div>
                                        <span class="ml-2 text-sm text-gray-700">{{ __('welcome.themes.area3') }}</span>
                                    </label>
                                    <label class="flex items-start p-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <div class="mt-1"><input type="radio" name="thematic_axis" value="4" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold"></div>
                                        <span class="ml-2 text-sm text-gray-700">{{ __('welcome.themes.area4') }}</span>
                                    </label>
                                    <label class="flex items-start p-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <div class="mt-1"><input type="radio" name="thematic_axis" value="5" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold"></div>
                                        <span class="ml-2 text-sm text-gray-700">{{ __('welcome.themes.area5') }}</span>
                                    </label>
                                    <label class="flex items-start p-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <div class="mt-1"><input type="radio" name="thematic_axis" value="6" class="h-4 w-4 text-unirovuma-blue focus:ring-unirovuma-gold"></div>
                                        <span class="ml-2 text-sm text-gray-700">{{ __('welcome.themes.area6') }}</span>
                                    </label>
                                </div>
                            </fieldset>

                            <div>
                                <label for="resumo" class="block font-poppins font-semibold text-unirovuma-blue-dark mb-2 text-sm md:text-base">{{ __('form.labels.abstract') }}</label>
                                <textarea id="resumo" name="abstract_content" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-unirovuma-gold transition-all"></textarea>
                            </div>

                            <div>
                                <label for="palavras_chave" class="block font-poppins font-semibold text-unirovuma-blue-dark mb-2 text-sm md:text-base">{{ __('form.labels.keywords') }}</label>
                                <input type="text" id="palavras_chave" name="keywords" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-unirovuma-gold transition-all">
                            </div>

                            <div>
                                <label class="block font-poppins font-semibold text-unirovuma-blue-dark mb-2 text-sm md:text-base">{{ __('form.labels.abstract_submission') }}</label>
                                <label for="resumo_file" class="group flex flex-col items-center justify-center w-full px-4 py-8 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-unirovuma-gold hover:bg-blue-50/30 transition-all duration-300">
                                    <div class="text-center">
                                        <svg class="w-10 h-10 mx-auto text-gray-400 group-hover:text-unirovuma-gold mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="text-gray-600 font-semibold group-hover:text-unirovuma-blue">{{ __('form.file_upload.cta') }}</p>
                                        <p class="text-xs text-gray-400 mt-2">{{ __('form.file_upload.info') }}</p>
                                        <span id="filename" class="text-sm font-bold text-unirovuma-blue-dark mt-3 block break-all"></span>
                                    </div>
                                    <input type="file" id="resumo_file" name="resumo_file" class="hidden">
                                </label>
                            </div>
                        </div>

                        <div class="text-center pt-8">
                            <button type="submit" class="w-full md:w-auto bg-unirovuma-gold text-unirovuma-blue-dark font-poppins font-bold text-lg py-4 px-12 rounded-full shadow-lg hover:bg-unirovuma-gold-dark transform hover:scale-105 transition-all duration-300">
                                {{ __('form.buttons.submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-unirovuma-blue-dark text-white py-8 mt-auto">
       <div class="container mx-auto px-6 text-center">
            <p class="text-gray-400 text-sm md:text-base">{{ __('welcome.footer.copyright') }}</p>
       </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lógica de mostrar/ocultar campos
            const tipoParticipanteRadios = document.querySelectorAll('input[name="tipo_participante"]');
            const camposOrador = document.getElementById('campos-orador');
            
            // Função para verificar estado inicial (caso o browser lembre a seleção no refresh)
            function checkSpeakerFields() {
                const selected = document.querySelector('input[name="tipo_participante"]:checked');
                if (selected && selected.value === 'orador') {
                    camposOrador.classList.remove('hidden');
                } else {
                    camposOrador.classList.add('hidden');
                }
            }
            
            // Verifica no carregamento
            checkSpeakerFields();

            // Adiciona listeners
            tipoParticipanteRadios.forEach(radio => {
                radio.addEventListener('change', checkSpeakerFields);
            });

            // Lógica do Upload de Arquivo
            const fileInput = document.getElementById('resumo_file');
            const filenameDisplay = document.getElementById('filename');
            // Fallback caso a string de tradução não seja carregada pelo blade
            const fileSelectedPrefix = "{{ __('form.file_upload.selected_prefix') ?? 'Arquivo selecionado:' }}";
            
            if(fileInput) {
                fileInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        filenameDisplay.textContent = fileSelectedPrefix + ' ' + this.files[0].name;
                        filenameDisplay.classList.add('p-2', 'bg-blue-100', 'rounded', 'inline-block');
                    } else {
                        filenameDisplay.textContent = '';
                        filenameDisplay.classList.remove('p-2', 'bg-blue-100', 'rounded', 'inline-block');
                    }
                });
            }
        });
    </script>
</body>
</html>