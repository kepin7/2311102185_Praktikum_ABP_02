@extends('layouts.app')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')
@section('page-subtitle', 'Perbarui informasi produk yang sudah ada')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- Card Header --}}
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <a href="{{ route('products.index') }}"
               class="p-2 rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="font-semibold text-gray-900">Edit: {{ $product->name }}</h2>
                <p class="text-xs text-gray-400">SKU: {{ $product->sku }} · Dibuat {{ $product->created_at->diffForHumans() }}</p>
            </div>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Nama Produk --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Nama Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                       class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent
                              {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- SKU + Kategori --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        SKU <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                           class="w-full px-4 py-2.5 border rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent
                                  {{ $errors->has('sku') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                    @error('sku')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category"
                            class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent
                                   {{ $errors->has('category') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category', $product->category) == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Harga Jual + Harga Modal --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Harga Jual <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium">Rp</span>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="100"
                               class="w-full pl-10 pr-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent
                                      {{ $errors->has('price') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                    </div>
                    @error('price')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Harga Modal <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium">Rp</span>
                        <input type="number" name="cost_price" value="{{ old('cost_price', $product->cost_price) }}" min="0" step="100"
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent">
                    </div>
                </div>
            </div>

            {{-- Stok + Satuan --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                           class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent
                                  {{ $errors->has('stock') ? 'border-red-400 bg-red-50' : 'border-gray-200' }}">
                    @error('stock')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Satuan <span class="text-red-500">*</span>
                    </label>
                    <select name="unit"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent">
                        @foreach($units as $unit)
                            <option value="{{ $unit }}" {{ old('unit', $product->unit) == $unit ? 'selected' : '' }}>
                                {{ $unit }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Deskripsi <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm resize-none focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent">{{ old('description', $product->description) }}</textarea>
            </div>

            {{-- Foto Produk --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Foto Produk <span class="text-gray-400 font-normal">(opsional, maks 2MB)</span>
                </label>

                {{-- Foto saat ini --}}
                @if($product->image)
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ asset('uploads/products/' . $product->image) }}"
                             alt="Foto saat ini"
                             class="w-20 h-20 rounded-xl object-cover border border-gray-200">
                        <div>
                            <p class="text-xs font-medium text-gray-600">Foto saat ini</p>
                            <p class="text-xs text-gray-400 mt-0.5">Upload foto baru untuk mengganti</p>
                        </div>
                    </div>
                @endif

                <input type="file" name="image" accept="image/*" id="imageInput"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm
                              file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0
                              file:text-sm file:font-semibold file:bg-green-50 file:text-green-700
                              hover:file:bg-green-100 cursor-pointer">
                @error('image')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror

                {{-- Preview foto baru --}}
                <div id="imagePreview" class="mt-3 hidden">
                    <img id="previewImg" src="" alt="Preview"
                         class="w-24 h-24 rounded-xl object-cover border border-gray-200">
                    <p class="text-xs text-gray-400 mt-1">Preview foto baru</p>
                </div>
            </div>

            {{-- Status Aktif --}}
            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 rounded accent-green-500 cursor-pointer">
                <label for="is_active" class="text-sm font-medium text-gray-700 cursor-pointer">
                    Produk aktif (tampil di inventaris)
                </label>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3 pt-2">
                <a href="{{ route('products.index') }}"
                   class="flex-1 text-center px-4 py-2.5 border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-xl transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('imageInput').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (ev) {
            document.getElementById('previewImg').src = ev.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush