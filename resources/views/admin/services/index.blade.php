@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Harga Layanan</h1>
            <p class="text-gray-600 text-sm">Atur, tambah, ubah, dan hapus harga layanan laundry.</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="bg-brand text-white px-4 py-2 rounded-lg font-medium hover:bg-sky-600 transition shadow-sm">
            + Tambah Layanan
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-200">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-brand text-white">
                    <th class="py-3 px-4">Kategori</th>
                    <th class="py-3 px-4">Nama Layanan</th>
                    <th class="py-3 px-4">Durasi</th>
                    <th class="py-3 px-4">Harga (Rp)</th>
                    <th class="py-3 px-4">Satuan</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($services as $service)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 text-sm font-semibold text-gray-600">{{ $service->category }}</td>
                        <td class="py-3 px-4 font-medium text-gray-800">{{ $service->name }}</td>
                        <td class="py-3 px-4 text-sm text-gray-600">{{ $service->duration }}</td>
                        <td class="py-3 px-4 font-bold text-brand">Rp{{ number_format($service->price, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-sm text-gray-600">/ {{ $service->unit }}</td>
                        <td class="py-3 px-4 text-center space-x-2">
                            <!-- Tombol Edit -->
                            <a href="{{ route('admin.services.edit', $service->id) }}" class="inline-block bg-amber-500 text-white px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-amber-600 transition shadow-sm">Ubah</a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-red-600 transition shadow-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
