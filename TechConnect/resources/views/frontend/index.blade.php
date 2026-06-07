@extends('frontend.layouts.master')
@section('title','TechConnect')
@section('main-content')

<!-- Slider Area -->

@if(count($banners) > 0)
<section id="Gslider" class="carousel slide" data-ride="carousel" data-interval="4000" data-pause="false" data-wrap="true">
    <ol class="carousel-indicators">
        @foreach($banners as $key => $banner)
            <li data-target="#Gslider" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
        @endforeach
    </ol>

    <div class="carousel-inner" role="listbox">
        @foreach($banners as $key => $banner)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <img class="first-slide" src="{{ asset($banner->photo) }}" alt="Slide {{ $key + 1 }}">
                @if($banner->show_title || $banner->show_description || $banner->show_button)
                <div class="carousel-caption text-left">
                    @if($banner->show_title)
                        <h1>{{ $banner->title }}</h1>
                    @endif
                    @if($banner->show_description)
                        <p>{!! $banner->description !!}</p>
                    @endif
                    @if($banner->show_button)
                        <a class="btn btn-lg ws-btn wow fadeInUpBig"
                           href="{{ $banner->button_url ?: route('product-grids') }}" role="button">
                            Shop Now <i class="far fa-arrow-alt-circle-right"></i>
                        </a>
                    @endif
                </div>
                @endif
            </div>
        @endforeach
    </div>

    <a class="carousel-control-prev carousel-fade-nav" href="#Gslider" role="button" data-slide="prev">
        <span class="carousel-fade-arrow" aria-hidden="true"><i class="fa fa-chevron-left"></i></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next carousel-fade-nav" href="#Gslider" role="button" data-slide="next">
        <span class="carousel-fade-arrow" aria-hidden="true"><i class="fa fa-chevron-right"></i></span>
        <span class="sr-only">Next</span>
    </a>
</section>
@endif

<!--/ End Slider Area -->

@push('styles')

<style>
/* Banner Carousel */
#Gslider {
    min-height: 520px;
    height: 75vh;
    max-height: 820px;
    overflow: hidden;
    position: relative;
    background: #EDE8FF;
}

#Gslider .carousel-inner,
#Gslider .carousel-item {
    height: 100%;
}

#Gslider .carousel-item {
    background: #EDE8FF;
}

#Gslider .carousel-item img {
    width: 100% !important;
    height: 100%;
    object-fit: contain;
    object-position: center center;
}

#Gslider .carousel-indicators {
    bottom: 16px;
    margin-bottom: 0;
}

#Gslider .carousel-indicators li {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(110, 67, 193, 0.35);
    border: none;
}

#Gslider .carousel-indicators li.active {
    background: #6E43C1;
    width: 24px;
    border-radius: 4px;
}

/* Hover fade navigation — no circular buttons */
#Gslider .carousel-fade-nav {
    width: 90px;
    height: 100%;
    top: 0;
    bottom: 0;
    transform: none;
    opacity: 0;
    transition: opacity 0.35s ease;
    background: transparent;
    border: none;
    display: flex;
    align-items: center;
    z-index: 10;
}

#Gslider:hover .carousel-fade-nav {
    opacity: 1;
}

#Gslider .carousel-control-prev.carousel-fade-nav {
    left: 0;
    justify-content: flex-start;
    padding-left: 12px;
    background: linear-gradient(to right, rgba(54, 30, 110, 0.35) 0%, rgba(54, 30, 110, 0.08) 60%, transparent 100%);
}

#Gslider .carousel-control-next.carousel-fade-nav {
    right: 0;
    justify-content: flex-end;
    padding-right: 12px;
    background: linear-gradient(to left, rgba(54, 30, 110, 0.35) 0%, rgba(54, 30, 110, 0.08) 60%, transparent 100%);
}

#Gslider .carousel-fade-arrow {
    color: #fff;
    font-size: 28px;
    text-shadow: 0 2px 12px rgba(0, 0, 0, 0.4);
    line-height: 1;
    background: none;
    width: auto;
    height: auto;
}

#Gslider .carousel-fade-nav:hover .carousel-fade-arrow {
    transform: scale(1.15);
    transition: transform 0.2s ease;
}

