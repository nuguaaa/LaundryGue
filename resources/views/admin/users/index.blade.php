@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Manajemen Pengguna') }}
    </h2>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative shadow-sm">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Form Tambah User -->
    <div class="bg-white shadow-sm rounded-xl p-6 border border-gray-200">
        <h2 class="text-lg font-bold text-gray-800 mb-1">Tambah User Baru</h2>
        <p class="text-sm text-gray-600 mb-4">Buat akun baru untuk admin atau kasir laundry.</p>

        <form action="{{ route('admin.users.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Nama Lengkap</label>
                <input type="text" name="name" placeholder="Contoh: Budi Kasir" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand text-sm" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Email / Gmail</label>
                <input type="email" name="email" placeholder="budi@laundry.com" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand text-sm" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">No. Telepon / WhatsApp</label>
                <input type="text" name="phone" placeholder="081234567890" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand text-sm" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Role / Hak Akses</label>
                <div class="flex gap-2">
                    <select name="role" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand text-sm bg-white" required>
                        <option value="kasir">Kasir</option>
                        <option value="admin">Admin</option>
                    </select>
                    <button type="submit" class="bg-brand text-white px-4 py-2 rounded-lg font-medium hover:bg-sky-600 transition text-sm shadow-sm whitespace-nowrap">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel User Aktif -->
    <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Daftar Pengguna Aktif</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 text-xs uppercase tracking-wider border-b border-gray-200">
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Email / Kontak</th>
                        <th class="py-3 px-4">Role</th>
                        <th class="py-3 px-4">Tanggal Dibuat</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @forelse($users as $u)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4 font-medium text-gray-800">{{ $u->name }}</td>
                        <td class="py-3 px-4 text-gray-600">
                            <div>{{ $u->email }}</div>
                            <div class="text-xs text-gray-400">{{ $u->phone ?? '-' }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $u->role == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">{{ $u->created_at->format('d M Y') }}</td>
                        <td class="py-3 px-4 text-center">
                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin memindahkan user ini ke history?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-red-100 transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-400 italic">Belum ada user aktif.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- History (Trashed) -->
    <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-red-100">
        <div class="p-6 border-b border-gray-200 bg-red-50/50">
            <h3 class="text-lg font-bold text-red-700">History User Dihapus</h3>
            <p class="text-xs text-red-500">Daftar akun yang telah dihapus (bisa dihapus permanen jika sudah tidak dibutuhkan).</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 text-xs uppercase tracking-wider border-b border-gray-200">
                        <th class="py-3 px-4">Nama & Kontak</th>
                        <th class="py-3 px-4">Tanggal Dihapus</th>
                        <th class="py-3 px-4 text-center">Aksi Permanen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @forelse($trashed as $t)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4">
                            <div class="font-medium text-gray-800">{{ $t->name }}</div>
                            <div class="text-xs text-gray-500">{{ $t->email }} | {{ $t->phone ?? '-' }}</div>
                        </td>
                        <td class="py-3 px-4 text-gray-600 text-xs">
                            {{ $t->deleted_at->format('d M Y, H:i') }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            <form action="{{ route('admin.users.forceDelete', $t->id) }}" method="POST" onsubmit="return confirm('Hapus permanen user ini? Tindakan ini tidak dapat dibatalkan!')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-red-700 transition shadow-sm">Hapus Permanen</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-6 text-center text-gray-400 italic">Belum ada history penghapusan user.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
