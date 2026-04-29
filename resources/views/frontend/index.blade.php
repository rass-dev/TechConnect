@extends('frontend.layouts.master')
@section('title','TechConnect')
@section('main-content')

<!-- Slider Area -->

@if(count($banners) > 0)
<section id="Gslider" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        @foreach($banners as $key => $banner)
            <li data-target="#Gslider" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
        @endforeach
    </ol>

    <div class="carousel-inner" role="listbox">
        @foreach($banners as $key => $banner)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <img class="first-slide" src="{{ asset($banner->photo) }}" alt="Slide {{ $key + 1 }}">
                <div class="carousel-caption d-none d-md-block text-left">
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
            </div>
        @endforeach
    </div>

    <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</section>
@endif

<!--/ End Slider Area -->

@push('styles')

<style>
/* Banner Sliding */
#Gslider {
    height: 700px; /* fixed height ng buong slider */
    overflow: hidden;
    position: relative;
}

#Gslider .carousel-inner {
    height: 100%;
    background: transparent; /* removed black background */
}

#Gslider .carousel-item {
    height: 100%;
}

#Gslider .carousel-item img {
    width: 100% !important;
    height: 100%;
    object-fit: cover;
    object-position: center center;
    opacity: 1; /* full visibility */
}

#Gslider .carousel-caption {
    bottom: 50%;
    transform: translateY(50%);
    text-align: left;
}

#Gslider .carousel-caption h1 {
    font-size: 55px;
    font-weight: bold;
    line-height: 100%;
    color: #6f42c1;
}

#Gslider .carousel-caption p {
    font-size: 20px;
    color: black;
    margin: 28px 0;
}

#Gslider .carousel-indicators {
    bottom: 20px;
}

/* Dark gradient behind arrows only */
#Gslider .carousel-control-prev,
#Gslider .carousel-control-next {
    width: 80px; /* overlay width */
}

#Gslider .carousel-control-prev::before,
#Gslider .carousel-control-next::before {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    width: 100%;
    z-index: 1;
}

#Gslider .carousel-control-prev::before {
    left: 0;
    background: linear-gradient(to right, rgba(0,0,0,0.4), transparent);
}

#Gslider .carousel-control-next::before {
    right: 0;
    background: linear-gradient(to left, rgba(0,0,0,0.4), transparent);
}

</style>
@endpush


