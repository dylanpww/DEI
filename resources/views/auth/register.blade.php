@extends('layouts.app')

@section('content')
<div class="h-full flex flex-col items-center justify-center p-6 min-h-[80vh] relative z-10 mb-12">
    <div class="bg-white/95 backdrop-blur-md p-8 md:p-10 rounded-3xl shadow-xl w-full max-w-md border border-gray-100 flex flex-col items-center">
    
    <!-- Mascot & Header -->
    <div class="w-full mb-8 flex flex-col items-center text-center">
        <!-- Mascot Greeting -->
        <img src="{{ asset('images/mascot-1.png') }}" alt="Crave Mascot" class="h-32 object-contain mb-4 drop-shadow-md">
        
        <h1 class="text-3xl font-bold text-crave-teal mb-2">Sign Up</h1>
        <p class="text-gray-500 text-sm">Enter your credentials to continue</p>
    </div>

    <!-- Error Messages (If validation fails) -->
    @if ($errors->any())
        <div class="w-full bg-red-50 text-red-500 text-sm p-3 rounded-xl mb-4 border border-red-100">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Registration Form -->
    <form method="POST" action="{{ route('register') }}" class="w-full space-y-5">
        @csrf

        <!-- Username Input -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
            <input type="text" name="username" value="{{ old('username') }}" required autofocus class="w-full border-b border-gray-300 py-2 outline-none focus:border-crave-lime transition-colors text-crave-teal">
        </div>

        <!-- Email Input -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border-b border-gray-300 py-2 outline-none focus:border-crave-lime transition-colors text-crave-teal">
        </div>



        <!-- Password Input -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required class="w-full border-b border-gray-300 py-2 outline-none focus:border-crave-lime transition-colors text-crave-teal">
        </div>

        <!-- Confirm Password Input -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" required class="w-full border-b border-gray-300 py-2 outline-none focus:border-crave-lime transition-colors text-crave-teal">
        </div>

        <div class="pt-4">
            <p class="text-xs text-gray-400 text-center mb-6">
                By continuing you agree to our <a href="#" class="text-crave-lime hover:underline">Terms of Service</a> and <a href="#" class="text-crave-lime hover:underline">Privacy Policy</a>.
            </p>

            <button type="submit" class="w-full bg-crave-lime text-white font-bold text-lg py-4 rounded-full shadow-lg hover:bg-crave-green transition-colors">
                Sign Up
            </button>
        </div>
    </form>

    <div class="mt-6 text-sm text-center">
        <span class="text-gray-500">Already have an account?</span> 
        <a href="{{ route('login') }}" class="text-crave-lime font-bold hover:underline">Log In</a>
    </div>

    </div>
</div>
@endsection