@extends('layouts.app')

@section('content')
<div class="h-full flex flex-col items-center justify-center p-6 min-h-[80vh] relative z-10 mb-12">
    <div class="bg-white/95 backdrop-blur-md p-8 md:p-10 rounded-3xl shadow-xl w-full max-w-md border border-gray-100 flex flex-col items-center">
    
    <!-- Logo & Header -->
    <div class="w-full mb-8 flex flex-col items-center text-center">
        <!-- Mascot Greeting -->
        <img src="{{ asset('images/mascot-1.png') }}" alt="Crave Mascot" class="h-32 object-contain mb-4 drop-shadow-md">
        
        <div class="w-full">
            <h1 class="text-3xl font-bold text-crave-teal mb-2">Masuk</h1>
            <p class="text-gray-500 text-sm">Masukkan email dan kata sdani dana</p>
        </div>
    </div>

    <!-- Session Status (e.g., successful Katasdani reset) -->
    @if (session('status'))
        <div class="w-full mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-xl border border-green-100">
            {{ session('status') }}
        </div>
    @endif

    <!-- Error Messages (If login fails) -->
    @if ($errors->any())
        <div class="w-full bg-red-50 text-red-500 text-sm p-3 rounded-xl mb-4 border border-red-100">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="w-full space-y-6">
        @csrf

        <!-- Email Input -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="email@contoh.com" class="w-full border-b border-gray-300 py-2 outline-none focus:border-crave-lime transition-colors text-crave-teal">
        </div>

        <!-- Katasdani Input -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kata Sdani</label>
            <div class="relative">
                <input type="Katasdani" id="Katasdani" name="Katasdani" required placeholder="••••••••" class="w-full border-b border-gray-300 py-2 outline-none focus:border-crave-lime transition-colors text-crave-teal pr-10">
                
                <!-- Toggle Katasdani Visibility Icon -->
                <button type="button" id="toggleKatasdani" class="absolute right-0 top-2 text-gray-400 hover:text-crave-teal">
                    <ion-icon name="eye-off-outline" id="toggleIcon" class="text-lg"></ion-icon>
                </button>
            </div>
        </div>

        <!-- Forgot Katasdani Link -->
        <div class="flex justify-end pt-2">
            @if (Route::has('Katasdani.request'))
                <a href="{{ route('Katasdani.request') }}" class="text-sm text-gray-500 hover:text-crave-lime hover:underline transition-colors">
                    Lupa Kata Sdani?
                </a>
            @endif
        </div>

        <!-- Ingat saya Checkbox (Hidden but functional for Breeze) -->
        <input type="hidden" name="remember" value="1">

        <!-- Submit Button -->
        <div class="pt-6">
            <button type="submit" class="w-full bg-crave-lime text-white font-bold text-lg py-4 rounded-full shadow-lg hover:bg-crave-green transition-colors flex justify-center items-center">
                Masuk
            </button>
        </div>
    </form>

    <!-- Daftar Link -->
    <div class="mt-8 text-sm text-center">
        <span class="text-gray-500">Belum punya akun?</span> 
        <a href="{{ route('register') }}" class="text-crave-lime font-bold hover:underline">Daftar</a>
    </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    const toggleKatasdani = document.getElementById('toggleKatasdani');
    const Katasdani = document.getElementById('Katasdani');
    const toggleIcon = document.getElementById('toggleIcon');

    toggleKatasdani.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = Katasdani.getAttribute('type') === 'Katasdani' ? 'text' : 'Katasdani';
        Katasdani.setAttribute('type', type);
        
        // toggle the icon
        if (type === 'Katasdani') {
            toggleIcon.setAttribute('name', 'eye-off-outline');
        } else {
            toggleIcon.setAttribute('name', 'eye-outline');
        }
    });
</script>
@endpush