@push('styles')
<style>
    
    /* Uniform category image size */
    .category-link .category-img {
        width: 200px !important;
        height: 150px !important;
        object-fit: cover;
        object-position: center center;
        border-radius: 60%;
        border: 2px solid #e0e0e0;
        display: block;
        margin: 0 auto 100px auto;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    /* Categories Hover Effect */
    .category-link {
        text-decoration: none;
        transition: box-shadow 0.2s, transform 0.2s;
        border-radius: 16px;
        display: block;
        color: inherit;
    }
    .category-link:hover, .category-link:focus {
        box-shadow: 0 4px 16px rgba(111,66,193,0.15);
        background: #f8f5ff;
        transform: translateY(-4px) scale(1.05);
        color: #6f42c1;
    }
    .category-link .category-img {
        border: 2px solid #e0e0e0;
        transition: border-color 0.2s;
    }
    .category-link:hover .category-img, .category-link:focus .category-img {
        border-color: #6f42c1;
    }
</style>


@endpush


<!-- Start Product Area -->

<!-- Categories Section -->
<div class="categories-area section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>CATEGORIES</h2>
                </div>
            </div>
        </div>
        <div class="row d-flex flex-wrap justify-content-center">
            <!-- Example categories, replace src with actual image paths -->
            <a href="{{ route('product-grids', ['category' => 'desktops']) }}" class="category-link col-6 col-sm-4 col-md-3 col-lg-2 mb-4 text-center">
                <img src="uploads/products/Desktop.png" alt="Desktop" class="img-fluid rounded-circle mb-2 category-img">
                <div>Desktop</div>
            </a>
            <a href="{{ route('product-grids', ['category' => 'laptops']) }}" class="category-link col-6 col-sm-4 col-md-3 col-lg-2 mb-4 text-center">
                <img src="uploads/products/Laptop.png" alt="Laptop" class="img-fluid rounded-circle mb-2 category-img">
                <div>Laptop</div>
            </a>
            <a href="{{ route('product-grids', ['category' => 'keyboards']) }}" class="category-link col-6 col-sm-4 col-md-3 col-lg-2 mb-4 text-center">
                <img src="uploads/products/Peripherals.png" alt="Peripherals" class="img-fluid rounded-circle mb-2 category-img">
                <div>Peripherals</div>
            </a>
        </div>
    </div>
</div>
<!-- End Categories Section -->

@push('styles')
<style>
.category-link {
    text-decoration: none;
    color: inherit;
}

.category-img {
    background-color: #fff; /* para mawala yung checkerboard */
    border-radius: 50%;
    object-fit: cover;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.category-link:hover .category-img {
    transform: scale(1.1); /* zoom effect */
    box-shadow: 0 8px 16px rgba(0,0,0,0.2); /* dagdag shadow on hover */
}

.category-link div {
    font-weight: 500;
    margin-top: 5px;
}

</style>
@endpush

<div class="product-area section">
    <div class="container">
        <!-- TITLE -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2>Gadget Accessories Online</h2>
                </div>
            </div>
        </div>

        <!-- NEW PRODUCTS ROW -->
        <div class="product-row position-relative mb-5">
            <h4>NEW</h4>

            @php $newProducts = $product_lists->filter(fn($p) => $p->condition == 'new'); @endphp

            @if($newProducts->isEmpty())
                <div class="no-product">No NEW Products</div>
            @else
                <!-- Left Arrow -->
                <button class="carousel-arrow left" id="new-prev">&lt;</button>

                <div class="carousel-container new-products-carousel d-flex">
                    @foreach($newProducts as $product)
                    <div class="single-product-card">
                        <div class="single-product">
                            <div class="product-img">
                                <a href="{{route('product-detail',$product->slug)}}">
                                    @php $photo=explode(',',$product->photo); @endphp
                                    <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                    <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                    <span class="new">New</span>
                                </a>
                                <div class="button-head">
                                    <div class="product-action">
                                        <a data-toggle="modal" data-target="#{{$product->id}}" title="Quick View" href="#"><i class="ti-eye"></i><span>Quick Shop</span></a>
                                        <a title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
                                    </div>
                                    <div class="product-action-2">
                                        <a title="Add to cart" href="{{route('add-to-cart',$product->slug)}}">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content text-center">
                                <h3><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                                @php $after_discount=($product->price-($product->price*$product->discount)/100); @endphp
                                <div class="product-price">
                                    <span>₱ {{number_format($after_discount,2)}}</span>
                                    <del>₱ {{number_format($product->price,2)}}</del>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Right Arrow -->
                <button class="carousel-arrow right" id="new-next">&gt;</button>
            @endif
        </div>

        <!-- HOT PRODUCTS ROW -->
        <div class="product-row position-relative mb-5">
            <h4>HOT</h4>

            @php $hotProducts = $product_lists->filter(fn($p) => $p->condition == 'hot'); @endphp

            @if($hotProducts->isEmpty())
                <div class="no-product">No HOT Products</div>
            @else
                <button class="carousel-arrow left" id="hot-prev">&lt;</button>

                <div class="carousel-container hot-products-carousel d-flex">
                    @foreach($hotProducts as $product)
                    <div class="single-product-card">
                        <div class="single-product">
                            <div class="product-img">
                                <a href="{{route('product-detail',$product->slug)}}">
                                    @php $photo=explode(',',$product->photo); @endphp
                                    <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                    <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                    <span class="hot">Hot</span>
                                </a>
                                <div class="button-head">
                                    <div class="product-action">
                                        <a data-toggle="modal" data-target="#{{$product->id}}" title="Quick View" href="#"><i class="ti-eye"></i><span>Quick Shop</span></a>
                                        <a title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
                                    </div>
                                    <div class="product-action-2">
                                        <a title="Add to cart" href="{{route('add-to-cart',$product->slug)}}">Add to cart</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content text-center">
                                <h3><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                                @php $after_discount=($product->price-($product->price*$product->discount)/100); @endphp
                                <div class="product-price">
                                    <span>₱ {{number_format($after_discount,2)}}</span>
                                    <del>₱ {{number_format($product->price,2)}}</del>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <button class="carousel-arrow right" id="hot-next">&gt;</button>
            @endif
        </div>
    </div>
</div>

<!-- JS Smooth Scroll -->
<script>
    const scrollCarousel = (carouselSelector, direction) => {
        const carousel = document.querySelector(carouselSelector);
        const cardWidth = carousel.querySelector('.single-product-card')?.offsetWidth || 300;
        carousel.scrollBy({ left: direction * (cardWidth + 20), behavior: 'smooth' });
    }

    document.getElementById('new-prev')?.addEventListener('click', () => scrollCarousel('.new-products-carousel', -1));
    document.getElementById('new-next')?.addEventListener('click', () => scrollCarousel('.new-products-carousel', 1));
    document.getElementById('hot-prev')?.addEventListener('click', () => scrollCarousel('.hot-products-carousel', -1));
    document.getElementById('hot-next')?.addEventListener('click', () => scrollCarousel('.hot-products-carousel', 1));
</script>

<style>
    .product-row {
        position: relative;
    }

    .carousel-container {
        display: flex;
        gap: 20px;
        overflow-x: hidden;z
        scroll-behavior: smooth;
        padding: 10px 40px;
    }

    .single-product-card {
        min-width: 220px;
        height: 360px;
        flex-shrink: 0;
    }

    .single-product img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .carousel-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        background-color: rgba(0,0,0,0.5);
        color: #fff;
        border: none;
        font-size: 1.5rem;
        padding: 10px;
        cursor: pointer;
    }

    .carousel-arrow.left { left: 0; }
    .carousel-arrow.right { right: 0; }

    .carousel-arrow:hover { background-color: rgba(0,0,0,0.7); }

    .no-product {
        text-align: center;
        font-size: 1.2rem;
        color: #888;
        padding: 50px 0;
    }
</style>

<!-- Modal -->
@if($product_lists)
    @foreach($product_lists as $key=>$product)
        <div class="modal fade" id="{{$product->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row no-gutters">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <!-- Product Slider -->
                                        <div class="product-gallery">
                                            <div class="quickview-image-active">
                                                @php 
                                                    $photos = explode(',', $product->photo); 
                                                @endphp
                                                @foreach($photos as $photo)
                                                    <div class="single-slider">
                                                        <img src="{{ asset($photo) }}" alt="Product Image"> 
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    <!-- End Product slider -->
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
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
                                        
                                        <form action="{{route('single-add-to-cart')}}" method="POST" class="mt-4">
                                            @csrf 
                                            <div class="quantity">
                                                <!-- Input Order -->
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
                                                <!--/ End Input Order -->
                                            </div>
                                            <div class="add-to-cart">
                                                <button type="submit" class="btn">Add to cart</button>
                                                <a href="{{route('add-to-wishlist', $product->slug)}}" class="btn min"><i class="ti-heart"></i></a>
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

@push('styles')


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