@media (max-width: 991px) {
    #Gslider {
        min-height: 400px;
        height: 55vh;
        max-height: 600px;
    }
    #Gslider .carousel-fade-nav {
        width: 60px;
        opacity: 1;
    }
}

@media (max-width: 767px) {
    #Gslider {
        min-height: 280px;
        height: 45vh;
        max-height: 480px;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#Gslider').carousel({
        interval: 4500,
        pause: 'hover',
        wrap: true,
        ride: 'carousel'
    });
});
</script>
@endpush


<!-- Start Product Area -->

<!-- Features Bar -->
<div class="container">
    <div class="features-bar">
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon"><i class="fa fa-truck"></i></div>
                <div>
                    <h5>Free Shipping</h5>
                    <p>On orders over ₱5,000</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa fa-shield"></i></div>
                <div>
                    <h5>Secure Payment</h5>
                    <p>100% protected checkout</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa fa-headphones"></i></div>
                <div>
                    <h5>24/7 Support</h5>
                    <p>Dedicated customer care</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa fa-refresh"></i></div>
                <div>
                    <h5>Easy Returns</h5>
                    <p>7-day return policy</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categories Section -->
<div class="categories-area section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Shop by Category</h2>
                    <p class="section-subtitle">Find the perfect components for your setup</p>
                </div>
            </div>
        </div>
        <div class="category-grid">
            <a href="{{ route('product-grids', ['category' => 'desktops']) }}" class="category-card">
                <div class="category-img-wrap">
                    <img src="uploads/products/Desktop.png" alt="Desktop">
                </div>
                <span class="category-name">Desktop</span>
                <span class="category-cta">Shop now &rarr;</span>
            </a>
            <a href="{{ route('product-grids', ['category' => 'laptops']) }}" class="category-card">
                <div class="category-img-wrap">
                    <img src="uploads/products/Laptop.png" alt="Laptop">
                </div>
                <span class="category-name">Laptop</span>
                <span class="category-cta">Shop now &rarr;</span>
            </a>
            <a href="{{ route('product-grids', ['category' => 'keyboards']) }}" class="category-card">
                <div class="category-img-wrap">
                    <img src="uploads/products/Peripherals.png" alt="Peripherals">
                </div>
                <span class="category-name">Peripherals</span>
                <span class="category-cta">Shop now &rarr;</span>
            </a>
        </div>
    </div>
</div>
<!-- End Categories Section -->

