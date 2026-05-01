@extends('layouts.app')

@section('title', 'Inventaris Produk')
@section('page-title', 'Inventaris Produk')
@section('page-subtitle', 'Kelola semua produk toko Pak Cokomi & Mas Wowo')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 16px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid #e5e7eb !important;
            background: white !important;
            color: #374151 !important;
            transition: all 0.15s;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f0fdf4 !important;
            border-color: #22c55e !important;
            color: #16a34a !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #22c55e !important;
            border-color: #22c55e !important;
            color: white !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .dataTables_wrapper .dataTables_info {
            font-size: 13px;
            color: #6b7280;
            margin-top: 16px;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 4px 8px;
            font-size: 13px;
            margin: 0 4px;
        }
    </style>
@endpush

@section('content')

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Produk</span>
                <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
            <p class="text-xs text-gray-400 mt-1">item terdaftar</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Aktif</span>
                <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['active'] }}</p>
            <p class="text-xs text-gray-400 mt-1">produk aktif</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Menipis</span>
                <div class="w-9 h-9 rounded-xl bg-yellow-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['low_stock'] }}</p>
            <p class="text-xs text-gray-400 mt-1">stok ≤ 10</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Habis</span>
                <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ $stats['out'] }}</p>
            <p class="text-xs text-gray-400 mt-1">stok kosong</p>
        </div>
    </div>

    {{-- Search & Filter Bar --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-4">
        <div class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Cari Produk</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0" />
                    </svg>
                    <input type="text" id="searchInput" placeholder="Nama produk atau SKU..."
                        class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>
            </div>

            <div class="min-w-[160px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kategori</label>
                <select id="filterKategori"
                    class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    <option value="">Semua Kategori</option>
                    @foreach (\App\Models\Product::CATEGORIES as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="min-w-[140px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Status</label>
                <select id="filterStatus"
                    class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    <option value="">Semua Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>

            <div class="min-w-[140px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kondisi Stok</label>
                <select id="filterStok"
                    class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    <option value="">Semua Stok</option>
                    <option value="tersedia">Tersedia (> 10)</option>
                    <option value="menipis">Menipis (1–10)</option>
                    <option value="habis">Habis (0)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1.5 opacity-0">Reset</label>
                <button onclick="resetFilter()"
                    class="px-4 py-2 border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Reset
                </button>
            </div>
        </div>

        <div id="filterInfo" class="mt-3 hidden">
            <p class="text-xs text-gray-500">
                Menampilkan <span id="filterCount" class="font-semibold text-green-600"></span> produk
                <span id="filterDesc"></span>
            </p>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900">Daftar Produk</h2>
            @role('admin')
                <a href="{{ route('products.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Produk
                </a>
            @endrole
        </div>

        <div class="p-6 overflow-x-auto">
            <table id="productsTable" class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500">
                        <th class="pb-3 pr-4">#</th>
                        <th class="pb-3 pr-4">Foto</th>
                        <th class="pb-3 pr-4">Nama Produk</th>
                        <th class="pb-3 pr-4">SKU</th>
                        <th class="pb-3 pr-4">Kategori</th>
                        <th class="pb-3 pr-4">Harga</th>
                        <th class="pb-3 pr-4">Stok</th>
                        <th class="pb-3 pr-4">Status</th>
                        {{-- Header kolom aksi --}}
                        @hasanyrole('admin|staff')
                            <th class="pb-3">Aksi</th>
                        @endhasanyrole
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @foreach ($products as $index => $product)
                        <tr class="hover:bg-gray-50/50 transition">

                            <td class="py-3.5 pr-4 text-gray-400">
                                {{ $index + 1 }}
                            </td>

                            {{-- Foto --}}
                            <td class="py-3.5 pr-4">
                                @if ($product->image)
                                    <img src="{{ asset('uploads/products/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="w-12 h-12 rounded-xl object-cover border border-gray-100">
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center">
                                        No Image
                                    </div>
                                @endif
                            </td>

                            {{-- Nama --}}
                            <td class="py-3.5 pr-4">
                                <p class="font-semibold text-gray-900">
                                    {{ $product->name }}
                                </p>
                            </td>

                            {{-- SKU --}}
                            <td class="py-3.5 pr-4">
                                {{ $product->sku }}
                            </td>

                            {{-- Kategori --}}
                            <td class="py-3.5 pr-4">
                                {{ $product->category }}
                            </td>

                            {{-- Harga --}}
                            <td class="py-3.5 pr-4">
                                {{ $product->formatted_price }}
                            </td>

                            {{-- Stok --}}
                            <td class="py-3.5 pr-4">
                                {{ $product->stock }} {{ $product->unit }}
                            </td>

                            {{-- Status --}}
                            <td class="py-3.5 pr-4">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </td>

                            @hasanyrole('admin|staff')
                                {{-- Aksi --}}
                                <td class="py-3.5">
                                    <div class="flex items-center gap-2">
                                        {{-- Tombol Edit — admin & staff saja --}}
                                        @hasanyrole('admin|staff')
                                            <a href="{{ route('products.edit', $product) }}"
                                                class="p-2 rounded-lg text-blue-500 hover:bg-blue-50 transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        @endhasanyrole

                                        {{-- Tombol Hapus — hanya admin --}}
                                        @role('admin')
                                            <button type="button"
                                                onclick="confirmDelete({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                                class="p-2 rounded-lg text-red-500 hover:bg-red-50 transition" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endrole

                                    </div>
                                </td>
                            @endhasanyrole
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Konfirmasi Delete --}}
    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4">
            <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 text-center mb-1">Hapus Produk?</h3>
            <p class="text-sm text-gray-500 text-center mb-2">
                Produk <strong id="deleteProductName" class="text-gray-800"></strong> akan dihapus permanen.
            </p>
            <p class="text-xs text-red-500 text-center mb-6">⚠️ Tindakan ini tidak bisa dibatalkan!</p>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-xl transition">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        let table;

        $(document).ready(function() {
            table = $('#productsTable').DataTable({
                language: {
                    search: "",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ – _END_ dari _TOTAL_ produk",
                    infoEmpty: "Tidak ada data",
                    zeroRecords: "Produk tidak ditemukan",
                    paginate: {
                        first: "«",
                        last: "»",
                        next: "›",
                        previous: "‹"
                    },
                },
                pageLength: 10,
                dom: 'lrtip',
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }],
            });

            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
                updateFilterInfo();
            });

            $('#filterKategori').on('change', function() {
                table.column(4).search(this.value).draw();
                updateFilterInfo();
            });

            $('#filterStatus').on('change', function() {
                table.column(7).search(this.value).draw();
                updateFilterInfo();
            });

            $.fn.dataTable.ext.search.push(function(settings, data) {
                const filterVal = $('#filterStok').val();
                if (!filterVal) return true;
                const stokText = data[6] || '';
                const angka = parseInt(stokText.replace(/[^0-9]/g, '')) || 0;
                if (filterVal === 'habis') return angka === 0;
                if (filterVal === 'menipis') return angka >= 1 && angka <= 10;
                if (filterVal === 'tersedia') return angka > 10;
                return true;
            });

            $('#filterStok').on('change', function() {
                table.draw();
                updateFilterInfo();
            });
        });

        function updateFilterInfo() {
            const search = $('#searchInput').val();
            const kategori = $('#filterKategori').val();
            const status = $('#filterStatus').val();
            const stok = $('#filterStok').val();
            const aktif = search || kategori || status || stok;
            const info = document.getElementById('filterInfo');

            if (aktif) {
                info.classList.remove('hidden');
                document.getElementById('filterCount').textContent = table.rows({
                    filter: 'applied'
                }).count();
                let parts = [];
                if (search) parts.push(`nama/SKU "<b>${search}</b>"`);
                if (kategori) parts.push(`kategori "<b>${kategori}</b>"`);
                if (status) parts.push(`status "<b>${status}</b>"`);
                if (stok) parts.push(`stok "<b>${stok}</b>"`);
                document.getElementById('filterDesc').innerHTML = 'dengan filter: ' + parts.join(', ');
            } else {
                info.classList.add('hidden');
            }
        }

        function resetFilter() {
            $('#searchInput').val('');
            $('#filterKategori').val('');
            $('#filterStatus').val('');
            $('#filterStok').val('');
            table.search('').columns().search('').draw();
            document.getElementById('filterInfo').classList.add('hidden');
        }

        function confirmDelete(id, name) {
            document.getElementById('deleteProductName').textContent = name;
            document.getElementById('deleteForm').action = `/products/${id}`;
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDeleteModal();
        });
    </script>
@endpush
