<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('welcome.hero.title') }} - UniRovuma</title>

 
    <script src="https://cdn.tailwindcss.com"></script>

  
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('img/logotipo-unirovuma.fw.png') }}" type="image/x-icon">
    
 
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
                    },
                    
                }
            }
        }
    </script>
    <style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
</style>
</head>
<body class="bg-white font-lato text-gray-800 antialiased flex flex-col min-h-screen">

    <header id="header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <nav class="container mx-auto px-4 md:px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('img/logotipo-unirovuma.fw.png') }}" alt="Logotipo UniRovuma" class="h-10 md:h-14 rounded-full">
                    <div class="flex flex-col leading-tight">
                        <p class="text-unirovuma-gold font-bold text-sm md:text-base">UNIVERSIDADE </p>
                        <p class="text-white text-[10px] md:text-lg">ROVUMA</p>
                    </div>
                </div>

                <div class="hidden lg:flex items-center space-x-8 text-white font-semibold">
                    <a href="#objetivos" class="hover:text-unirovuma-gold transition-colors">{{ __('welcome.nav.modalities') }}</a>
                    <a href="#temas" class="hover:text-unirovuma-gold transition-colors">{{ __('welcome.nav.program') }}</a>
                    <a href="#temas" class="hover:text-unirovuma-gold transition-colors">{{ __('welcome.nav.program') }}</a>
                    <a href="{{ route('registration.form') }}" class="hover:text-unirovuma-gold transition-colors">{{ __('welcome.nav.enrollment') }}</a>
                    <a href="#datas" class="hover:text-unirovuma-gold transition-colors">{{ __('welcome.nav.abstract_books') }}</a>
                    <a href="#datas" class="hover:text-unirovuma-gold transition-colors">{{ __('welcome.nav.ebooks') }}</a>
                    <a href="{{ route('login') }}" class="hover:text-unirovuma-gold transition-colors">{{ __('welcome.nav.login') }}</a>
                </div>

                
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2 text-white font-bold text-sm md:text-base">
                        <a href="/pt" class="{{ app()->getLocale() == 'pt' ? 'text-unirovuma-gold' : 'hover:text-unirovuma-gold transition-colors' }}">PT</a>
                        <span class="text-gray-400">|</span>
                        <a href="/en" class="{{ app()->getLocale() == 'en' ? 'text-unirovuma-gold' : 'hover:text-unirovuma-gold transition-colors' }}">EN</a>
                        <span class="text-gray-400">|</span>
                        <a href="/fr" class="{{ app()->getLocale() == 'fr' ? 'text-unirovuma-gold' : 'hover:text-unirovuma-gold transition-colors' }}">FR</a>
                    </div>

                    <button id="mobile-menu-btn" class="lg:hidden text-white focus:outline-none">
                       <img src="{{ asset('img/icons/hamburger.png') }}" alt="" style="width: 24px" >
                    </button>
                </div>
            </div>

           
            <div id="mobile-menu" class="hidden lg:hidden mt-4 bg-unirovuma-blue-dark rounded-lg p-4 absolute left-4 right-4 shadow-xl border-t border-gray-700">
                <div class="flex flex-col space-y-4 text-white font-semibold text-center">
                    <a href="#objetivos" class="mobile-link hover:text-unirovuma-gold">{{ __('welcome.nav.objectives') }}</a>
                    <a href="#temas" class="mobile-link hover:text-unirovuma-gold">{{ __('welcome.nav.themes') }}</a>
                    <a href="#datas" class="mobile-link hover:text-unirovuma-gold">{{ __('welcome.nav.dates') }}</a>
                    <a href="{{ route('login') }}" class="mobile-link bg-unirovuma-gold text-unirovuma-blue-dark py-2 rounded-md">{{ __('welcome.nav.login') }}</a>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-grow">
