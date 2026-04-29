<header class="header shop">
    <div class="container">
        <div class="header-wrapper d-flex justify-content-between align-items-center">

            <!-- Left: Logo -->
<div class="logo">
    <a href="{{ route('home') }}">
        <img src="{{ asset('images/logo.png') }}" alt="logo">
        <span class="logo-tech">Tech</span><span class="logo-connect">Connect</span>
    </a>
</div>


            <!-- Center: Menu -->
            <nav class="main-menu">
                <ul class="nav">
                    <li class="{{ Request::path()=='home' ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
                    <li class="{{ Request::path()=='about-us' ? 'active' : '' }}"><a href="{{ route('about-us') }}">About Us</a></li>
                    <li class="@if(Request::path()=='product-grids'||Request::path()=='product-lists') active @endif">
                        <a href="{{ route('product-grids') }}">Products</a>
                    </li>
                    <li class="{{ Request::path()=='contact' ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact Us</a></li>
                </ul>
            </nav>

            <!-- Right: User actions -->
            <div class="header-actions d-flex align-items-center">

              <!-- Wishlist -->
<a href="{{ route('wishlist') }}" class="wishlist">
    <!-- Gawin futuristic na heart icon -->
    <svg xmlns="http://www.w3.org/2000/svg" 
         fill="none" viewBox="0 0 24 24" stroke="currentColor" 
         class="tech-icon">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M12 21l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 
                 2 5.42 4.42 3 7.5 3c1.74 0 3.41 1 4.5 2.09
                 C13.09 4 14.76 3 16.5 3
                 19.58 3 22 5.42 22 8.5
                 c0 3.78-3.4 6.86-8.55 11.18L12 21z" />
    </svg>
    <span class="total-count">{{ Helper::wishlistCount() }}</span>
</a>

<!-- Cart -->
<a href="{{ route('cart') }}" class="cart">
    <svg xmlns="http://www.w3.org/2000/svg" 
         viewBox="0 0 24 24" fill="none" stroke="currentColor" 
         stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
         class="tech-icon">
        <!-- Cart body -->
        <path d="M6 6h15l-1.5 9h-13z"></path>
        <!-- Wheels -->
        <circle cx="9" cy="20" r="2"></circle>
        <circle cx="18" cy="20" r="2"></circle>
    </svg>
    <span class="total-count">{{ Helper::cartCount() }}</span>
</a>


<!-- User Dropdown -->
@auth
<div class="user-dropdown">
    <a href="javascript:void(0)" class="dropdown-toggle">
        <i class="ti-user"></i> {{ Auth::user()->name }}
    </a>
    <ul class="dropdown">
        <li><a href="{{ route('user-profile') }}">Profile</a></li>
        <li><a href="{{ route('my-orders') }}">My Orders</a></li>
        <li><a href="{{ route('user.logout') }}">Logout</a></li>
    </ul>
</div>
@else
<a href="{{ route('login.form') }}">Login</a>
<a href="{{ route('register.form') }}">Register</a>
@endauth



            </div>
        </div>
    </div>
</header>


<style>

.tech-icon {
    width: 24px;
    height: 24px;
    stroke: #6f42c1;  
    transition: all 0.3s ease;
}

.header-actions a:hover .tech-icon {
    stroke: #996EF8;
    transform: scale(1.1);
    filter: drop-shadow(0 0 5px rgba(153,110,248,0.7));
}

/* Optional glowing wheels */
.tech-icon circle {
    fill: #6f42c1;
    transition: all 0.3s ease;
}
.header-actions a:hover .tech-icon circle {
    fill: #996EF8;
    filter: drop-shadow(0 0 6px rgba(153,110,248,0.8));
}

/* ==============================
   HEADER BASE
============================== */
header.header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 70px;               
    z-index: 10000;
    background: rgba(255,255,255,0.95);
    display: flex;
    align-items: center;
}

/* Scroll effect */
header.header.scrolled {
    background: #fff;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
}

/* ==============================
   WRAPPER LAYOUT
============================== */
.header-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    height: 100%;
    padding: 0 20px;
    opacity: 0;
    transform: translateY(-20px);
    animation: fadeInDown 0.6s forwards;
}

@keyframes fadeInDown {
    to { opacity: 1; transform: translateY(0); }
}

/* ==============================
   LOGO
============================== */
.header.shop .logo {
    margin-top: 12px;
}
.header.shop .logo .img {
    margin-top: 12px;
}

.header-wrapper .logo {
    display: flex;
    align-items: flex-start; 
}

