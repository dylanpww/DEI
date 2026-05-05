@extends('layouts.app')

@section('content')
<div class="h-full flex flex-col items-center justify-center p-6 bg-white min-h-[80vh]">
    
    <!-- Logo & Header -->
    <div class="w-full mb-10 flex flex-col items-center">
        <!-- Optional: Small Logo -->
        <div class="text-crave-lime font-extrabold text-3xl mb-6 flex items-center">
            <ion-icon name="leaf" class="mr-2"></ion-icon> Crave
        </div>
        
        <div class="w-full">
            <h1 class="text-3xl font-bold text-crave-teal mb-2">Log In</h1>
            <p class="text-gray-500 text-sm">Enter your emails and password</p>
        </div>
    </div>

    <!-- Session Status (e.g., successful password reset) -->
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
            <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="imshuvo97@gmail.com" class="w-full border-b border-gray-300 py-2 outline-none focus:border-crave-lime transition-colors text-crave-teal">
        </div>

        <!-- Password Input -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <div class="relative">
                <input type="password" name="password" required placeholder="••••••••" class="w-full border-b border-gray-300 py-2 outline-none focus:border-crave-lime transition-colors text-crave-teal pr-10">
                
                <!-- Toggle Password Visibility Icon (Optional UI touch) -->
                <button type="button" class="absolute right-0 top-2 text-gray-400 hover:text-crave-teal">
                    <ion-icon name="eye-off-outline" class="text-lg"></ion-icon>
                </button>
            </div>
        </div>

        <!-- Forgot Password Link -->
        <div class="flex justify-end pt-2">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-gray-500 hover:text-crave-lime hover:underline transition-colors">
                    Forgot Password?
                </a>
            @endif
        </div>

        <!-- Remember Me Checkbox (Hidden but functional for Breeze) -->
        <input type="hidden" name="remember" value="1">

        <!-- Submit Button -->
        <div class="pt-6">
            <button type="submit" class="w-full bg-crave-lime text-white font-bold text-lg py-4 rounded-full shadow-lg hover:bg-crave-green transition-colors flex justify-center items-center">
                Log In
            </button>
        </div>
    </form>

    <!-- Sign Up Link -->
    <div class="mt-8 text-sm text-center">
        <span class="text-gray-500">Don't have an account?</span> 
        <a href="{{ route('register') }}" class="text-crave-lime font-bold hover:underline">Sign Up</a>
    </div>

</div>
@endsection