<section id="hero-carousel" class="relative h-screen min-h-[600px] overflow-hidden group">
    
    <div id="carousel-slides" class="relative h-full w-full">
        <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 z-0" data-slide="1">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('img/campus_napipine.jpg') }}');"></div>
            <div class="absolute inset-0 bg-unirovuma-blue-dark/50"></div>
            
            <div class="relative h-full flex items-center justify-center text-center text-white px-6">
                <div class="max-w-4xl mx-auto mt-16 md:mt-0">
                    <span class="font-semibold text-unirovuma-gold tracking-widest uppercase text-sm md:text-base"> {{ __('welcome.submit.submissao') }}</span>
                    <h1 class="font-poppins text-3xl md:text-5xl font-extrabold tracking-tight uppercase mt-4 mb-6 leading-tight">
                        {{ __('welcome.submit.partilhe') }}
                    </h1>
                    <p class="text-lg md:text-xl font-light text-gray-200 mb-10 max-w-3xl mx-auto">
                        {{ __('welcome.submit.paragrafo') }}
                    </p>
                    <div class="flex flex-col md:flex-row gap-4 justify-center">
                        <a href="{{ asset('docs/TdR Resumido_Congresso UniRovuma_página web_30.10.2025.pdf') }}" target="_blank" class="bg-white text-unirovuma-blue font-poppins font-bold text-lg px-8 py-3 rounded-full shadow-lg hover:bg-unirovuma-gold hover:text-unirovuma-blue-dark hover:scale-105 transition-all duration-300">
                            {{ __('welcome.submit.termo') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-100 z-10" data-slide="0">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('img/reitoria.jpg') }}');"></div>
            
            <div class="absolute inset-0 bg-unirovuma-blue/60"></div>
          
            <div class="relative h-full flex items-center justify-center text-center text-white px-6">
                <div class="max-w-4xl mx-auto mt-16 md:mt-0">
                    <span class="font-semibold text-unirovuma-gold tracking-widest uppercase text-sm md:text-base animate-fade-in-up">{{ __('welcome.hero.location_date') }}</span>
                    <h1 class="font-poppins text-3xl md:text-6xl font-extrabold tracking-tight uppercase mt-4 mb-6 leading-tight animate-fade-in-up delay-100">
                        {{ __('welcome.hero.title') }}
                    </h1>
                    <p class="text-lg md:text-2xl font-light italic text-gray-200 mb-10 max-w-2xl mx-auto animate-fade-in-up delay-200">
                        {{ __('welcome.hero.subtitle') }}
                    </p>
                    <div class="flex flex-col md:flex-row gap-4 justify-center animate-fade-in-up delay-300">
                        <a href="{{ route('registration.form') }}" class="bg-unirovuma-gold text-unirovuma-blue-dark font-poppins font-bold text-lg px-8 py-3 rounded-full shadow-lg hover:bg-white hover:scale-105 transition-all duration-300">
                            {{ __('welcome.hero.cta_button') }}
                        </a>
                         <a href="#datas" class="border-2 border-white text-white font-poppins font-bold text-lg px-8 py-3 rounded-full hover:bg-white hover:text-unirovuma-blue transition-all duration-300">
                            {{ __('welcome.nav.dates') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        
        

        <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-0 z-0" data-slide="2">
            
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('img/Centro Cultural da Universidade Rovuma(1).jpg') }}');"></div>
            <div class="absolute inset-0 bg-black/50"></div>
            
            <div class="relative h-full flex items-center justify-center text-center text-white px-6">
                <div class="max-w-4xl mx-auto mt-16 md:mt-0">
                    <span class="font-semibold text-unirovuma-gold tracking-widest uppercase text-sm md:text-base">{{ __('welcome.centro.title') }}</span>
                    <h1 class="font-poppins text-3xl md:text-5xl font-extrabold tracking-tight uppercase mt-4 mb-6 leading-tight">
                        {{ __('welcome.centro.subtitle') }}
                    </h1>
                    <p class="text-lg md:text-xl font-light text-gray-200 mb-10 max-w-3xl mx-auto">
                        {{ __('welcome.centro.paragrafo') }}
                    </p>
                </div>
            </div>
        </div>
        

    </div>

    <button id="prevBtn" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/10 hover:bg-unirovuma-gold text-white hover:text-unirovuma-blue-dark p-3 rounded-full backdrop-blur-sm transition-all z-20 hidden md:block focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>
    <button id="nextBtn" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/10 hover:bg-unirovuma-gold text-white hover:text-unirovuma-blue-dark p-3 rounded-full backdrop-blur-sm transition-all z-20 hidden md:block focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <div class="absolute bottom-8 left-0 right-0 flex justify-center space-x-3 z-20">
        <button class="indicator w-3 h-3 rounded-full bg-white transition-all duration-300 focus:outline-none" data-index="0"></button>
        <button class="indicator w-3 h-3 rounded-full bg-white/40 hover:bg-white transition-all duration-300 focus:outline-none" data-index="1"></button>
        <button class="indicator w-3 h-3 rounded-full bg-white/40 hover:bg-white transition-all duration-300 focus:outline-none" data-index="2"></button>
    </div>
</section>

        <section id="objetivos" class="py-16 md:py-24 bg-white">
            <div class="container mx-auto px-4 md:px-6">
                <h2 class="font-poppins text-2xl md:text-4xl font-bold text-unirovuma-blue mb-10 md:mb-16 text-center">{{ __('welcome.objectives.title') }}</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 max-w-7xl mx-auto">
                   
                    <div class="bg-gray-50 p-6 rounded-xl border-t-4 border-unirovuma-gold shadow-sm hover:shadow-md transition-shadow">
                        <h3 class="font-poppins font-bold text-lg text-unirovuma-blue-dark mb-3">{{ __('welcome.objectives.item1_title') }}</h3>
                        <p class="text-sm md:text-base text-gray-600 leading-relaxed">{{ __('welcome.objectives.item1_desc') }}</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-xl border-t-4 border-unirovuma-gold shadow-sm hover:shadow-md transition-shadow">
                        <h3 class="font-poppins font-bold text-lg text-unirovuma-blue-dark mb-3">{{ __('welcome.objectives.item2_title') }}</h3>
                        <p class="text-sm md:text-base text-gray-600 leading-relaxed">{{ __('welcome.objectives.item2_desc') }}</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-xl border-t-4 border-unirovuma-gold shadow-sm hover:shadow-md transition-shadow">
                        <h3 class="font-poppins font-bold text-lg text-unirovuma-blue-dark mb-3">{{ __('welcome.objectives.item3_title') }}</h3>
                        <p class="text-sm md:text-base text-gray-600 leading-relaxed">{{ __('welcome.objectives.item3_desc') }}</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-xl border-t-4 border-unirovuma-gold shadow-sm hover:shadow-md transition-shadow">
                        <h3 class="font-poppins font-bold text-lg text-unirovuma-blue-dark mb-3">{{ __('welcome.objectives.item4_title') }}</h3>
                        <p class="text-sm md:text-base text-gray-600 leading-relaxed">{{ __('welcome.objectives.item4_desc') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="temas" class="py-16 md:py-24 bg-gray-50">
            <div class="container mx-auto px-4 md:px-6">
                <h2 class="font-poppins text-2xl md:text-4xl font-bold text-unirovuma-blue mb-10 md:mb-16 text-center">{{ __('welcome.themes.title') }}</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 border-unirovuma-blue"><h3 class="font-poppins font-bold text-lg text-gray-800">{{ __('welcome.themes.area1') }}</h3></div>
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 border-unirovuma-blue"><h3 class="font-poppins font-bold text-lg text-gray-800">{{ __('welcome.themes.area2') }}</h3></div>
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 border-unirovuma-blue"><h3 class="font-poppins font-bold text-lg text-gray-800">{{ __('welcome.themes.area3') }}</h3></div>
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 border-unirovuma-blue"><h3 class="font-poppins font-bold text-lg text-gray-800">{{ __('welcome.themes.area4') }}</h3></div>
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 border-unirovuma-blue"><h3 class="font-poppins font-bold text-lg text-gray-800">{{ __('welcome.themes.area5') }}</h3></div>
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow border-l-4 border-unirovuma-blue"><h3 class="font-poppins font-bold text-lg text-gray-800">{{ __('welcome.themes.area6') }}</h3></div>
                </div>
            </div>
        </section>
        
        <section id="datas" class="py-16 md:py-24 bg-white">
            <div class="container mx-auto px-4 md:px-6 max-w-4xl">
                <h2 class="font-poppins text-2xl md:text-4xl font-bold text-unirovuma-blue mb-12 text-center">{{ __('welcome.dates.title') }}</h2>
                <div class="relative border-l-2 border-gray-200 ml-4 md:ml-6 space-y-10">
                    
                    <div class="pl-8 relative group">
                        <div class="absolute -left-[9px] top-1 w-5 h-5 bg-unirovuma-gold rounded-full border-4 border-white shadow-sm group-hover:scale-125 transition-transform"></div>
                        <p class="font-poppins font-bold text-unirovuma-blue-dark text-lg md:text-xl">15/11/2025</p>
                        <p class="text-gray-600 mt-1">{{ __('welcome.dates.date1') }}</p>
                    </div>

                    <div class="pl-8 relative group">
                        <div class="absolute -left-[9px] top-1 w-5 h-5 bg-unirovuma-gold rounded-full border-4 border-white shadow-sm group-hover:scale-125 transition-transform"></div>
                        <p class="font-poppins font-bold text-unirovuma-blue-dark text-lg md:text-xl">31/01/2026</p>
                        <p class="text-gray-600 mt-1">{{ __('welcome.dates.date2') }}</p>
                    </div>

                    <div class="pl-8 relative group">
                        <div class="absolute -left-[9px] top-1 w-5 h-5 bg-unirovuma-gold rounded-full border-4 border-white shadow-sm group-hover:scale-125 transition-transform"></div>
                        <p class="font-poppins font-bold text-unirovuma-blue-dark text-lg md:text-xl">28/02/2026</p>
                        <p class="text-gray-600 mt-1">{{ __('welcome.dates.date3') }}</p>
                    </div>

                    <div class="pl-8 relative group">
                        <div class="absolute -left-[9px] top-1 w-5 h-5 bg-unirovuma-gold rounded-full border-4 border-white shadow-sm group-hover:scale-125 transition-transform"></div>
                        <p class="font-poppins font-bold text-unirovuma-blue-dark text-lg md:text-xl">30/03/2026 - 30/05/2026</p>
                        <p class="text-gray-600 mt-1">{{ __('welcome.dates.date4') }}</p>
                    </div>

                    <div class="pl-8 relative group">
                        <div class="absolute -left-[9px] top-1 w-5 h-5 bg-unirovuma-gold rounded-full border-4 border-white shadow-sm group-hover:scale-125 transition-transform"></div>
                        <p class="font-poppins font-bold text-unirovuma-blue-dark text-lg md:text-xl">16 e 17/09/2026</p>
                        <p class="text-gray-600 mt-1">{{ __('welcome.dates.date5') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="inscricao" class="py-16 md:py-24 bg-gray-50">
            <div class="container mx-auto px-4 md:px-6">
                <h2 class="font-poppins text-2xl md:text-4xl font-bold text-unirovuma-blue mb-4 text-center">{{ __('welcome.registration.title') }}</h2>
                <p class="text-base md:text-lg text-gray-600 mb-10 text-center max-w-3xl mx-auto">{{ __('welcome.registration.description') }}</p>
                
                <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left min-w-[500px]">
                            <thead class="bg-unirovuma-blue text-white font-poppins">
                                <tr>
                                    <th class="p-4 md:p-5 text-sm md:text-base">{{ __('welcome.registration.table_header_type') }}</th>
                                    <th class="p-4 md:p-5 text-right text-sm md:text-base">{{ __('welcome.registration.table_header_fee') }} (MZN)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-4 md:p-5 text-sm md:text-base">{{ __('welcome.registration.fee_ug_student') }}</td>
                                    <td class="p-4 md:p-5 text-right font-bold text-unirovuma-blue text-sm md:text-base">200,00</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-4 md:p-5 text-sm md:text-base">{{ __('welcome.registration.fee_pg_student') }}</td>
                                    <td class="p-4 md:p-5 text-right font-bold text-unirovuma-blue text-sm md:text-base">500,00</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-4 md:p-5 text-sm md:text-base">{{ __('welcome.registration.fee_attendee') }}</td>
                                    <td class="p-4 md:p-5 text-right font-bold text-unirovuma-blue text-sm md:text-base">500,00</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-4 md:p-5 text-sm md:text-base">{{ __('welcome.registration.fee_researcher') }}</td>
                                    <td class="p-4 md:p-5 text-right font-bold text-unirovuma-blue text-sm md:text-base">1000,00</td>
                                </tr>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-4 md:p-5 text-sm md:text-base">{{ __('welcome.registration.fee_dinner') }}</td>
                                    <td class="p-4 md:p-5 text-right font-bold text-unirovuma-blue text-sm md:text-base">1000,00</td>
                                </tr>
                                 <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-4 md:p-5 text-sm md:text-base">{{ __('welcome.registration.fee_tour') }}</td>
                                    <td class="p-4 md:p-5 text-right font-bold text-unirovuma-blue text-sm md:text-base">1500,00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-center mt-12">
                     <a href="{{ route('registration.form') }}" class="inline-block bg-unirovuma-gold text-unirovuma-blue-dark font-poppins font-bold text-lg py-4 px-10 rounded-full shadow-lg hover:bg-unirovuma-gold-dark transform hover:scale-105 transition-all duration-300 w-full md:w-auto">
                        {{ __('welcome.registration.cta_button') }}
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-unirovuma-blue-dark text-white pt-16 pb-8 border-t border-gray-800">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid md:grid-cols-3 gap-10 mb-10 text-center md:text-left">
                <div class="flex flex-col items-center md:items-start">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logotipo UniRovuma" class="h-14 mb-4 rounded-full border-2 border-unirovuma-gold">
                    <p class="text-gray-400 text-sm leading-relaxed">{{ __('welcome.footer.description') }}</p>
                </div>
                <div>
                    <h4 class="font-poppins font-bold text-lg mb-4 text-unirovuma-gold">{{ __('welcome.footer.contact_title') }}</h4>
                    <ul class="space-y-3 text-gray-300 text-sm">
                        <li class="flex items-center justify-center md:justify-start gap-2">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                             cicted@unirovuma.ac.mz
                        </li>
                        <li class="flex items-center justify-center md:justify-start gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            +258 878022105 (MA. Jenete Azizi)
                        </li>
                        <li class="flex items-center justify-center md:justify-start gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            +258 844306559 (Prof. Doutor Manecas Azevedo)
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-poppins font-bold text-lg mb-4 text-unirovuma-gold">{{ __('welcome.footer.location_title') }}</h4>
                    <p class="text-gray-300 text-sm flex items-start justify-center md:justify-start gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ __('welcome.footer.location_address') }}
                    </p>
                </div>
            </div>
            <div class="border-t border-gray-700 text-center pt-6">
                <p class="text-gray-500 text-sm">{{ __('welcome.footer.copyright') }}</p>
            </div>
        </div>
    </footer>

    <script>
        const header = document.getElementById('header');
        window.onscroll = function() {
            if (window.pageYOffset > 20) {
                header.classList.add("bg-unirovuma-blue", "shadow-lg", "py-2");
            } else {
                header.classList.remove("bg-unirovuma-blue", "shadow-lg", "py-2");
            }
        };

        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const links = document.querySelectorAll('.mobile-link');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        links.forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.add('hidden');
            });
        });
    
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('[data-slide]');
        const indicators = document.querySelectorAll('.indicator');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentIndex = 0;
        let interval;
        const intervalTime = 6000; 

        function showSlide(index) {
            if (index >= slides.length) currentIndex = 0;
            else if (index < 0) currentIndex = slides.length - 1;
            else currentIndex = index;

            
            slides.forEach((slide, i) => {
                if (i === currentIndex) {
                    slide.classList.remove('opacity-0', 'z-0');
                    slide.classList.add('opacity-100', 'z-10');
                } else {
                    slide.classList.remove('opacity-100', 'z-10');
                    slide.classList.add('opacity-0', 'z-0');
                }
            });

            
            indicators.forEach((dot, i) => {
                if (i === currentIndex) {
                    dot.classList.remove('bg-white/40');
                    dot.classList.add('bg-unirovuma-gold', 'w-8'); 
                } else {
                    dot.classList.remove('bg-unirovuma-gold', 'w-8');
                    dot.classList.add('bg-white/40');
                }
            });
        }

        function nextSlide() {
            showSlide(currentIndex + 1);
        }

        function prevSlide() {
            showSlide(currentIndex - 1);
        }

        function startAutoPlay() {
            interval = setInterval(nextSlide, intervalTime);
        }

        function stopAutoPlay() {
            clearInterval(interval);
        }

        if(nextBtn) nextBtn.addEventListener('click', () => {
            stopAutoPlay();
            nextSlide();
            startAutoPlay();
        });

        if(prevBtn) prevBtn.addEventListener('click', () => {
            stopAutoPlay();
            prevSlide();
            startAutoPlay();
        });

        indicators.forEach(dot => {
            dot.addEventListener('click', (e) => {
                stopAutoPlay();
                const index = parseInt(e.target.getAttribute('data-index'));
                showSlide(index);
                startAutoPlay();
            });
        });

        showSlide(0);
        startAutoPlay();
    });
</script>


</body>
</html>