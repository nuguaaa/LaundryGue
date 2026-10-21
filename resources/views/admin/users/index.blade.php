@extends('layouts.admin')

@section('header')
    <h2 class="font-bold text-xl sm:text-2xl text-slate-800 leading-tight">
        {{ __('Kelola Pengguna Sistem') }}
    </h2>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-2xl relative shadow-sm flex items-center justify-between">
            <span class="text-xs sm:text-sm font-semibold">{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 font-bold ml-2 text-lg leading-none">&times;</button>
        </div>
    @endif

    <!-- Form Tambah User -->
    <div class="bg-white shadow-sm rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-slate-200">
        <h2 class="text-lg sm:text-xl font-black text-slate-800 tracking-tight mb-1">Tambah User Baru</h2>
        <p class="text-xs sm:text-sm text-slate-500 mb-5">Buat akun staf baru untuk operasional admin atau kasir laundry.</p>

        <form action="{{ route('admin.users.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" placeholder="Contoh: Budi Kasir" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 text-base sm:text-sm" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Email / Akun <span class="text-red-500">*</span></label>
                <input type="email" name="email" placeholder="budi@laundry.com" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 text-base sm:text-sm" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">No. Telepon / WhatsApp <span class="text-red-500">*</span></label>
                <input type="text" name="phone" placeholder="081234567890" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 text-base sm:text-sm" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Role / Hak Akses <span class="text-red-500">*</span></label>
                <div class="flex flex-col sm:flex-row gap-2">
                    <select name="role" class="w-full px-3.5 py-3 sm:py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500 text-base sm:text-sm bg-white font-medium" required>
                        <option value="kasir">Kasir</option>
                        <option value="admin">Admin</option>
                    </select>
                    <button type="submit" class="w-full sm:w-auto bg-sky-600 text-white px-5 py-3 sm:py-2.5 rounded-xl font-bold hover:bg-sky-500 transition text-sm shadow-sm whitespace-nowrap text-center">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel User Aktif -->
    <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
            <h3 class="text-sm sm:text-base font-bold text-slate-800">Daftar Pengguna Aktif</h3>
            <span class="text-xs text-slate-500 font-semibold">{{ $users->count() }} User Aktif</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900 text-white text-xs font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 min-w-[150px]">Nama</th>
                        <th class="py-3.5 px-4 min-w-[180px]">Email & Kontak</th>
                        <th class="py-3.5 px-4 min-w-[120px]">Role Akses</th>
                        <th class="py-3.5 px-4 min-w-[140px]">Tanggal Bergabung</th>
                        <th class="py-3.5 px-4 text-center min-w-[100px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-xs sm:text-sm">
                    @forelse($users as $u)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-3.5 px-4 font-bold text-slate-800">{{ $u->name }}</td>
                        <td class="py-3.5 px-4 text-slate-600">
                            <div>{{ $u->email }}</div>
                            <div class="text-xs text-slate-400 font-mono">{{ $u->phone ?? '-' }}</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $u->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-sky-100 text-sky-800' }}">
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 text-xs whitespace-nowrap">{{ $u->created_at->format('d M Y') }}</td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Pindahkan user {{ $u->name }} ke history terhapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 px-3 py-1 rounded-lg text-xs font-bold transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400 italic">Belum ada user aktif.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- History (Trashed) -->
    <div class="bg-white shadow-sm rounded-2xl border border-red-200 overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-red-100 bg-red-50/40">
            <h3 class="text-sm sm:text-base font-bold text-red-800">History User Terhapus (Arsip)</h3>
            <p class="text-xs text-red-600/80 mt-0.5">Daftar akun yang dinonaktifkan. Anda dapat memulihkannya atau menghapus permanen dari basis data.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-700 text-xs font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 min-w-[180px]">Nama & Kontak</th>
                        <th class="py-3.5 px-4 min-w-[150px]">Tanggal Dihapus</th>
                        <th class="py-3.5 px-4 text-center min-w-[130px]">Aksi Permanen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-xs sm:text-sm">
                    @forelse($trashed as $t)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-slate-800">{{ $t->name }}</div>
                            <div class="text-xs text-slate-500">{{ $t->email }} | {{ $t->phone ?? '-' }}</div>
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 text-xs whitespace-nowrap">
                            {{ $t->deleted_at->format('d M Y, H:i') }}
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <form action="{{ route('admin.users.forceDelete', $t->id) }}" method="POST" onsubmit="return confirm('Hapus permanen user ini? Tindakan ini tidak dapat dibatalkan!')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded-lg text-xs font-bold hover:bg-red-700 transition shadow-sm">Hapus Permanen</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-6 text-center text-slate-400 italic">Belum ada history penghapusan user.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

