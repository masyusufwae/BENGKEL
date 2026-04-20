@extends('customer.layouts.app')

@section('title', 'Edit Kendaraan - Pelanggan')

@section('page-content')
<div class="mb-8">
    <a href="{{ route('customer.vehicles.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
        ← Kembali
    </a>
                <h1 class="text-3xl font-bold text-gray-900 mt-4">Edit Kendaraan</h1>
                <p class="text-gray-600 mt-2">Perbarui data kendaraan Anda</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow p-6">
                <!-- Modal Pilih Merek -->
                <div id="brand-modal" class="fixed inset-0 z-[110] bg-gray-900/50 hidden flex-col items-center justify-center backdrop-blur-sm transition-opacity duration-300" style="display: none;">
                    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl p-6 m-4 max-h-[85vh] flex flex-col relative" onclick="event.stopPropagation()">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Pilih Merek Kendaraan</h3>
                                <p class="text-sm text-gray-500 mt-1">Pilih dari daftar merek kendaraan populer</p>
                            </div>
                            <button type="button" onclick="closeBrandModal()" class="text-gray-400 hover:text-red-500 transition-colors p-2 hover:bg-red-50 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <div class="overflow-y-auto pr-2 grid grid-cols-2 md:grid-cols-4 gap-3 bg-gray-50 p-4 rounded-xl border border-gray-100" id="brand-list-container">
                            <!-- Isi list merek digenerate via JS -->
                        </div>
                    </div>
                </div>

                <form action="{{ route('customer.vehicles.update', $kendaraan->id_kendaraan) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Nomor Polisi -->
                    <div>
                        <label for="nomor_polisi" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Polisi *
                        </label>
                        <input type="text" id="nomor_polisi" name="nomor_polisi"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Contoh: B 1234 ABC"
                            value="{{ old('nomor_polisi', $kendaraan->nomor_polisi) }}"
                            required>
                        @error('nomor_polisi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Merek & Model -->
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="merek" class="block text-sm font-medium text-gray-700 mb-2">
                                Merek *
                            </label>
                            <div class="flex gap-4 items-center">
                                <div class="flex-grow relative">
                                    <input type="text" id="merek" name="merek"
                                        class="w-full px-4 pr-12 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Contoh: Honda"
                                        value="{{ old('merek', $kendaraan->merek) }}"
                                        required>
                                    <button type="button" onclick="openBrandModal()" class="absolute right-2 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors group" title="Pilih Merek dari Database">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                        </svg>
                                    </button>
                                </div>
                                <!-- Wadah Logo dinamis dipindahkan ke samping dan dibesarkan -->
                                <div class="h-16 min-w-[4rem] rounded-xl bg-gray-50 flex items-center justify-center border-2 border-gray-200 overflow-hidden p-2 hidden transition-all duration-300" id="preview-logo-container">
                                    <img id="brand-logo-preview" src="" alt="Brand Logo" class="h-full w-auto object-contain mix-blend-multiply">
                                </div>
                            </div>
                            @error('merek')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700 mb-2">
                                Model *
                            </label>
                            <input type="text" id="model" name="model"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: Civic"
                                value="{{ old('model', $kendaraan->model) }}"
                                required>
                            @error('model')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tahun & Warna -->
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Produksi *
                            </label>
                            <input type="number" id="tahun" name="tahun" min="1950"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: 2020"
                                value="{{ old('tahun', $kendaraan->tahun) }}"
                                required>
                            @error('tahun')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="warna" class="block text-sm font-medium text-gray-700 mb-2">
                                Warna
                            </label>
                            <input type="text" id="warna" name="warna"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: Hitam"
                                value="{{ old('warna', $kendaraan->warna) }}">
                        </div>
                    </div>

                    <!-- Nomor Rangka & Mesin -->
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="nomor_rangka" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Rangka
                            </label>
                            <input type="text" id="nomor_rangka" name="nomor_rangka"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Nomor rangka kendaraan"
                                value="{{ old('nomor_rangka', $kendaraan->nomor_rangka) }}">
                        </div>
                        <div>
                            <label for="nomor_mesin" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Mesin
                            </label>
                            <input type="text" id="nomor_mesin" name="nomor_mesin"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Nomor mesin kendaraan"
                                value="{{ old('nomor_mesin', $kendaraan->nomor_mesin) }}">
                        </div>
                    </div>

                    <!-- Jenis Bahan Bakar -->
                    <div>
                        <label for="jenis_bahan_bakar" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Bahan Bakar
                        </label>
                        <select id="jenis_bahan_bakar" name="jenis_bahan_bakar"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih jenis bahan bakar</option>
                            <option value="Bensin" {{ old('jenis_bahan_bakar', $kendaraan->jenis_bahan_bakar) == 'Bensin' ? 'selected' : '' }}>Bensin</option>
                            <option value="Diesel" {{ old('jenis_bahan_bakar', $kendaraan->jenis_bahan_bakar) == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="Hybrid" {{ old('jenis_bahan_bakar', $kendaraan->jenis_bahan_bakar) == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                            <option value="Listrik" {{ old('jenis_bahan_bakar', $kendaraan->jenis_bahan_bakar) == 'Listrik' ? 'selected' : '' }}>Listrik</option>
                        </select>
                    </div>

                    <!-- Foto Kendaraan -->
                    <div>
                        <label for="foto_kendaraan" class="block text-sm font-medium text-gray-700 mb-2">
                            Foto Kendaraan (Biarkan kosong jika tidak ingin mengubah)
                        </label>
                        @if($kendaraan->foto_kendaraan)
                            <div class="mb-4" id="current-photo-container">
                                <div class="rounded-lg border border-gray-200 overflow-hidden bg-gray-50 flex inline-block">
                                    <img src="{{ asset('storage/' . $kendaraan->foto_kendaraan) }}" alt="Foto {{ $kendaraan->merek }} {{ $kendaraan->model }}" class="max-h-64 w-auto object-contain">
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Foto saat ini</p>
                            </div>
                        @endif
                        <input type="file" id="foto_kendaraan" name="foto_kendaraan" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100" 
                            onchange="previewPhoto(this)" />
                            
                        <!-- Preview upload foto baru -->
                        <div id="photo-preview-container" class="mt-4 hidden">
                            <p class="text-sm text-gray-500 mb-2">Preview Foto Baru:</p>
                            <div class="rounded-lg border border-gray-200 overflow-hidden bg-gray-50 inline-block">
                                <img id="photo-preview" src="" alt="Preview Foto Kendaraan" class="max-h-64 w-auto object-contain">
                            </div>
                        </div>

                        @error('foto_kendaraan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="border-t border-gray-200 pt-6 flex gap-4">
                        <a href="{{ route('customer.vehicles.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

                <!-- Delete Button -->
                <div class="border-t border-gray-200 mt-6 pt-6">
                    <form action="{{ route('customer.vehicles.destroy', $kendaraan->id_kendaraan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini? Semua data service akan ikut terhapus.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                            Hapus Kendaraan
                        </button>
                    </form>
                </div>
            </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const merekInput = document.getElementById('merek');
        const logoContainer = document.getElementById('preview-logo-container');
        const logoPreview = document.getElementById('brand-logo-preview');

        const domainMap = {
            'toyota': 'toyota.com',
            'honda': 'honda.com',
            'daihatsu': 'daihatsu.com',
            'suzuki': 'globalsuzuki.com',
            'mitsubishi': 'mitsubishi-motors.com',
            'nissan': 'nissan-global.com',
            'hyundai': 'hyundai.com',
            'kia': 'kia.com',
            'wuling': 'wulingmotors.com',
            'mazda': 'mazda.com',
            'isuzu': 'isuzu.com',
            'chevrolet': 'chevrolet.com',
            'bmw': 'bmw.com',
            'mercedes': 'mercedes-benz.com',
            'yamaha': 'yamaha-motor.com',
            'kawasaki': 'kawasaki.com',
            'vespa': 'vespa.com',
            'ktm': 'ktm.com',
            'ducati': 'ducati.com',
            'harley': 'harley-davidson.com',
            'piaggio': 'piaggio.com'
        };

        function updateBrandLogo() {
            const val = merekInput.value.trim();
            if (!val) {
                logoContainer.classList.add('hidden');
                return;
            }
            
            logoContainer.classList.remove('hidden');
            const firstWord = val.split(' ')[0].toLowerCase();
            const domain = domainMap[firstWord] || (firstWord + '.com');
            
            logoPreview.src = 'https://logo.clearbit.com/' + domain;
            
            // Fallback to text initials if logo fails to load
            logoPreview.onerror = function() {
                this.onerror = null;
                this.src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(firstWord) + '&background=eff6ff&color=1d4ed8&bold=true&size=128';
            };
        }

        merekInput.addEventListener('input', updateBrandLogo);
        // Trigger on load for existing value
        updateBrandLogo();
    });

    function previewPhoto(input) {
        const previewContainer = document.getElementById('photo-preview-container');
        const photoPreview = document.getElementById('photo-preview');
        const currentContainer = document.getElementById('current-photo-container');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
                previewContainer.classList.remove('hidden');
                if(currentContainer) {
                    currentContainer.classList.add('hidden');
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            photoPreview.src = "";
            previewContainer.classList.add('hidden');
            if(currentContainer) {
                currentContainer.classList.remove('hidden');
            }
        }
    }

    // Modal Logic
    const domainMapGlobal = {
        // Mobil
        'toyota': 'toyota.com',
        'honda': 'honda.com',
        'daihatsu': 'daihatsu.com',
        'suzuki': 'globalsuzuki.com',
        'mitsubishi': 'mitsubishi-motors.com',
        'nissan': 'nissan-global.com',
        'hyundai': 'hyundai.com',
        'kia': 'kia.com',
        'wuling': 'wulingmotors.com',
        'mazda': 'mazda.com',
        'isuzu': 'isuzu.com',
        'chevrolet': 'chevrolet.com',
        'bmw': 'bmw.com',
        'mercedes': 'mercedes-benz.com',
        
        // Motor
        'yamaha': 'yamaha-motor.com',
        'kawasaki': 'kawasaki.com',
        'vespa': 'vespa.com',
        'ktm': 'ktm.com',
        'ducati': 'ducati.com',
        'harley': 'harley-davidson.com',
        'piaggio': 'piaggio.com'
    };

    function openBrandModal() {
        const modal = document.getElementById('brand-modal');
        modal.style.display = 'flex';
        setTimeout(() => { modal.classList.remove('hidden'); }, 10);
        
        const container = document.getElementById('brand-list-container');
        if (container.children.length === 0) {
            Object.keys(domainMapGlobal).forEach(brand => {
                const domain = domainMapGlobal[brand];
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'flex flex-col items-center justify-center p-4 bg-white border border-gray-200 rounded-xl hover:border-blue-500 hover:ring-2 hover:ring-blue-200 hover:shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500';
                btn.onclick = () => selectBrand(brand);
                
                btn.innerHTML = `
                    <div class="w-14 h-14 mb-3 flex items-center justify-center overflow-hidden">
                        <img src="https://logo.clearbit.com/${domain}" alt="${brand}" class="w-full h-full object-contain mix-blend-multiply" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=${brand}&background=eff6ff&color=1d4ed8&bold=true&size=128'">
                    </div>
                    <span class="text-sm font-semibold text-gray-800 capitalize whitespace-nowrap">${brand}</span>
                    <span class="text-[10px] text-gray-400 mt-1 truncate w-full text-center">${domain}</span>
                `;
                container.appendChild(btn);
            });
        }
    }

    function closeBrandModal() {
        const modal = document.getElementById('brand-modal');
        modal.classList.add('hidden');
        setTimeout(() => { modal.style.display = 'none'; }, 300);
    }

    function selectBrand(brandName) {
        const input = document.getElementById('merek');
        input.value = brandName.charAt(0).toUpperCase() + brandName.slice(1);
        input.dispatchEvent(new Event('input'));
        closeBrandModal();
    }

    document.getElementById('brand-modal').addEventListener('click', function(e) {
        if(e.target === this) closeBrandModal();
    });
</script>
@endsection