<div class="product-area section" style="padding: 24px 0; margin: 0; overflow: visible;">
    <div class="container">
        <!-- TITLE -->
        <div class="row" style="margin-bottom: 24px;">
            <div class="col-12">
                <div class="section-title text-center" style="margin: 0;">
                    <h2 style="margin: 0;">Trending Products</h2>
                    <p class="section-subtitle">Hand-picked PC parts and accessories</p>
                </div>
            </div>
        </div>

        <!-- NEW PRODUCTS ROW -->
        <div class="product-row position-relative">
            <h4 style="margin-bottom: 16px; margin-top: 0;">NEW</h4>

            @php $newProducts = $product_lists->filter(fn($p) => $p->condition == 'new'); @endphp

            @if($newProducts->isEmpty())
                <div class="no-product">No NEW Products</div>
            @else
                <!-- Carousel wrapper with arrows -->
                <div class="carousel-wrapper">
                    <!-- Left Arrow -->
                    <button class="carousel-arrow left" id="new-prev">&lt;</button>

                    <div class="carousel-container new-products-carousel d-flex">
                    @foreach($newProducts as $product)
                    <div class="single-product-card">
                        <div class="single-product">
                            <div class="product-img">
                                <a href="{{route('product-detail',$product->slug)}}">
                                    @php
                                        $photos = array_filter(explode(',', $product->photo));
                                        $imgSrc = !empty($photos) ? asset(trim($photos[0])) : asset('images/logo.png');
                                    @endphp
                                    <div class="product-image-container">
                                        <img class="product-image default-img" src="{{ $imgSrc }}" alt="{{$product->title}}" onerror="this.onerror=null;this.src='{{ asset('images/logo.png') }}';">
                                        <span class="new">New</span>
                                    </div>
                                </a>
                            </div>
                            <div class="product-content">
                                <h3><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                                @php $after_discount=($product->price-($product->price*$product->discount)/100); @endphp
                                <div class="product-price">
                                    <span>₱ {{number_format($after_discount,2)}}</span>
                                    <del>₱ {{number_format($product->price,2)}}</del>
                                </div>
                                <div class="product-card-actions">
                                    <a class="pca-icon" data-toggle="modal" data-target="#{{$product->id}}" title="Quick View" href="#"><i class="ti-eye"></i></a>
                                    <a class="pca-icon" title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}"><i class="ti-heart"></i></a>
                                    <a class="pca-cart" title="Add to cart" href="{{route('add-to-cart',$product->slug)}}">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>

                    <!-- Right Arrow -->
                    <button class="carousel-arrow right" id="new-next">&gt;</button>
                </div>
            @endif
        </div>

        <!-- HOT PRODUCTS ROW -->
        <div class="product-row position-relative">
            <h4 style="margin-bottom: 16px; margin-top: 0;">HOT</h4>

            @php $hotProducts = $product_lists->filter(fn($p) => $p->condition == 'hot'); @endphp

            @if($hotProducts->isEmpty())
                <div class="no-product">No HOT Products</div>
            @else
                <!-- Carousel wrapper with arrows -->
                <div class="carousel-wrapper">
                    <button class="carousel-arrow left" id="hot-prev">&lt;</button>

                    <div class="carousel-container hot-products-carousel d-flex">
                    @foreach($hotProducts as $product)
                    <div class="single-product-card">
                        <div class="single-product">
                            <div class="product-img">
                                <a href="{{route('product-detail',$product->slug)}}">
                                    @php
                                        $photos = array_filter(explode(',', $product->photo));
                                        $imgSrc = !empty($photos) ? asset(trim($photos[0])) : asset('images/logo.png');
                                    @endphp
                                    <div class="product-image-container">
                                        <img class="product-image default-img" src="{{ $imgSrc }}" alt="{{$product->title}}" onerror="this.onerror=null;this.src='{{ asset('images/logo.png') }}';">
                                        <span class="hot">Hot</span>
                                    </div>
                                </a>
                            </div>
                            <div class="product-content">
                                <h3><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                                @php $after_discount=($product->price-($product->price*$product->discount)/100); @endphp
                                <div class="product-price">
                                    <span>₱ {{number_format($after_discount,2)}}</span>
                                    <del>₱ {{number_format($product->price,2)}}</del>
                                </div>
                                <div class="product-card-actions">
                                    <a class="pca-icon" data-toggle="modal" data-target="#{{$product->id}}" title="Quick View" href="#"><i class="ti-eye"></i></a>
                                    <a class="pca-icon" title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}"><i class="ti-heart"></i></a>
                                    <a class="pca-cart" title="Add to cart" href="{{route('add-to-cart',$product->slug)}}">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>

                    <button class="carousel-arrow right" id="hot-next">&gt;</button>
                </div>
            @endif
        </div>

        <!-- CTA Banner -->
        <div class="cta-banner">
            <h3>Build Your Dream PC Today</h3>
            <p>Browse our full catalog of premium components, peripherals, and accessories.</p>
            <a href="{{ route('product-grids') }}" class="btn-modern">Explore All Products <i class="fa fa-arrow-right"></i></a>
        </div>
    </div>
</div>

<!-- JS Smooth Scroll -->
<script>
    const scrollCarousel = (carouselSelector, direction) => {
        const carousel = document.querySelector(carouselSelector);
        if (!carousel) return;
        const cardWidth = carousel.querySelector('.single-product-card')?.offsetWidth || 280;
        const gap = 24;
        carousel.scrollBy({ left: direction * (cardWidth + gap), behavior: 'smooth', block: 'nearest' });
    }

    document.getElementById('new-prev')?.addEventListener('click', (e) => {
        e.preventDefault();
        scrollCarousel('.new-products-carousel', -1);
    });
    document.getElementById('new-next')?.addEventListener('click', (e) => {
        e.preventDefault();
        scrollCarousel('.new-products-carousel', 1);
    });
    document.getElementById('hot-prev')?.addEventListener('click', (e) => {
        e.preventDefault();
        scrollCarousel('.hot-products-carousel', -1);
    });
    document.getElementById('hot-next')?.addEventListener('click', (e) => {
        e.preventDefault();
        scrollCarousel('.hot-products-carousel', 1);
    });
