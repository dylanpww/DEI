@extends('layouts.app')

@section('title', 'Tambah Produk Baru - Crave')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('products.index') }}"
                class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-500 hover:text-crave-teal transition-colors">
                <ion-icon name="arrow-back-outline"></ion-icon>
            </a>
            <h1 class="text-2xl font-extrabold text-gray-900">Tambah Produk Baru</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                    <div class="flex items-center mb-2">
                        <ion-icon name="alert-circle" class="text-red-500 text-xl mr-2"></ion-icon>
                        <h3 class="text-red-800 font-bold">Ada kesalahan pada input Anda:</h3>
                    </div>
                    <ul class="list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Produk</label>
                    <div
                        class="mt-1 relative flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-crave-lime transition-colors bg-gray-50 h-48 group">
                        <div id="upload-prompt"
                            class="space-y-1 text-center flex flex-col items-center justify-center h-full">
                            <ion-icon name="image-outline" class="mx-auto h-12 w-12 text-gray-400"></ion-icon>
                            <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="image"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-crave-teal hover:text-crave-darkgreen focus-within:outline-none px-2 py-1">
                                        <span>Unggah file</span>
                                        <input id="image" name="images[]" type="file" class="sr-only" accept="image/*" multiple>
                                    </label>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF maks 2MB</p>
                        </div>

                        <!-- Preview Container -->
                        <div id="image-preview-container"
                            class="hidden absolute inset-0 w-full h-full bg-white z-10 rounded-xl overflow-hidden">
                            <img id="image-preview" src="#" alt="Preview"
                                class="w-full h-full object-contain bg-gray-50 p-2">
                            <div
                                class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                                <label for="image"
                                    class="cursor-pointer px-4 py-2 bg-white text-gray-900 rounded-lg text-sm font-semibold hover:bg-gray-100 shadow-sm transition-colors">
                                    Ubah
                                </label>
                                <button type="button" id="Hapus-image"
                                    class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-semibold hover:bg-red-600 shadow-sm transition-colors">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Produk</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime focus:ring focus:ring-crave-lime/20 py-2.5 px-3 border"
                            placeholder="e.g. Surplus Blueberry Muffins">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                        <select name="category_id" id="category_id" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-crave-teal focus:ring-1 focus:ring-crave-teal transition-colors bg-white">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $Kategori)
                                <option value="{{ $Kategori->category_id }}"
                                    {{ old('category_id') == $Kategori->category_id ? 'selected' : '' }}>
                                    {{ $Kategori->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                        <select name="status" id="status" required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime focus:ring focus:ring-crave-lime/20 py-2.5 px-3 border bg-white">
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available
                            </option>
                            <option value="sold_out" {{ old('status') == 'sold_out' ? 'selected' : '' }}>Habis</option>
                            <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Kedaluwarsa</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price and Discount Wrapper -->
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6" id="discount-wrapper">
                        <!-- Price -->
                        <div>
                            <label for="actualPrice" class="block text-sm font-semibold text-gray-700 mb-1">Harga Asli (Rp)</label>
                            <input type="number" name="actualPrice" id="actualPrice" value="{{ old('actualPrice') }}" required min="0"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime py-2.5 px-3 border bg-white">
                            @error('actualPrice')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Discount -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Diskon</label>
                            <div class="flex gap-3">
                                <select id="discountType" class="rounded-lg border-gray-300 shadow-sm focus:border-crave-lime py-2.5 px-3 border w-1/3 bg-white font-medium text-gray-700">
                                    <option value="fixed">Rp</option>
                                    <option value="percentage">%</option>
                                </select>
                                
                                <div class="w-2/3">
                                    <input type="number" id="discountInput" min="0"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime py-2.5 px-3 border bg-white" 
                                        placeholder="Nominal (Rp)">
                                </div>
                            </div>
                            
                            <!-- Hidden input to submit the actual discount value to the backend -->
                            <input type="hidden" id="hidden_discount_create" name="discount" value="{{ old('discount', 0) !== '' && old('discount', 0) !== null ? (int) old('discount', 0) : 0 }}">
                            
                            <p id="discountHelper" class="hidden text-xs text-crave-darkgreen mt-2 font-bold bg-crave-lime/20 px-3 py-1.5 rounded-lg border border-crave-lime/30 w-fit">
                                Potongan: Rp <span id="discountPreview">0</span>
                            </p>
                            
                            @error('discount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Stok</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required
                            min="0"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime focus:ring focus:ring-crave-lime/20 py-2.5 px-3 border">
                        @error('stock')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Details -->
                    <div>
                        <label for="weight_in_grams" class="block text-sm font-semibold text-gray-700 mb-1">Berat (gram)</label>
                        <input type="number" name="weight_in_grams" id="weight_in_grams" value="{{ old('weight_in_grams') }}" min="0" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime py-2.5 px-3 border">
                    </div>
                    <div>
                        <label for="production_time" class="block text-sm font-semibold text-gray-700 mb-1">Waktu Produksi</label>
                        <input type="datetime-local" name="production_time" id="production_time" value="{{ old('production_time') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime py-2.5 px-3 border">
                    </div>
                    <div>
                        <label for="production_label" class="block text-sm font-semibold text-gray-700 mb-1">Label Produksi</label>
                        <input type="text" name="production_label" id="production_label" value="{{ old('production_label') }}" placeholder="e.g. Halal, Organic" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime py-2.5 px-3 border">
                    </div>
                    <div>
                        <label for="food_condition" class="block text-sm font-semibold text-gray-700 mb-1">Kondisi Makanan</label>
                        <input type="text" name="food_condition" id="food_condition" value="{{ old('food_condition') }}" placeholder="e.g. Fresh, Frozen" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime py-2.5 px-3 border">
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="px-8 py-3 bg-crave-green hover:bg-crave-darkgreen text-white font-bold rounded-xl transition-colors shadow-md">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const uploadPrompt = document.getElementById('upload-prompt');
            const previewContainer = document.getElementById('image-preview-container');
            const imagePreview = document.getElementById('image-preview');
            const HapusBtn = document.getElementById('Hapus-image');

            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Display preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        uploadPrompt.classList.add('hidden');
                        previewContainer.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });

            HapusBtn.addEventListener('click', function() {
                // Reset input and view
                imageInput.value = '';
                imagePreview.src = '#';
                previewContainer.classList.add('hidden');
                uploadPrompt.classList.remove('hidden');
            });

            // Discount Logic Implementation (Vanilla JS)
            const actualPriceInput = document.getElementById('actualPrice');
            const discountTypeSelect = document.getElementById('discountType');
            const discountInput = document.getElementById('discountInput');
            const hiddenDiscount = document.getElementById('hidden_discount_create');
            const discountHelper = document.getElementById('discountHelper');
            const discountPreview = document.getElementById('discountPreview');

            function calculateDiscount() {
                let actualPrice = parseFloat(actualPriceInput.value) || 0;
                let inputValue = parseFloat(discountInput.value) || 0;
                let discountType = discountTypeSelect.value;
                let computedDiscount = 0;

                if (discountType === 'percentage') {
                    if (inputValue > 100) {
                        inputValue = 100;
                        discountInput.value = 100;
                    }
                    computedDiscount = Math.round(actualPrice * (inputValue / 100));
                    
                    if (computedDiscount > 0) {
                        discountHelper.classList.remove('hidden');
                        discountPreview.textContent = new Intl.NumberFormat('id-ID').format(computedDiscount);
                    } else {
                        discountHelper.classList.add('hidden');
                    }
                } else {
                    computedDiscount = inputValue;
                    discountHelper.classList.add('hidden');
                }

                hiddenDiscount.value = computedDiscount;
            }

            if (actualPriceInput && discountInput && discountTypeSelect) {
                actualPriceInput.addEventListener('input', calculateDiscount);
                discountInput.addEventListener('input', calculateDiscount);
                discountTypeSelect.addEventListener('change', function() {
                    discountInput.placeholder = this.value === 'percentage' ? 'Persentase (%)' : 'Nominal (Rp)';
                    calculateDiscount();
                });

                // Initialize form state
                if (hiddenDiscount.value && parseFloat(hiddenDiscount.value) > 0) {
                    discountInput.value = hiddenDiscount.value;
                    discountTypeSelect.value = 'fixed';
                    calculateDiscount();
                }
            }
        });
    </script>
@endpush

