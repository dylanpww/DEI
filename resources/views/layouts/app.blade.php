<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Crave') — Save food, save money</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --green-dark: #1a3c2c;
            --green-mid: #2d6a4f;
            --green-lime: #7bc67e;
            --green-bright: #95d465;
            --yellow: #f5c842;
            --orange: #f4a435;
            --pink: #e8579a;
            --cream: #fdf6ec;
            --white: #ffffff;
            --gray-light: #f5f5f5;
            --gray: #888;
            --text-dark: #1a1a1a;
            --radius: 16px;
            --radius-sm: 10px;
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
            --shadow-hover: 0 8px 32px rgba(0,0,0,0.14);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--cream);
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar {
            background: var(--green-dark);
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 20px rgba(0,0,0,0.2);
        }

        .nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            gap: 20px;
        }

        .nav-logo {
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            font-size: 1.8rem;
            color: var(--green-bright);
            text-decoration: none;
            letter-spacing: -1px;
        }

        .nav-logo span { color: var(--yellow); }

        .nav-search {
            flex: 1;
            max-width: 420px;
            position: relative;
        }

        .nav-search input {
            width: 100%;
            padding: 10px 16px 10px 42px;
            border-radius: 50px;
            border: none;
            background: rgba(255,255,255,0.12);
            color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            outline: none;
            transition: background 0.2s;
        }

        .nav-search input::placeholder { color: rgba(255,255,255,0.5); }
        .nav-search input:focus { background: rgba(255,255,255,0.2); }

        .nav-search .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.5);
            font-size: 1rem;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 8px 14px;
            border-radius: 50px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-link:hover { background: rgba(255,255,255,0.1); color: white; }

        .nav-link.active { color: var(--green-bright); }

        .btn-nav-primary {
            background: var(--green-bright);
            color: var(--green-dark);
            font-weight: 700;
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .btn-nav-primary:hover { background: var(--yellow); transform: translateY(-1px); }

        .cart-badge {
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--pink);
            color: white;
            font-size: 0.65rem;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* MAIN */
        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px;
        }

        /* ALERTS */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            margin-bottom: 16px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .alert-success { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
        .alert-error { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }

        /* BUTTONS */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 50px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--green-bright);
            color: var(--green-dark);
        }

        .btn-primary:hover { background: #82c055; transform: translateY(-2px); box-shadow: 0 4px 16px rgba(149,212,101,0.4); }

        .btn-dark {
            background: var(--green-dark);
            color: white;
        }

        .btn-dark:hover { background: var(--green-mid); transform: translateY(-2px); }

        .btn-outline {
            background: transparent;
            color: var(--green-dark);
            border: 2px solid var(--green-dark);
        }

        .btn-outline:hover { background: var(--green-dark); color: white; }

        .btn-danger { background: #ff4757; color: white; }
        .btn-danger:hover { background: #e84141; }

        .btn-sm { padding: 8px 16px; font-size: 0.82rem; }

        /* PRODUCT CARD */
        .product-card {
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.25s;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-hover); }

        .product-card-img {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            background: var(--gray-light);
        }

        .product-card-img-placeholder {
            width: 100%;
            aspect-ratio: 1;
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
        }

        .product-card-body {
            padding: 14px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-card-category {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--green-mid);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .product-card-name {
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 8px;
            color: var(--text-dark);
            line-height: 1.3;
        }

        .product-card-prices {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: auto;
        }

        .price-original {
            font-size: 0.8rem;
            color: var(--gray);
            text-decoration: line-through;
        }

        .price-discounted {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--green-mid);
        }

        .discount-badge {
            background: var(--pink);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 50px;
            margin-left: auto;
        }

        .product-card-footer {
            padding: 0 14px 14px;
            display: flex;
            gap: 8px;
        }

        .btn-add-cart {
            flex: 1;
            background: var(--green-bright);
            color: var(--green-dark);
            border: none;
            border-radius: 50px;
            padding: 10px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Poppins', sans-serif;
        }

        .btn-add-cart:hover { background: #82c055; transform: translateY(-1px); }

        /* GRID */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        /* SECTION TITLE */
        .section-title {
            font-family: 'Nunito', sans-serif;
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--green-dark);
            margin-bottom: 6px;
        }

        .section-subtitle {
            color: var(--gray);
            font-size: 0.88rem;
            margin-bottom: 20px;
        }

        /* FOOTER */
        footer {
            background: var(--green-dark);
            color: rgba(255,255,255,0.7);
            text-align: center;
            padding: 24px;
            font-size: 0.85rem;
            margin-top: 60px;
        }

        footer strong { color: var(--green-bright); }

        /* FORM */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 6px; color: var(--text-dark); }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e8e8e8;
            border-radius: var(--radius-sm);
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            transition: border 0.2s;
            outline: none;
            background: white;
        }
        .form-control:focus { border-color: var(--green-bright); }
        .form-error { color: #dc3545; font-size: 0.82rem; margin-top: 4px; }

        /* CARD */
        .card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 24px;
        }

        /* STOCK BADGE */
        .stock-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 50px;
        }

        .stock-available { background: #d4edda; color: #155724; }
        .stock-low { background: #fff3cd; color: #856404; }
        .stock-out { background: #f8d7da; color: #721c24; }

        /* DROPDOWN */
        .user-dropdown { position: relative; }
        .user-btn {
            background: rgba(255,255,255,0.1);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 50px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }
        .user-btn:hover { background: rgba(255,255,255,0.18); }
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: white;
            border-radius: var(--radius-sm);
            box-shadow: var(--shadow-hover);
            min-width: 180px;
            overflow: hidden;
        }
        .dropdown-menu::before {
            content: '';
            position: absolute;
            top: -10px;
            left: 0;
            width: 100%;
            height: 10px;
        }
        .user-dropdown:hover .dropdown-menu { display: block; }
        .dropdown-item {
            display: block;
            padding: 12px 18px;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            transition: background 0.15s;
        }
        .dropdown-item:hover { background: var(--gray-light); }
        .dropdown-divider { height: 1px; background: #eee; }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="nav-logo">Cra<span>ve</span></a>

        <form class="nav-search" action="{{ route('home') }}" method="GET">
            <span class="search-icon">🔍</span>
            <input type="text" name="q" placeholder="Search foods..." value="{{ request('q') }}">
        </form>

        <div class="nav-actions">
            <a href="{{ url('#') }}" class="nav-link">Explore</a>

            @auth
                <a href="{{ url('#') }}" class="nav-link cart-badge">
                    🛒 Cart
                    @php $cartCount = 0; // TODO: Implement cart logic @endphp
                    @if($cartCount > 0)
                        <span class="cart-count">{{ $cartCount }}</span>
                    @endif
                </a>

                <div class="user-dropdown">
                    <button class="user-btn">
                        👤 {{ auth()->user()->name }}
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">⚙️ Edit Profile</a>
                        <a href="{{ url('#') }}" class="dropdown-item">📦 My Orders</a>
                        @if(auth()->user()->role === 'seller')
                            <div class="dropdown-divider"></div>
                            <a href="{{ url('#') }}" class="dropdown-item">➕ List Food</a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item" style="width:100%;text-align:left;border:none;background:none;cursor:pointer;">🚪 Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="nav-link">Log in</a>
                <a href="{{ route('register') }}" class="btn-nav-primary">Sign Up</a>
            @endauth
        </div>
    </div>
</nav>

<main>
    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error) {{ $error }}<br> @endforeach
        </div>
    @endif

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

<footer>
    <strong>Crave</strong> — Save your stomach, be an anti-food waste hero! 🌱<br>
    <small style="opacity:0.5;margin-top:4px;display:block;">© {{ date('Y') }} Crave. All rights reserved.</small>
</footer>

@stack('scripts')
</body>
</html>
