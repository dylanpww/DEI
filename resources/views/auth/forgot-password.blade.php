@extends('layouts.app')

@section('title', 'Lupa Kata Sandi - Crave')

@section('content')
<div class="h-full flex flex-col items-center justify-center p-6 min-h-[80vh] relative z-10 mb-12">
    <div class="bg-white/95 backdrop-blur-md p-8 md:p-10 rounded-3xl shadow-xl w-full max-w-md border border-gray-100 flex flex-col items-center">
        
        <!-- Logo & Header -->
        <div class="w-full mb-6 flex flex-col items-center text-center">
            <img src="{{ asset('images/mascot-2.png') }}" alt="Crave Mascot" class="h-28 object-contain mb-4 drop-shadow-md">
            <p class="text-gray-500 text-sm">Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="w-full mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-xl border border-green-100 text-center">
                {{ session('status') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="w-full bg-red-50 text-red-500 text-sm p-3 rounded-xl mb-4 border border-red-100">
                <ul class="list-none space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="w-full space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="email@contoh.com" class="w-full border-b border-gray-300 py-2 outline-none focus:border-crave-lime transition-colors text-crave-teal">
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-crave-lime text-white font-bold text-lg py-4 rounded-full shadow-lg hover:bg-crave-green transition-colors flex justify-center items-center">
                    Kirim Tautan Reset
                </button>
            </div>
        </form>

        <div class="mt-8 text-sm text-center">
            <a href="{{ route('login') }}" class="text-crave-teal font-medium hover:text-crave-lime transition-colors flex items-center justify-center gap-2">
                <ion-icon name="arrow-back-outline"></ion-icon> Kembali ke halaman Masuk
            </a>
        </div>
    </div>
</div>
@endsection
