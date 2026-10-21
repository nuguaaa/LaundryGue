@extends('layouts.admin')

@section('header')
    <h2 class="font-bold text-xl sm:text-2xl text-slate-800 leading-tight">
        {{ __('Kelola Harga Layanan') }}
    </h2>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Manajemen Harga Layanan</h1>
            <p class="text-slate-500 text-xs sm:text-sm mt-0.5">Atur, tambah, ubah, dan hapus tarif paket layanan laundry.</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="w-full sm:w-auto justify-center bg-sky-600 text-white px-4 py-2.5 rounded-xl font-bold hover:bg-sky-500 transition shadow-sm text-xs sm:text-sm flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <span>Tambah Layanan Baru</span>
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-2xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900 text-white text-xs font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-4 min-w-[120px]">Kategori</th>
                        <th class="py-3.5 px-4 min-w-[180px]">Nama Layanan</th>
                        <th class="py-3.5 px-4 min-w-[130px]">Estimasi Durasi</th>
                        <th class="py-3.5 px-4 min-w-[120px]">Harga Tarif</th>
                        <th class="py-3.5 px-4 min-w-[100px]">Satuan Unit</th>
                        <th class="py-3.5 px-4 text-center min-w-[130px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-xs sm:text-sm">
                    @forelse($services as $service)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-600">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                    {{ $service->category }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-800">{{ $service->name }}</td>
                            <td class="py-3.5 px-4 text-slate-500 text-xs">{{ $service->duration }}</td>
                            <td class="py-3.5 px-4 font-bold text-sky-600 font-mono">Rp{{ number_format($service->price, 0, ',', '.') }}</td>
                            <td class="py-3.5 px-4 text-slate-500 text-xs font-semibold">/ {{ $service->unit }}</td>
                            <td class="py-3.5 px-4 text-center space-x-1 sm:space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="inline-block bg-amber-50 hover:bg-amber-500 text-amber-700 hover:text-white border border-amber-200 hover:border-amber-500 px-3 py-1 rounded-lg text-xs font-bold transition shadow-sm">Ubah</a>

                                <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus layanan {{ $service->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 px-3 py-1 rounded-lg text-xs font-bold transition shadow-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 italic">Belum ada layanan laundry.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

