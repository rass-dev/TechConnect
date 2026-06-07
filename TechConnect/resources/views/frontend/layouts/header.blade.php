<header class="header shop">
    <div class="container">
        <div class="tc-header-inner">
            <div class="header-single-row">
                <!-- Logo -->
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="TechConnect" class="site-logo-img">
                        <span class="logo-brand">Tech<span class="logo-accent">Connect</span></span>
                    </a>
                </div>

                <!-- Navigation (desktop) -->
                <nav class="main-menu d-none d-xl-flex" id="mainMenu" aria-label="Main navigation">
                    <ul class="nav">
                        <li class="{{ Request::path()=='home' ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                        <li class="{{ Request::path()=='about-us' ? 'active' : '' }}"><a href="{{ route('about-us') }}">About Us</a></li>
                        <li class="@if(Request::path()=='product-grids'||Request::path()=='product-lists') active @endif">
                            <a href="{{ route('product-grids') }}">Products</a>
                        </li>
                        <li class="{{ Request::path()=='contact' ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact Us</a></li>
                    </ul>
                </nav>

                <!-- Search (tablet & desktop) -->
                <div class="header-search d-none d-md-flex">
                    <form action="{{ route('product.search') }}" method="POST">
                        @csrf
                        <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" autocomplete="off" maxlength="120">
                        <button type="submit" aria-label="Search"><i class="fa fa-search"></i></button>
                    </form>
                </div>

                <!-- Actions -->
                <div class="header-actions">
                    <a href="{{ route('wishlist') }}" class="hdr-icon-btn wishlist" title="Wishlist">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="tech-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 21l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                                     2 5.42 4.42 3 7.5 3c1.74 0 3.41 1 4.5 2.09
                                     C13.09 4 14.76 3 16.5 3
                                     19.58 3 22 5.42 22 8.5
                                     c0 3.78-3.4 6.86-8.55 11.18L12 21z" />
                        </svg>
                        <span class="total-count">{{ Helper::wishlistCount() }}</span>
                    </a>

                    <a href="{{ route('cart') }}" class="hdr-icon-btn cart" title="Cart">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tech-icon cart-icon">
                            <path d="M7 7V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/>
                            <path d="M5 7h14l-1.4 12H6.4L5 7z"/>
                            <circle cx="9" cy="20" r="1.75" class="cart-wheel"/>
                            <circle cx="15" cy="20" r="1.75" class="cart-wheel"/>
                        </svg>
                        <span class="total-count">{{ Helper::cartCount() }}</span>
                    </a>

                    @auth
                    <div class="user-dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle hdr-user-toggle">
                            <i class="ti-user"></i>
                            <span class="user-name">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown">
                            <li><a href="{{ route('user-profile') }}">Profile</a></li>
                            <li><a href="{{ route('my-orders') }}">My Orders</a></li>
                            <li><a href="{{ route('user.logout') }}">Logout</a></li>
                        </ul>
                    </div>
                    @else
                    <a href="{{ route('login.form') }}" class="hdr-icon-btn hdr-auth-icon d-lg-none" title="Login">
                        <i class="ti-user"></i>
                    </a>
                    <a href="{{ route('login.form') }}" class="hdr-link d-none d-lg-inline">Login</a>
                    <a href="{{ route('register.form') }}" class="btn-register d-none d-lg-inline">Register</a>
                    @endauth

                    <button type="button" class="mobile-menu-toggle d-xl-none" id="mobileMenuToggle" aria-label="Toggle menu" aria-expanded="false">
                        <i class="ti-menu"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Search -->
            <div class="mobile-search d-md-none">
                <form action="{{ route('product.search') }}" method="POST">
                    @csrf
                    <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" maxlength="120">
                    <button type="submit" aria-label="Search"><i class="fa fa-search"></i></button>
                </form>
            </div>

            <!-- Mobile dropdown nav -->
            <nav class="main-menu mobile-nav d-xl-none" id="mobileNav" aria-label="Mobile navigation">
                <ul class="nav">
                    <li class="{{ Request::path()=='home' ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                    <li class="{{ Request::path()=='about-us' ? 'active' : '' }}"><a href="{{ route('about-us') }}">About Us</a></li>
                    <li class="@if(Request::path()=='product-grids'||Request::path()=='product-lists') active @endif">
                        <a href="{{ route('product-grids') }}">Products</a>
                    </li>
                    <li class="{{ Request::path()=='contact' ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact Us</a></li>
                    @guest
                    <li class="mobile-auth-links">
                        <a href="{{ route('login.form') }}">Login</a>
                        <a href="{{ route('register.form') }}" class="mobile-register-link">Register</a>
                    </li>
                    @endguest
                </ul>
            </nav>
        </div>
    </div>
</header>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const header = document.querySelector("header.header");

    function syncHeaderHeight() {
        if (!header) return;
        const height = Math.ceil(header.getBoundingClientRect().height);
        document.documentElement.style.setProperty('--tc-header-h', height + 'px');
    }

    window.addEventListener("scroll", function() {
        header.classList.toggle("scrolled", window.scrollY > 20);
    });

    window.addEventListener("resize", syncHeaderHeight);
    syncHeaderHeight();

    const dropdown = document.querySelector(".user-dropdown");
    if (dropdown) {
        const toggle = dropdown.querySelector(".dropdown-toggle");
        toggle.addEventListener("click", function(e) {
            e.preventDefault();
            dropdown.classList.toggle("open");
        });
        document.addEventListener("click", function(e) {
            if (!dropdown.contains(e.target)) dropdown.classList.remove("open");
        });
    }

    const menuToggle = document.getElementById("mobileMenuToggle");
    const mobileNav = document.getElementById("mobileNav");
    if (menuToggle && mobileNav) {
        menuToggle.addEventListener("click", function(e) {
            e.stopPropagation();
            const isOpen = mobileNav.classList.toggle("open");
            menuToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
            syncHeaderHeight();
        });
        document.addEventListener("click", function(e) {
            if (!mobileNav.contains(e.target) && !menuToggle.contains(e.target)) {
                mobileNav.classList.remove("open");
                menuToggle.setAttribute("aria-expanded", "false");
                syncHeaderHeight();
            }
        });
        mobileNav.querySelectorAll("a").forEach(function(link) {
            link.addEventListener("click", function() {
                mobileNav.classList.remove("open");
                menuToggle.setAttribute("aria-expanded", "false");
                syncHeaderHeight();
            });
        });
    }
});
</script>