.header-wrapper .logo img {
    max-height: 40px;          
    margin-right: 8px;        
    transition: all 0.3s ease;
    margin-top: -12px;          
}

.logo span.logo-tech {
    color: #361E6E;            
    font-weight: 700;
    font-size: 22px;
    margin: 0;
    position: relative;
}

.logo span.logo-connect {
    color: #996EF8;             
    font-weight: 700;
    font-size: 22px;
    margin-left: 2px;
    position: relative;
}


/* ==============================
   MAIN MENU
============================== */
.main-menu ul li a {
    text-decoration: none;
    color: #6f42c1 !important;         
    background: #fff;       
    font-weight: 500;
    padding: 5px 12px;
    border-radius: 5px;
    transition: all 0.3s ease;
    display: inline-block;
}

/* Main menu hover & active */
.main-menu ul li a:hover,
.main-menu ul li.active a {
    color: #fff !important;         
    background: #6f42c1 !important;
}

/* Hover & Active */
.main-menu ul li a:hover,
.main-menu ul li.active a {
    color: #fff !important;
    background: #6f42c1 !important;
}

/* Dropdown */
.main-menu ul li ul {
    display: none;
    position: absolute;
    background: #fff;
    border: 1px solid #eee;
    padding: 8px 0;
    border-radius: 5px;
    list-style: none;
}
.main-menu ul li:hover ul {
    display: block;
}
.main-menu ul li ul li a {
    display: block;
    padding: 8px 20px;
    color: #6f42c1;
    background: #fff;
    font-weight: 500;
    transition: all 0.3s ease;
}
.main-menu ul li ul li a:hover {
    color: #fff !important;
    background: #6f42c1 !important;
}

/* ==============================
   HEADER ACTIONS
============================== */
.header-actions {
    display: flex;
    align-items: center;
    gap: 20px;
    height: 100%;
}

.header-actions a {
    display: flex;
    align-items: center;
    position: relative;
    height: 40px;
    color: #333;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}
.header-actions a i {
    margin-right: 5px;
    font-size: 18px;
}

/* Hover effects (huwag isama si span badge!) */
.header-actions a:hover,
.header-actions a:hover i {
    color: #6f42c1;
    transform: scale(1.05);
}

/* Badge counts – fixed na white lagi */
.header-actions .total-count {
    background: #6f42c1;
    color: #fff !important;  
    font-size: 12px;
    font-weight: 600;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    position: absolute;
    right: -10px;
    top: -5px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 2; 
}

/* Hover sa badge – wag mawala, pwede lang mag-glow */
.header-actions a:hover .total-count {
    background: #996EF8; 
    color: #fff !important;  
    transform: scale(1.1);
    filter: drop-shadow(0 0 4px rgba(153,110,248,0.7));
}


/* ==============================
   USER DROPDOWN
============================== */

.user-dropdown .dropdown {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    background: #fff;
    border: 1px solid #eee;
    list-style: none;
    padding: 10px 0;
    min-width: 150px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    z-index: 1000;
}

.user-dropdown.open .dropdown {
    display: block;
}


.user-dropdown {
    position: relative;
    cursor: pointer;
}
.user-dropdown a {
    display: flex;
    align-items: center;
}
.user-dropdown a i.ti-angle-down {
    margin-left: 5px;
}
.user-dropdown .dropdown {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    background: #fff;
    border: 1px solid #eee;
    list-style: none;
    padding: 10px 0;
    min-width: 150px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    z-index: 1000;
}

.user-dropdown .dropdown li {
    padding: 5px 20px;
}
.user-dropdown .dropdown li a {
    color: #333;
    text-decoration: none;
    font-weight: 500;
    display: block;
}
.user-dropdown .dropdown li a:hover {
    color: #996EF8;
}

/* ==============================
   RESPONSIVE
============================== */
@media (max-width: 992px) {
    .header-wrapper {
        flex-direction: column;
        align-items: flex-start;
        height: auto;
        padding: 10px 20px;
    }
    .main-menu ul {
        flex-direction: column;
        width: 100%;
        gap: 10px;
    }
    .header-actions {
        margin-top: 10px;
        flex-wrap: wrap;
    }
    .header-actions a {
        margin: 0 15px 10px 0;
    }
}
</style>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const dropdown = document.querySelector(".user-dropdown");
    const toggle = dropdown.querySelector(".dropdown-toggle");

    toggle.addEventListener("click", function(e) {
        e.preventDefault();
        dropdown.classList.toggle("open");
    });

    // Close when clicking outside
    document.addEventListener("click", function(e) {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove("open");
        }
    });
});
</script>
