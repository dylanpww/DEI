<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Crave - Save Food')</title>
    
    <!-- Tailwind CSS via Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Color Palette Configuration -->
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              crave: {
                beige: '#F4E7CB',
                lime: '#C3DD2A',
                green: '#73C000',
                darkgreen: '#3A7717',
                teal: '#00312C',
                lightyellow: '#FFDF85',
                orange: '#FEB837',
                lightpink: '#FC75C2',
                pink: '#E03690',
                brown: '#5B2C05'
              }
            }
          }
        }
      }
    </script>
    
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 flex flex-col min-h-screen font-sans relative z-0">
    <!-- Global Light Pattern Background -->
    <div class="fixed inset-0 opacity-40 pointer-events-none z-[-1]" style="background-image: url('{{ asset('images/pattern-light.png') }}'); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>

    <!-- Top Navigation Bar (Desktop) -->
    @if(!request()->is('/') && !request()->is('login') && !request()->is('register'))
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Logo -->
                <a href="{{ route('welcome') }}" class="flex items-center">
                    <img src="{{ asset('images/logo-text.png') }}" alt="Crave Logo" class="h-10 object-contain">
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex space-x-10 text-gray-600 font-medium text-lg">
                    <a href="{{ route('explore') }}" class="{{ request()->is('explore') ? 'text-crave-darkgreen border-b-2 border-crave-lime' : 'hover:text-crave-lime' }} transition-colors pb-1">Explore</a>
                    <a href="{{ route('cart') }}" class="{{ request()->is('cart') ? 'text-crave-darkgreen border-b-2 border-crave-lime' : 'hover:text-crave-lime' }} transition-colors pb-1 flex items-center">Cart
    @php
        // Mengambil semua 'quantity' dari tiap item di session cart dan menjumlahkannya
        $totalQty = array_sum(array_column(session('cart', []), 'quantity'));
    @endphp
    @if($totalQty > 0)
        <span class="ml-2 bg-crave-pink text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
            {{ $totalQty }}
        </span>
    @endif
</a>
@auth
        <a href="{{ route('my-transactions') }}" 
   class="{{ request()->routeIs('my-transactions') ? 'text-crave-darkgreen border-b-2 border-crave-lime' : 'hover:text-crave-lime' }} transition-colors pb-1">
    My Transactions
</a>
    @endauth
                    @if(auth()->check() && (Auth::user()->role === 'seller' || Auth::user()->role === 'admin'))
                    <a href="{{ route('products.index') }}" class="{{ request()->is('products*') ? 'text-crave-darkgreen border-b-2 border-crave-lime' : 'hover:text-crave-lime' }} transition-colors pb-1">My Shop</a>
                    @endif
                </nav>

                <!-- User Profile / Actions -->
                <div class="flex items-center space-x-6 text-gray-500 text-2xl">
                    <button class="hover:text-crave-pink transition-colors"><ion-icon name="heart-outline"></ion-icon></button>
                    
                    @auth
                    <!-- User Dropdown Menu -->
                    <div class="relative group">
                        <button class="hover:text-crave-teal transition-colors flex items-center gap-2">
                            <ion-icon name="person-circle-outline"></ion-icon>
                            <span class="text-sm font-medium">{{ auth()->user()->username }}</span>
                        </button>
                        
                        <!-- Dropdown panel -->
                        <div class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-100 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <!-- invisible bridge to prevent losing hover -->
                            <div class="absolute -top-4 left-0 w-full h-4"></div>
                            
                            @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-sm font-bold text-crave-teal bg-crave-lime/10 hover:bg-crave-lime/20 rounded-t-lg">
                                🛡️ Admin Dashboard
                            </a>
                            <div class="border-t border-gray-100"></div>
                            @endif
                            <a href="{{ route('profile.show') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-crave-teal {{ Auth::user()->role !== 'admin' ? 'rounded-t-lg' : '' }}">
                                👤 My Profile
                            </a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-crave-teal">
                                ⚙️ Edit Profile
                            </a>
                            <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-crave-teal">
                                📦 My Orders
                            </a>
                            
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}" class="block m-0">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 rounded-b-lg transition-colors">
                                    🚪 Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="hover:text-crave-teal transition-colors"><ion-icon name="person-circle-outline"></ion-icon></a>
                    @endauth
                </div>
            </div>
        </div>
    </header>
    @endif

    <!-- Main Content Container -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (isset($header))
            <header class="bg-white shadow mb-6 rounded-lg overflow-hidden">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Simple Footer -->
    @if(!request()->is('/') && !request()->is('login') && !request()->is('register'))
    <footer class="mt-auto bg-crave-darkgreen relative overflow-hidden text-white">
        <!-- Dark Pattern Background -->
        <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: url('{{ asset('images/pattern-dark.png') }}'); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 py-8 flex flex-col md:flex-row items-center justify-center gap-6 text-lg font-medium">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-icon.png') }}" alt="Crave Icon" class="h-10 rounded-xl bg-white shadow-sm p-1">
                <span class="text-3xl font-extrabold tracking-tight">Crave</span>
            </div>
            <div class="hidden md:block w-px h-8 bg-white/30"></div>
            <p>&copy; {{ date('Y') }} Crave. Saving the planet, one meal at a time.</p>
        </div>
    </footer>
    @endif

    @stack('scripts')
</body>
</html>