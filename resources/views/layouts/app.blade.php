<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crave - Save Food</title>
    
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
</head>
<body class="bg-gray-50 flex flex-col min-h-screen font-sans">

    <!-- Top Navigation Bar (Desktop) -->
    @if(!request()->is('/') && !request()->is('login') && !request()->is('register'))
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Logo -->
                <a href="/home" class="flex items-center text-crave-lime font-extrabold text-3xl">
                    <ion-icon name="leaf" class="mr-2"></ion-icon> Crave
                </a>

                <!-- Desktop Menu -->
                <!-- Desktop Menu -->
                <nav class="hidden md:flex space-x-10 text-gray-600 font-medium text-lg">
                    <a href="/home" class="{{ request()->is('home') ? 'text-crave-darkgreen border-b-2 border-crave-lime' : 'hover:text-crave-lime' }} transition-colors pb-1">Shop</a>
                    <a href="/explore" class="{{ request()->is('explore') ? 'text-crave-darkgreen border-b-2 border-crave-lime' : 'hover:text-crave-lime' }} transition-colors pb-1">Explore</a>
                    <a href="/cart" class="{{ request()->is('cart') ? 'text-crave-darkgreen border-b-2 border-crave-lime' : 'hover:text-crave-lime' }} transition-colors pb-1 flex items-center">
                        Cart 
                        <span class="ml-2 bg-crave-pink text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">2</span>
                    </a>
                    @if(auth()->check() && (Auth::user()->role === 'vendor' || Auth::user()->role === 'admin'))
                    <a href="{{ route('products.index') }}" class="{{ request()->is('products*') ? 'text-crave-darkgreen border-b-2 border-crave-lime' : 'hover:text-crave-lime' }} transition-colors pb-1">Products</a>
                    @endif
                </nav>

                <!-- User Profile / Actions -->
                <div class="flex items-center space-x-6 text-gray-500 text-2xl">
                    <button class="hover:text-crave-pink transition-colors"><ion-icon name="heart-outline"></ion-icon></button>
                    <button class="hover:text-crave-teal transition-colors"><ion-icon name="person-circle-outline"></ion-icon></button>
                </div>
            </div>
        </div>
    </header>
    @endif

    <!-- Main Content Container -->
    <!-- 'max-w-7xl mx-auto' centers the content and prevents it from stretching too wide on massive screens -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Simple Footer -->
    @if(!request()->is('/') && !request()->is('login') && !request()->is('register'))
    <footer class="bg-white border-t border-gray-200 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; 2026 Crave. Saving the planet, one meal at a time.
        </div>
    </footer>
    @endif

</body>
</html>