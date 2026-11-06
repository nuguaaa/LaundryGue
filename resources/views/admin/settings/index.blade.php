@extends('layouts.admin')

@section('header')
    <h2 class="font-bold text-xl sm:text-2xl text-slate-800 leading-tight">
        {{ __('Pengaturan Website & Tampilan') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">

        <!-- Notifikasi AJAX Toast / Alert -->
        <div id="settingsAlertBox" class="hidden bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3.5 rounded-2xl text-xs sm:text-sm font-semibold shadow-sm flex items-center justify-between animate-fade-in-up">
            <div class="flex items-center gap-2.5">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span id="settingsAlertMessage">Pengaturan berhasil disimpan!</span>
            </div>
            <button type="button" onclick="document.getElementById('settingsAlertBox').classList.add('hidden')" class="text-emerald-700 hover:text-emerald-900 font-bold ml-2 text-lg leading-none">&times;</button>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3.5 rounded-2xl text-xs sm:text-sm font-semibold shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 font-bold ml-2 text-lg leading-none">&times;</button>
            </div>
        @endif

        <!-- KARTU KHUSUS: PENGATURAN SPLASH SCREEN (FITUR TOGGLE BACKEND) -->
        <div class="bg-white shadow-sm rounded-2xl sm:rounded-3xl p-5 sm:p-7 border border-slate-200 relative overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100">
                <div class="flex items-start sm:items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold shrink-0 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h2 class="text-lg font-black text-slate-800 tracking-tight">Fitur Splash Screen (Layar Pemuat)</h2>
                            <span id="splashStatusBadge" class="text-[11px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider {{ ($settings['enable_splash_screen'] ?? '0') === '1' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                {{ ($settings['enable_splash_screen'] ?? '0') === '1' ? 'Status: Aktif' : 'Status: Nonaktif (Sesuai Permintaan)' }}
                            </span>
                        </div>
                        <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Kontrol apakah animasi splash screen ditampilkan di halaman utama yang dilihat pengunjung atau dimatikan sepenuhnya.</p>
                    </div>
                </div>

                <!-- Tombol Saklar AJAX Cepat -->
                <div class="flex items-center gap-3 shrink-0 self-end sm:self-center">
                    <button type="button" 
                            id="ajaxToggleSplashBtn"
                            onclick="toggleSplashScreenAjax()" 
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs transition duration-200 shadow-sm cursor-pointer {{ ($settings['enable_splash_screen'] ?? '0') === '1' ? 'bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200' : 'bg-emerald-600 hover:bg-emerald-500 text-white' }}">
                        <span id="toggleSplashBtnSpinner" class="hidden">
                            <svg class="animate-spin h-3.5 w-3.5 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                        </span>
                        <span id="toggleSplashBtnText">
                            {{ ($settings['enable_splash_screen'] ?? '0') === '1' ? 'Matikan Splash Screen' : 'Aktifkan Splash Screen' }}
                        </span>
                    </button>
                </div>
            </div>

            <div class="pt-4 text-xs text-slate-500 flex items-start gap-2 bg-slate-50 -mx-5 -mb-5 sm:-mx-7 sm:-mb-7 p-4 sm:p-5 border-t border-slate-100">
                <svg class="w-4 h-4 text-sky-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Ketika dimatikan (Status: Nonaktif), pengunjung yang membuka halaman utama tidak akan tertahan oleh splash screen dan halaman akan terbuka instan.</span>
            </div>
        </div>

        <!-- FORM UTAMA PENGATURAN INFORMASI WEBSITE -->
        <div class="bg-white shadow-sm rounded-2xl sm:rounded-3xl p-5 sm:p-8 border border-slate-200">
            <div class="mb-6 pb-5 border-b border-slate-100">
                <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Informasi Kontak & Outlet Landing Page</h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Kelola jam operasional, alamat outlet utama, dan nomor kontak WhatsApp yang tampil di landing page website.</p>
            </div>

            <form id="settingsForm" action="{{ route('admin.settings.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Checkbox Sinkronisasi Status Splash Screen -->
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/80 flex items-center justify-between">
                    <div>
                        <span class="block text-xs font-bold uppercase tracking-wider text-slate-700">Tampilkan Animasi Splash Screen</span>
                        <span class="text-[11px] text-slate-400">Centang jika ingin menyalakan splash screen pemuat, kosongkan untuk mematikan</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" 
                               name="enable_splash_screen" 
                               id="enable_splash_screen_checkbox" 
                               value="1" 
                               {{ ($settings['enable_splash_screen'] ?? '0') === '1' ? 'checked' : '' }} 
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-600"></div>
                    </label>
                </div>

                <!-- Jam Operasional -->
                <div>
                    <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Jam Operasional <span class="text-red-500">*</span></label>
                    <input type="text" name="operational_hours" value="{{ $settings['operational_hours'] ?? '' }}" placeholder="Contoh: Selasa - Minggu: 10.00 - 17.00 WIB" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none text-base sm:text-sm font-medium" required>
                    <p class="text-[11px] text-slate-400 mt-1">Jadwal buka outlet yang ditampilkan di informasi kontak dan footer website.</p>
                </div>

                <!-- Alamat Outlet -->
                <div>
                    <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Alamat Outlet Utama <span class="text-red-500">*</span></label>
                    <textarea name="address" rows="3" placeholder="Masukkan alamat lengkap outlet..." class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none text-base sm:text-sm font-medium" required>{{ $settings['address'] ?? '' }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Alamat fisik toko yang membantu pelanggan menemukan lokasi laundry.</p>
                </div>

                <!-- Nomor WhatsApp -->
                <div>
                    <label class="block text-slate-700 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1.5">Nomor WhatsApp Admin / CS <span class="text-red-500">*</span></label>
                    <input type="text" name="whatsapp" value="{{ $settings['whatsapp'] ?? '' }}" placeholder="6281220295876" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none font-mono text-base sm:text-sm font-bold text-slate-800" required>
                    <p class="text-[11px] text-slate-400 mt-1">Gunakan format internasional tanpa awalan + atau 0 (contoh: 6281220295876).</p>
                </div>

                <div class="pt-3">
                    <button type="submit" 
                            id="saveSettingsBtn"
                            class="w-full bg-sky-600 hover:bg-sky-500 text-white py-3.5 rounded-xl sm:rounded-2xl font-bold transition shadow-lg shadow-sky-600/20 text-sm flex items-center justify-center gap-2 cursor-pointer">
                        <span id="saveSettingsSpinner" class="hidden">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                        </span>
                        <span id="saveSettingsBtnText">Simpan Perubahan Pengaturan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const alertBox = document.getElementById('settingsAlertBox');
        const alertMsg = document.getElementById('settingsAlertMessage');
        const splashBadge = document.getElementById('splashStatusBadge');
        const splashBtn = document.getElementById('ajaxToggleSplashBtn');
        const splashBtnText = document.getElementById('toggleSplashBtnText');
        const splashBtnSpinner = document.getElementById('toggleSplashBtnSpinner');
        const splashCheckbox = document.getElementById('enable_splash_screen_checkbox');

        function showToast(message, isSuccess = true) {
            if (alertMsg) alertMsg.textContent = message;
            if (alertBox) {
                alertBox.className = `bg-${isSuccess ? 'emerald' : 'red'}-50 border border-${isSuccess ? 'emerald' : 'red'}-300 text-${isSuccess ? 'emerald' : 'red'}-800 px-4 py-3.5 rounded-2xl text-xs sm:text-sm font-semibold shadow-sm flex items-center justify-between animate-fade-in-up mb-4`;
                alertBox.classList.remove('hidden');
                setTimeout(() => {
                    alertBox.classList.add('hidden');
                }, 4000);
            }
        }

        // AJAX Toggle Splash Screen
        async function toggleSplashScreenAjax() {
            if (splashBtnSpinner) splashBtnSpinner.classList.remove('hidden');
            if (splashBtn) splashBtn.disabled = true;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const res = await fetch("{{ route('admin.settings.toggle-splash') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();
                if (res.ok && data.success) {
                    const isEnabled = data.enabled;
                    
                    // Update Badge
                    if (splashBadge) {
                        splashBadge.textContent = isEnabled ? 'Status: Aktif' : 'Status: Nonaktif (Sesuai Permintaan)';
                        splashBadge.className = `text-[11px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider ${isEnabled ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700'}`;
                    }

                    // Update Button Text & Style
                    if (splashBtnText) {
                        splashBtnText.textContent = isEnabled ? 'Matikan Splash Screen' : 'Aktifkan Splash Screen';
                    }
                    if (splashBtn) {
                        splashBtn.className = `inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs transition duration-200 shadow-sm cursor-pointer ${isEnabled ? 'bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200' : 'bg-emerald-600 hover:bg-emerald-500 text-white'}`;
                    }

                    // Sync Checkbox in form
                    if (splashCheckbox) {
                        splashCheckbox.checked = isEnabled;
                    }

                    showToast(data.message, true);
                } else {
                    showToast('Gagal mengubah pengaturan splash screen.', false);
                }
            } catch (err) {
                showToast('Terjadi kesalahan jaringan.', false);
            } finally {
                if (splashBtnSpinner) splashBtnSpinner.classList.add('hidden');
                if (splashBtn) splashBtn.disabled = false;
            }
        }

        // AJAX Form Save
        const settingsForm = document.getElementById('settingsForm');
        const saveBtn = document.getElementById('saveSettingsBtn');
        const saveSpinner = document.getElementById('saveSettingsSpinner');
        const saveText = document.getElementById('saveSettingsBtnText');

        settingsForm?.addEventListener('submit', async function(e) {
            e.preventDefault();
            if (saveSpinner) saveSpinner.classList.remove('hidden');
            if (saveText) saveText.textContent = 'Menyimpan Pengaturan...';
            if (saveBtn) saveBtn.disabled = true;

            try {
                const formData = new FormData(settingsForm);
                // Ensure checkbox value is passed properly
                if (!splashCheckbox?.checked) {
                    formData.delete('enable_splash_screen');
                }

                const res = await fetch(settingsForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json().catch(() => null);

                if (res.ok && data && data.success) {
                    showToast(data.message, true);
                    // Sync badge if splash checkbox was toggled
                    const isSplashChecked = splashCheckbox?.checked;
                    if (splashBadge) {
                        splashBadge.textContent = isSplashChecked ? 'Status: Aktif' : 'Status: Nonaktif (Sesuai Permintaan)';
                        splashBadge.className = `text-[11px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider ${isSplashChecked ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700'}`;
                    }
                    if (splashBtnText) {
                        splashBtnText.textContent = isSplashChecked ? 'Matikan Splash Screen' : 'Aktifkan Splash Screen';
                    }
                } else {
                    settingsForm.submit();
                }
            } catch (err) {
                settingsForm.submit();
            } finally {
                if (saveSpinner) saveSpinner.classList.add('hidden');
                if (saveText) saveText.textContent = 'Simpan Perubahan Pengaturan';
                if (saveBtn) saveBtn.disabled = false;
            }
        });
    </script>
@endsection
