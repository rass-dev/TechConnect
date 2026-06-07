<ul class="navbar-nav sidebar tc-admin-sidebar accordion" id="accordionSidebar">

    <a class="sidebar-brand" href="{{ route('admin') }}">
        <div class="sidebar-brand-inner">
            <img src="{{ asset('images/logo.png') }}" alt="TechConnect">
            <div class="sidebar-brand-text">Tech<span class="accent">Connect</span></div>
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
        <a class="nav-link {{ Request::is('admin') ? 'active' : '' }}" href="{{ route('admin') }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Banner</div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBanners"
            aria-expanded="false" aria-controls="collapseBanners">
            <i class="fas fa-image"></i>
            <span>Banners</span>
            <i class="fas fa-chevron-right ml-auto" style="font-size:11px;opacity:0.5;"></i>
        </a>
        <div id="collapseBanners" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Banner Options</h6>
                <a class="collapse-item" href="{{ route('banner.index') }}">All Banners</a>
                <a class="collapse-item" href="{{ route('banner.create') }}">Add Banner</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Shop</div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categoryCollapse"
            aria-expanded="false" aria-controls="categoryCollapse">
            <i class="fas fa-th-large"></i>
            <span>Category</span>
            <i class="fas fa-chevron-right ml-auto" style="font-size:11px;opacity:0.5;"></i>
        </a>
        <div id="categoryCollapse" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Category Options</h6>
                <a class="collapse-item" href="{{ route('category.index') }}">All Categories</a>
                <a class="collapse-item" href="{{ route('category.create') }}">Add Category</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#brandCollapse"
            aria-expanded="false" aria-controls="brandCollapse">
            <i class="fas fa-tags"></i>
            <span>Brands</span>
            <i class="fas fa-chevron-right ml-auto" style="font-size:11px;opacity:0.5;"></i>
        </a>
        <div id="brandCollapse" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Brand Options</h6>
                <a class="collapse-item" href="{{ route('brand.index') }}">All Brands</a>
                <a class="collapse-item" href="{{ route('brand.create') }}">Add Brand</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productCollapse"
            aria-expanded="false" aria-controls="productCollapse">
            <i class="fas fa-box"></i>
            <span>Products</span>
            <i class="fas fa-chevron-right ml-auto" style="font-size:11px;opacity:0.5;"></i>
        </a>
        <div id="productCollapse" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Product Options</h6>
                <a class="collapse-item" href="{{ route('product.index') }}">All Products</a>
                <a class="collapse-item" href="{{ route('product.create') }}">Add Product</a>
            </div>
        </div>
    </li>

    {{-- Orders: replaced broken SVG include with standard FontAwesome icon --}}
    <li class="nav-item {{ Request::is('admin/order*') ? 'active' : '' }}">
        <a class="nav-link {{ Request::is('admin/order*') ? 'active' : '' }}" href="{{ route('order.index') }}">
            <i class="fas fa-shopping-cart"></i>
            <span>Orders</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item {{ Request::is('admin/review*') ? 'active' : '' }}">
        <a class="nav-link {{ Request::is('admin/review*') ? 'active' : '' }}" href="{{ route('review.index') }}">
            <i class="fas fa-star"></i>
            <span>Reviews</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/coupon*') ? 'active' : '' }}">
        <a class="nav-link {{ Request::is('admin/coupon*') ? 'active' : '' }}" href="{{ route('coupon.index') }}">
            <i class="fas fa-ticket-alt"></i>
            <span>Coupon</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
        <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
            <i class="fas fa-users"></i>
            <span>Users</span>
        </a>
    </li>

</ul>

