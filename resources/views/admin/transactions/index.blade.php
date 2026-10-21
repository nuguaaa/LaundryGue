@extends('layouts.admin')

@section('header')
    <h2 class="font-bold text-xl text-slate-800 leading-tight">
        {{ __('Daftar Pesanan Aktif') }}
    </h2>
@endsection

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Pesanan Sedang Berjalan</h1>
            <p class="text-slate-500 text-sm">Kelola status cucian pelanggan secara berkala. Ketika pesanan berstatus "Diambil", pesanan otomatis diarsipkan ke laporan.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.transactions.history') }}" class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-slate-900 transition shadow-sm">
                    Lihat History Laporan &rarr;
                </a>
            @else
                <a href="{{ route('admin.transactions.history') }}" class="bg-red-50 text-red-700 border border-red-200 px-4 py-2 rounded-xl text-sm font-bold hover:bg-red-100 transition shadow-sm">
                    Input Pengeluaran Operasional &rarr;
                </a>
            @endif
            <a href="{{ route('admin.transactions.create') }}" class="bg-sky-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-sky-500 transition shadow-sm">
                + Input Kasir Baru
            </a>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-slate-200">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900 text-white text-xs font-bold uppercase tracking-wider">
                        <th class="py-3 px-4 min-w-[130px]">Invoice</th>
                        <th class="py-3 px-4 min-w-[150px]">Pelanggan</th>
                        <th class="py-3 px-4 min-w-[180px]">Layanan</th>
                        <th class="py-3 px-4 min-w-[120px]">Total Biaya</th>
                        <th class="py-3 px-4 min-w-[110px]">Diproses Oleh</th>
                        <th class="py-3 px-4 min-w-[160px]">Status Cucian</th>
                        <th class="py-3 px-4 min-w-[140px] text-center">Aksi & Notifikasi WA</th>
                    </tr>
                </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($transactions as $trx)
                    <tr class="hover:bg-slate-50">
                        <td class="py-3.5 px-4 font-mono font-bold text-sky-600 text-xs">{{ $trx->invoice_code }}</td>
                        <td class="py-3.5 px-4">
                            <div class="font-bold text-slate-800">{{ $trx->customer_name }}</div>
                            <div class="text-xs text-slate-500">{{ $trx->customer_phone }}</div>
                        </td>
                        <td class="py-3.5 px-4 text-sm text-slate-700">
                            @foreach($trx->details as $detail)
                                <div>{{ $detail->service->name ?? 'Layanan' }} <span class="text-xs text-slate-500">({{ $detail->quantity }} {{ $detail->service->unit ?? '' }})</span></div>
                            @endforeach
                        </td>
                        <td class="py-3.5 px-4 font-bold text-slate-900">Rp{{ number_format($trx->total_price, 0, ',', '.') }}</td>

                        <td class="py-3.5 px-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-800">
                                {{ $trx->user->name ?? 'Sistem' }}
                            </span>
                        </td>

                        <td class="py-3.5 px-4">
                            <form action="{{ route('admin.transactions.status', $trx->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="text-xs font-bold px-3 py-1.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500
                                    {{ $trx->status == 'Selesai' ? 'bg-emerald-50 text-emerald-700 border-emerald-300' : ($trx->status == 'Proses' ? 'bg-blue-50 text-blue-700 border-blue-300' : 'bg-amber-50 text-amber-700 border-amber-300') }}">
                                    <option value="Baru" {{ $trx->status == 'Baru' ? 'selected' : '' }}>Baru / Diterima</option>
                                    <option value="Proses" {{ $trx->status == 'Proses' ? 'selected' : '' }}>Sedang Diproses</option>
                                    <option value="Selesai" {{ $trx->status == 'Selesai' ? 'selected' : '' }}>Selesai (Siap Ambil)</option>
                                    <option value="Diambil" {{ $trx->status == 'Diambil' ? 'selected' : '' }}>Sudah Diambil (Selesai)</option>
                                </select>
                            </form>
                        </td>

                        <td class="py-3.5 px-4 text-center space-y-1.5">
                            <!-- Tombol Kirim WA Otomatis jika status Selesai -->
                            @if($trx->status == 'Selesai' && !empty($trx->customer_phone))
                                <div>
                                    <a href="https://wa.me/{{ $trx->customer_phone }}?text=Halo%20kak%20{{ urlencode($trx->customer_name) }},%20cucian%20dengan%20nomor%20resi%20*{{ $trx->invoice_code }}*%20di%20LaundryGue%20sudah%20selesai%20dan%20siap%20diambil%20ya!%20Terima%20kasih."
                                       target="_blank"
                                       class="inline-flex items-center justify-center gap-1 bg-emerald-600 text-white px-3 py-1.5 rounded-xl text-xs font-bold hover:bg-emerald-700 transition shadow-sm">
                                        💬 Kirim WA
                                    </a>
                                </div>
                            @endif

                            @if(auth()->user()->role == 'admin')
                                <form action="{{ route('admin.transactions.destroy', $trx->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-50 hover:bg-red-600 text-red-600 hover:text-white border border-red-200 hover:border-red-600 px-3 py-1 rounded-lg text-xs font-bold transition shadow-sm">
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-400 italic">Tidak ada pesanan aktif saat ini. Semuanya sudah diambil!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
