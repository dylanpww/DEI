@extends('layouts.app')

@section('title', 'Edit Produk - Crave')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-center gap-3">
            <a href="{{ route('products.index') }}"
                class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-500 hover:text-crave-teal transition-colors">
                <ion-icon name="arrow-back-outline"></ion-icon>
            </a>
            <h1 class="text-2xl font-extrabold text-gray-900">Edit Produk</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <form action="{{ route('products.update', $product->product_ID) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Image Upload with Current Preview -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Produk</label>
                    @php 
                        $primaryImage = $product->images->first() ? $product->images->first()->image_path : $product->image;
                    @endphp
                    @if ($primaryImage)
                        <div class="mb-4" id="current-image-container">
                            <p class="text-xs text-gray-500 mb-2">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $primaryImage) }}" alt="{{ $product->name }}"
                                class="w-32 h-32 object-cover rounded-xl border border-gray-200 shadow-sm">
                        </div>
                    @endif
                    <div
                        class="mt-1 relative flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-crave-lime transition-colors bg-gray-50 h-48 group">
                        <div id="upload-prompt"
                            class="space-y-1 text-center flex flex-col items-center justify-center h-full">
                            <ion-icon name="cloud-upload-outline" class="mx-auto h-12 w-12 text-gray-400"></ion-icon>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="image"
                                    class="relative cursor-pointer bg-white rounded-md font-medium text-crave-teal hover:text-crave-darkgreen focus-within:outline-none px-2 py-1">
                                    <span>Unggah file baru</span>
                                    <input id="image" name="images[]" type="file" class="sr-only" accept="image/*" multiple>
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">Biarkan kosong untuk mempertahankan gambar saat ini</p>
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
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                            required
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime focus:ring focus:ring-crave-lime/20 py-2.5 px-3 border">
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
                                    {{ old('category_id', $product->category_id) == $Kategori->category_id ? 'selected' : '' }}>
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
                            <option value="available"
                                {{ old('status', $product->status) == 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="sold_out" {{ old('status', $product->status) == 'sold_out' ? 'selected' : '' }}>
                                Sold Out</option>
                            <option value="expired" {{ old('status', $product->status) == 'expired' ? 'selected' : '' }}>
                                Expired</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price and Discount Wrapper -->
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{
                        actualPrice: {{ old('actualPrice', $product->actualPrice) }},
                        discountType: 'fixed',
                        inputValue: {{ old('discount', $product->discount) ?: 'null' }},
                        computedDiscount: {{ old('discount', $product->discount) ?: 0 }},
                        updateDiscount() {
                            let val = parseFloat(this.inputValue) || 0;
                            if (this.discountType === 'percentage') {
                                // cap at 100%
                                if(val > 100) { val = 100; this.inputValue = 100; }
                                this.computedDiscount = Math.round(this.actualPrice * (val / 100));
                            } else {
                                this.computedDiscount = val;
                            }
                        }
                    }">
                        <!-- Price -->
                        <div>
                            <label for="actualPrice" class="block text-sm font-semibold text-gray-700 mb-1">Harga Asli (Rp)</label>
                            <input type="number" name="actualPrice" id="actualPrice" x-model="actualPrice" @input="updateDiscount" required min="0"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime py-2.5 px-3 border bg-white">
                            @error('actualPrice')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Discount -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Diskon</label>
                            <div class="flex gap-3">
                                <select x-model="discountType" @change="updateDiscount" class="rounded-lg border-gray-300 shadow-sm focus:border-crave-lime py-2.5 px-3 border w-1/3 bg-white font-medium text-gray-700">
                                    <option value="fixed">Rp</option>
                                    <option value="percentage">%</option>
                                </select>
                                
                                <div class="w-2/3">
                                    <input type="number" x-model="inputValue" @input="updateDiscount" min="0"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime py-2.5 px-3 border bg-white" 
                                        :placeholder="discountType === 'percentage' ? 'Persentase (%)' : 'Nominal (Rp)'">
                                </div>
                            </div>
                            
                            <!-- Hidden input to submit the actual discount value to the backend -->
                            <input type="hidden" name="discount" :value="computedDiscount">
                            
                            <p x-show="discountType === 'percentage' && computedDiscount > 0" class="text-xs text-crave-darkgreen mt-2 font-bold bg-crave-lime/20 px-3 py-1.5 rounded-lg border border-crave-lime/30 w-fit">
                                Potongan: Rp <span x-text="new Intl.NumberFormat('id-ID').format(computedDiscount)"></span>
                            </p>
                            
                            @error('discount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Stok</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}"
                            required min="0"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime focus:ring focus:ring-crave-lime/20 py-2.5 px-3 border">
                        @error('stock')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Details -->
                    <div>
                        <label for="weight_in_grams" class="block text-sm font-semibold text-gray-700 mb-1">Berat (gram)</label>
                        <input type="number" name="weight_in_grams" id="weight_in_grams" value="{{ old('weight_in_grams', $product->weight_in_grams) }}" min="0" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime py-2.5 px-3 border">
                    </div>
                    <div>
                        <label for="production_time" class="block text-sm font-semibold text-gray-700 mb-1">Waktu Produksi</label>
                        <input type="datetime-local" name="production_time" id="production_time" value="{{ old('production_time', $product->production_time) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime py-2.5 px-3 border">
                    </div>
                    <div>
                        <label for="production_label" class="block text-sm font-semibold text-gray-700 mb-1">Label Produksi</label>
                        <input type="text" name="production_label" id="production_label" value="{{ old('production_label', $product->production_label) }}" placeholder="e.g. Halal, Organic" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime py-2.5 px-3 border">
                    </div>
                    <div>
                        <label for="food_condition" class="block text-sm font-semibold text-gray-700 mb-1">Kondisi Makanan</label>
                        <input type="text" name="food_condition" id="food_condition" value="{{ old('food_condition', $product->food_condition) }}" placeholder="e.g. Fresh, Frozen" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-crave-lime py-2.5 px-3 border">
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="px-8 py-3 bg-crave-orange hover:bg-orange-500 text-white font-bold rounded-xl transition-colors shadow-md">
                        Perbarui Produk
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
        });
    </script>
@endpush

