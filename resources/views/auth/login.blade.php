<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Selamat Datang</h2>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">Silakan masuk menggunakan akun kasir atau admin Anda.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Email Pengguna <span class="text-red-500">*</span></label>
            <input id="email" class="block w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl text-base sm:text-sm focus:ring-2 focus:ring-sky-500 focus:outline-none" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@laundry.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-600" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Kata Sandi <span class="text-red-500">*</span></label>
            <input id="password" class="block w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl text-base sm:text-sm focus:ring-2 focus:ring-sky-500 focus:outline-none"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-600" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-xs pt-1">
            <label for="remember_me" class="inline-flex items-center text-slate-600 cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-sky-600 shadow-sm focus:ring-sky-500" name="remember">
                <span class="ms-2 font-medium">Ingat Saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sky-600 hover:text-sky-700 font-semibold transition" href="{{ route('password.request') }}">
                    Lupa sandi?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-sky-600 hover:bg-sky-500 text-white py-3 sm:py-3.5 rounded-xl font-bold text-sm shadow-lg shadow-sky-600/20 transition duration-200">
                Masuk ke Sistem
            </button>
        </div>
    </form>
</x-guest-layout>

