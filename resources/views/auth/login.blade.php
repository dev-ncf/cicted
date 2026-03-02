<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Painel de Controlo CICTED</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: { 'unirovuma-blue': '#0A2D57', 'unirovuma-gold': '#F2B900' }}}}
    </script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-2xl rounded-xl p-8 md:p-12">
            <div class="text-center mb-8">
                <img src="{{ asset('img/logo.jpg') }}" alt="Logotipo UniRovuma" class="h-16 mx-auto rounded-full">
                <h1 class="text-2xl font-bold text-unirovuma-blue mt-4">Acesso ao Painel</h1>
            </div>

            <!-- Exibir erros de validação -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ $errors->first('email') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-unirovuma-gold focus:border-unirovuma-gold sm:text-sm">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-unirovuma-gold focus:border-unirovuma-gold sm:text-sm">
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-unirovuma-blue hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-unirovuma-blue">
                        Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>