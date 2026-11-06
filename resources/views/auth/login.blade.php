<x-guest-layout>
    <div class="bg-slate-900/90 backdrop-blur-2xl border border-slate-800/90 rounded-3xl p-6 sm:p-8 shadow-2xl shadow-sky-950/40 relative overflow-hidden">
        
        <!-- Ambient subtle top glow border -->
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-sky-500 via-blue-500 to-indigo-500"></div>

        <!-- Header Card -->
        <div class="mb-6 text-center">
            <div class="inline-flex items-center gap-2 bg-sky-500/10 text-sky-400 border border-sky-500/20 px-3.5 py-1 rounded-full text-[11px] font-black uppercase tracking-wider mb-3">
                <i data-lucide="shield-check" class="w-3.5 h-3.5 text-sky-400"></i>
                <span>Portal Otentikasi Staf</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Masuk ke Sistem</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1.5">Gunakan akun admin atau kasir untuk mengelola transaksi & operasional.</p>
        </div>

        <!-- Quick Demo Credential Helper Pills -->
        <div class="mb-6 p-3 bg-slate-950/60 border border-slate-800 rounded-2xl">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1">
                    <i data-lucide="sparkles" class="w-3 h-3 text-amber-400"></i>
                    Akses Cepat Pengujian:
                </span>
                <span class="text-[10px] text-slate-500 font-mono">Klik untuk isi otomatis</span>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <button type="button" 
                        onclick="fillCredentials('admin1@gmail.com', '12345678')" 
                        class="flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-purple-500/10 hover:bg-purple-500/20 border border-purple-500/30 text-purple-300 hover:text-purple-200 text-xs font-bold transition duration-200 cursor-pointer group">
                    <i data-lucide="user-check" class="w-3.5 h-3.5 text-purple-400 group-hover:scale-110 transition"></i>
                    <span>Admin Demo</span>
                </button>
                <button type="button" 
                        onclick="fillCredentials('kasir1@gmail.com', '12345678')" 
                        class="flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-sky-500/10 hover:bg-sky-500/20 border border-sky-500/30 text-sky-300 hover:text-sky-200 text-xs font-bold transition duration-200 cursor-pointer group">
                    <i data-lucide="credit-card" class="w-3.5 h-3.5 text-sky-400 group-hover:scale-110 transition"></i>
                    <span>Kasir Demo</span>
                </button>
            </div>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-5" :status="session('status')" />

        @if ($errors->any())
            <div class="mb-5 bg-red-500/10 border border-red-500/30 text-red-300 p-3.5 rounded-2xl text-xs flex items-start gap-2.5">
                <i data-lucide="alert-circle" class="w-4 h-4 text-red-400 shrink-0 mt-0.5"></i>
                <div class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-1.5">
                    Alamat Email <span class="text-rose-400">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                    </span>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           autocomplete="username" 
                           placeholder="nama@laundry.com" 
                           class="w-full bg-slate-950/70 border border-slate-700/80 rounded-xl pl-10 pr-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-200 font-medium" />
                </div>
            </div>

            <!-- Password with Show/Hide toggle -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300">
                        Kata Sandi <span class="text-rose-400">*</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-sky-400 hover:text-sky-300 transition font-medium">
                            Lupa sandi?
                        </a>
                    @endif
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-500">
                        <i data-lucide="lock" class="w-4 h-4"></i>
                    </span>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password" 
                           placeholder="••••••••" 
                           class="w-full bg-slate-950/70 border border-slate-700/80 rounded-xl pl-10 pr-11 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-200 font-medium" />
                    <button type="button" 
                            id="togglePasswordBtn" 
                            tabindex="-1"
                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-500 hover:text-slate-300 focus:outline-none transition cursor-pointer"
                            aria-label="Lihat kata sandi">
                        <i data-lucide="eye" id="togglePasswordIcon" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between pt-1">
                <label for="remember_me" class="inline-flex items-center text-xs text-slate-300 cursor-pointer select-none">
                    <input id="remember_me" 
                           type="checkbox" 
                           name="remember" 
                           class="w-4 h-4 rounded border-slate-700 bg-slate-950 text-sky-600 focus:ring-sky-500 focus:ring-offset-slate-900 cursor-pointer">
                    <span class="ms-2 font-medium">Ingat akun di perangkat ini</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" 
                        id="submitLoginBtn" 
                        class="w-full bg-gradient-to-r from-sky-500 via-sky-600 to-blue-600 hover:from-sky-400 hover:to-blue-500 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-sky-600/25 hover:shadow-sky-600/40 transition duration-300 flex items-center justify-center gap-2 text-sm cursor-pointer group">
                    <i data-lucide="log-in" id="loginBtnIcon" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform"></i>
                    <span id="loginBtnText">Masuk ke Panel Kerja</span>
                </button>
            </div>
        </form>

        <div class="mt-6 pt-5 border-t border-slate-800 text-center">
            <span class="text-xs text-slate-400">Butuh bantuan akun staf? Hubungi Super Admin / Owner outlet.</span>
        </div>
    </div>

    <script>
        // Autofill Demo Helper
        function fillCredentials(email, password) {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            if (emailInput && passwordInput) {
                emailInput.value = email;
                passwordInput.value = password;
                
                // Visual feedback highlight
                emailInput.classList.add('ring-2', 'ring-sky-400');
                passwordInput.classList.add('ring-2', 'ring-sky-400');
                setTimeout(() => {
                    emailInput.classList.remove('ring-2', 'ring-sky-400');
                    passwordInput.classList.remove('ring-2', 'ring-sky-400');
                }, 800);
            }
        }

        // Toggle Password Visibility
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        toggleBtn?.addEventListener('click', function() {
            if (!passwordInput) return;
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';

            if (toggleIcon) {
                toggleIcon.setAttribute('data-lucide', isPassword ? 'eye-off' : 'eye');
                if (window.lucide) {
                    window.lucide.createIcons();
                }
            }
        });

        // Form Submit Loading State
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitLoginBtn');
        const btnText = document.getElementById('loginBtnText');
        const btnIcon = document.getElementById('loginBtnIcon');

        loginForm?.addEventListener('submit', function() {
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
            }
            if (btnText) {
                btnText.textContent = 'Memverifikasi...';
            }
            if (btnIcon) {
                btnIcon.outerHTML = '<svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>';
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
</x-guest-layout>
