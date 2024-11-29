<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-100 to-purple-200 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white shadow-2xl rounded-2xl p-8">
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div class="text-center">
            </div>

            <div>
                <label for="email" class="block text-gray-700 mb-2">
                    <i class="fas fa-envelope mr-2 text-blue-500"></i>E-mail
                </label>
                <div class="relative">
                    <input id="email" type="email" name="email" required 
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Digite seu e-mail">
                    <i class="fas fa-user absolute left-3 top-4 text-gray-400"></i>
                </div>
            </div>

            <div>
                <label for="password" class="block text-gray-700 mb-2">
                    <i class="fas fa-lock mr-2 text-blue-500"></i>Senha
                </label>
                <div class="relative">
                    <input id="password" type="password" name="password" required 
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Digite sua senha">
                    <i class="fas fa-eye-slash absolute right-3 top-4 text-gray-400 cursor-pointer"></i>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" type="checkbox" name="remember" 
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-gray-900">
                        Lembrar de mim
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <div>
                        <a href="{{ route('password.request') }}" 
                            class="text-blue-600 hover:text-blue-800 text-sm">
                            Esqueceu sua senha?
                        </a>
                    </div>
                @endif
            </div>

            <div>
                <button type="submit" 
                    style="width: 100%; background-color: #2496be; color: white; padding: 8px; border-radius: 8px; transition: opacity 0.3s;" 
                    onmouseover="this.style.opacity='0.9'" 
                    onmouseout="this.style.opacity='1'">
                    <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>Acessar
                </button>


            </div>

            <div class="relative my-4">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Ou continue com</span>
                </div>
            </div>

            <!-- Botão para Google -->
            <div class="flex space-x-4">
                <a href="{{ route('google.login') }}" 
                    class="w-full flex items-center justify-center bg-white text-gray-800 border border-gray-300 py-3 rounded-lg hover:bg-gray-100 shadow">
                    <img src="{{ asset('img/google.png') }}" alt="Google Logo" class="h-10 w-10 mr-2">

                    <span class="font-medium">Entrar com Google</span>
                </a>
            </div>

        </form>
    </div>

    <script>
        document.querySelector('.fa-eye-slash').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>