</script>

<style>
    .product-row {
        position: relative;
        padding: 0;
        margin: 0;
        overflow: visible;
        display: flex;
        flex-direction: column;
    }

    .product-row h4 {
        margin: 0 0 16px 0;
        padding: 0;
        font-size: 18px;
        font-weight: 600;
        color: #1f2340;
        line-height: 1;
        text-align: center;
    }

    .product-row + .product-row {
        margin-top: 32px;
    }

    .carousel-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        overflow: visible;
        gap: 12px;
        padding: 0;
        contain: layout style paint;
        will-change: scroll-position;
        height: fit-content;
        width: 100%;
        box-sizing: border-box;
        margin: 0 auto;
    }

    .carousel-container {
        display: flex;
        gap: 24px;
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: smooth;
        scroll-padding: 0;
        padding: 0 20px;
        flex: 1 0 auto;
        height: fit-content;
        -ms-overflow-style: none;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
        margin: 0;
    }

    .carousel-container::-webkit-scrollbar {
        display: none;
        height: 0;
    }

    .single-product-card {
        width: 280px;
        min-width: 280px;
        max-width: 280px;
        flex: 0 0 280px;
        scroll-snap-align: start;
        scroll-snap-stop: always;
        display: flex;
        margin-bottom: 16px;
    }

    .single-product-card .single-product {
        display: flex;
        flex-direction: column;
        width: 100%;
        flex: 1;
    }

    .single-product-card .product-img {
        position: relative;
        overflow: hidden;
    }

    .single-product-card .product-image-container {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .single-product-card .product-image-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        object-position: center;
        display: block;
        transition: opacity 0.3s ease;
    }

    .single-product-card .product-content {
        text-align: left;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .single-product-card .product-content h3 {
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
    }

    .single-product-card .product-content h3 a {
        color: inherit;
        text-decoration: none;
    }

    .single-product-card .product-content h3 a:hover {
        color: #7f5afb;
    }

    .single-product-card .product-price {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: auto;
    }

    .single-product-card .product-price span {
        font-size: 16px;
        font-weight: 700;
        color: #1f2340;
    }

    .single-product-card .product-price del {
        color: #a0a9c9;
        font-size: 14px;
        font-weight: 500;
    }

    .carousel-arrow {
        position: static;
        top: auto;
        transform: none;
        z-index: 20;
        background-color: rgba(127, 90, 251, 0.9);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 40px;
        min-width: 40px;
        max-width: 40px;
        height: 40px;
        min-height: 40px;
        max-height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        padding: 0;
        flex-shrink: 0;
        flex-grow: 0;
        outline: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        vertical-align: middle;
    }

    .carousel-arrow:focus {
        outline: none;
        background-color: rgba(127, 90, 251, 1);
    }

    .carousel-arrow:hover {
        background-color: rgba(127, 90, 251, 1);
    }

    .carousel-arrow:active {
        background-color: rgba(127, 90, 251, 0.85);
    }

    .carousel-arrow.left {
        order: -1;
    }

    .carousel-arrow.right {
        order: 1;
    }

    .no-product {
        text-align: center;
        font-size: 1.2rem;
        color: #888;
        padding: 24px 20px;
    }

    @media (max-width: 991px) {
        .carousel-container {
            max-width: 580px;
            padding: 0 12px;
            gap: 18px;
        }

        .single-product-card {
            width: calc(50% - 12px);
            min-width: calc(50% - 12px);
            max-width: calc(50% - 12px);
        }
    }

    @media (max-width: 767px) {
        .carousel-container {
            max-width: 100%;
            padding: 0 12px;
            gap: 16px;
        }

        .single-product-card {
            width: 100%;
            min-width: 100%;
            max-width: 100%;
        }
    }
</style>

<!-- Modal -->
@if($product_lists)
    @foreach($product_lists as $key=>$product)
        <div class="modal fade product-quickview" id="{{$product->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row no-gutters">
                                <div class="col-lg-6 col-md-12 qv-image-col">
                                    <div class="product-gallery">
                                        <div class="quickview-image-active quickview-slider-active">
                                            @php $photos = array_filter(explode(',', $product->photo)); @endphp
                                            @foreach($photos as $photo)
                                                <div class="single-slider">
                                                    <img src="{{ asset(trim($photo)) }}" alt="{{ $product->title }}" onerror="this.onerror=null;this.src='{{ asset('images/logo.png') }}';">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="quickview-content">
                                        <h2>{{$product->title}}</h2>
                                        <div class="quickview-ratting-review">
                                            <div class="quickview-ratting-wrap">
                                                <div class="quickview-ratting">
                                                    @php
                                                        $rate = DB::table('product_reviews')->where('product_id', $product->id)->avg('rate');
                                                        $rate_count = DB::table('product_reviews')->where('product_id', $product->id)->count();
                                                    @endphp
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($rate >= $i)
                                                            <i class="yellow fa fa-star"></i>
                                                        @else 
                                                            <i class="fa fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <a href="#"> ({{$rate_count}} customer review)</a>
                                            </div>
                                            <div class="quickview-stock">
                                                @if($product->stock > 0)
                                                <span><i class="fa fa-check-circle-o"></i> {{$product->stock}} in stock</span>
                                                @else 
                                                <span><i class="fa fa-times-circle-o text-danger"></i> {{$product->stock}} out of stock</span>
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                                        @endphp
                                        <h3><small><del class="text-muted">₱ {{number_format($product->price, 2)}}</del></small>    ₱ {{number_format($after_discount, 2)}}  </h3>
                                        <div class="quickview-peragraph">
                                            <p>{!! html_entity_decode($product->summary) !!}</p>
                                        </div>
                                        
                                        <form action="{{route('single-add-to-cart')}}" method="POST" class="qv-actions">
                                            @csrf
                                            <div class="quantity">
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                            <i class="ti-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="slug" value="{{$product->slug}}">
                                                    <input type="text" name="quant[1]" class="input-number" data-min="1" data-max="1000" value="1">
                                                    <div class="button plus">
                                                        <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                            <i class="ti-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to-cart">
                                                <button type="submit" class="btn">Add to Cart</button>
                                                <a href="{{route('add-to-wishlist', $product->slug)}}" class="btn min" title="Add to Wishlist"><i class="ti-heart"></i></a>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    @endforeach
@endif
<!-- Modal end -->
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        
        /*==================================================================
        [ Isotope ]*/
        var $topeContainer = $('.isotope-grid');
        var $filter = $('.filter-tope-group');

        // filter items on button click
        $filter.each(function () {
            $filter.on('click', 'button', function () {
                var filterValue = $(this).attr('data-filter');
                $topeContainer.isotope({filter: filterValue});
            });
            
        });

        // init Isotope
        $(window).on('load', function () {
            var $grid = $topeContainer.each(function () {
                $(this).isotope({
                    itemSelector: '.isotope-item',
                    layoutMode: 'fitRows',
                    percentPosition: true,
                    animationEngine : 'best-available',
                    masonry: {
                        columnWidth: '.isotope-item'
                    }
                });
            });
        });

        var isotopeButton = $('.filter-tope-group button');

        $(isotopeButton).each(function(){
            $(this).on('click', function(){
                for(var i=0; i<isotopeButton.length; i++) {
                    $(isotopeButton[i]).removeClass('how-active1');
                }

                $(this).addClass('how-active1');
            });
        });
    </script>
    <script>
         function cancelFullScreen(el) {
            var requestMethod = el.cancelFullScreen||el.webkitCancelFullScreen||el.mozCancelFullScreen||el.exitFullscreen;
            if (requestMethod) { // cancel full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        function requestFullScreen(el) {
            // Supports most browsers and their versions.
            var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
            return false
        }
    </script>

@endpush
