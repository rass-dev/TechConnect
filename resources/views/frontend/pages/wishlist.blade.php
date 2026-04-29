@extends('frontend.layouts.master')
@section('title','Wishlist Page')
@section('main-content')

<!-- Breadcrumbs -->
<div class="breadcrumbs" style="background-color:#EEE9FE;">
    <div class="container">
        <div class="row">
            <div class="col-12">
               
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Wishlist Section -->
<div class="shopping-cart section" style="background-color:#EEE9FE; min-height:70vh;">
    <div class="container py-4">
        <div id="wishlist_item_list">
            @if(Helper::getAllProductFromWishlist() && Helper::getAllProductFromWishlist()->count() > 0)
                @foreach(Helper::getAllProductFromWishlist() as $wishlist)
                    @php $photo = explode(',', $wishlist->product['photo']); @endphp
                    <div class="cart-item d-flex align-items-center py-3 border-bottom flex-wrap flex-md-nowrap bg-white rounded shadow-sm mb-2 p-2"
                        data-id="{{ $wishlist->id }}">
                        <!-- Product Image -->
                        <div class="col-2 mb-2 mb-md-0">
                            <img src="{{ $photo[0] }}" alt="{{ $wishlist->product['title'] }}" class="img-fluid fixed-img rounded">
                        </div>

                        <!-- Product Name -->
                        <div class="col-4 mb-2 mb-md-0">
                            <a href="{{ route('product-detail', $wishlist->product['slug']) }}" class="text-dark fw-bold">
                                {{ $wishlist->product['title'] }}
                            </a>
                            <p class="text-muted small mb-0">{!! $wishlist['summary'] !!}</p>
                        </div>

                        <!-- Total / Price -->
                        <div class="col-2 text-center mb-2 mb-md-0 fw-bold cart_single_price">
                            <span>₱ {{ number_format($wishlist['amount'],2) }}</span>
                        </div>

                        <!-- Add to Cart Button -->
                        <div class="col-2 text-center mb-2 mb-md-0">
                            <a href="{{ route('add-to-cart', $wishlist->product['slug']) }}" class="btn btn-primary w-100">Add To Cart</a>
                        </div>

                        <!-- Remove Button -->
                        <div class="col-2 text-end mb-2 mb-md-0">
                            <a href="{{ route('wishlist-delete', $wishlist->id) }}" class="text-danger"><i class="ti-trash"></i></a>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Empty Wishlist Message -->
                <div class="cart-item d-flex align-items-center py-4 border-bottom flex-wrap flex-md-nowrap bg-white rounded shadow-sm mb-2 p-2 text-center">
                    <div class="col-12 text-muted fw-bold">
                        There are no products in your wishlist. 
                        <a href="{{ route('product-grids') }}" style="color:blue;">Continue shopping</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!--/ End Wishlist Section -->

@endsection

@push('styles')
<style>
    body { background-color: #EEE9FE; }

    .cart-item {
        border-radius: 15px;
        padding: 10px;
        background-color: #fff;
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        margin-bottom: 10px;
        transition: box-shadow 0.3s ease;
    }

    .cart-item:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        transform: none;
    }

    .fixed-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
    }

    .btn-primary {
        background: var(--purple) !important;
        border: none !important;
        color: #fff !important;
        font-weight: 500;
        border-radius: 8px !important;
        padding: 10px 15px;
        transition: filter 0.2s ease-in-out;
    }

    .btn-primary:hover { filter: brightness(0.9); }
    .btn-primary:active { filter: brightness(0.85); }

    @media (max-width: 768px) {
        .cart-item {
            flex-direction: column;
            text-align: center;
        }
        .cart-item .text-end {
            text-align: center !important;
        }
        .cart-item .col-2, .cart-item .col-4 {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>
@endpush
