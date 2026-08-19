@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Promo & Diskon</h1>
            <p class="text-gray-600 text-sm">Atur dan kelola kupon diskon atau promo menarik untuk pelanggan.</p>
        </div>
        <a href="{{ route('admin.promos.create') }}" class="bg-brand text-white px-4 py-2 rounded-lg font-medium hover:bg-sky-600 transition shadow-sm">
            + Tambah Promo
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-200">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-brand text-white">
                    <th class="py-3 px-4">Judul Promo</th>
                    <th class="py-3 px-4">Kode Kupon</th>
                    <th class="py-3 px-4">Diskon</th>
                    <th class="py-3 px-4">Berlaku Sampai</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($promos as $promo)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 font-medium text-gray-800">
                            {{ $promo->title }}
                            <div class="text-xs text-gray-500 font-normal">{{ Str::limit($promo->description, 40) }}</div>
                        </td>
                        <td class="py-3 px-4 font-mono font-bold text-brand uppercase">{{ $promo->code }}</td>
                        <td class="py-3 px-4 text-sm font-semibold text-green-600">{{ $promo->discount }}</td>
                        <td class="py-3 px-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($promo->expired_date)->format('d M Y') }}</td>
                        <td class="py-3 px-4 text-center space-x-2">
                            <a href="{{ route('admin.promos.edit', $promo->id) }}" class="inline-block bg-amber-500 text-white px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-amber-600 transition shadow-sm">Ubah</a>

                            <form action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus promo ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-red-600 transition shadow-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-500 italic">Belum ada promo yang ditambahkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
