@extends('frontend.layouts.master')

@section('title', 'Checkout page')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">Checkout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <section class="shop checkout section">
        <div class="container">
            @php
                $user = auth()->user();
                $selectedItems = \App\Models\Cart::where('user_id', $user->id)
                    ->where('is_checked', 1)
                    ->whereNull('order_id')
                    ->get();
                $subtotal = $selectedItems->sum('amount');
                $coupon_value = session('coupon')['value'] ?? 0;
            @endphp

            <form class="form" method="POST" action="{{ route('cart.order') }}">
                @csrf

                <div class="checkout-flex">

                    <!-- Left column: Checkout Info + Products -->
                    <div class="checkout-left">

                        <!-- Checkout Information -->
                        <div class="rounded-card">
                            <h2>Checkout Information</h2>
                            <p>Review your details before placing the order.</p>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Full Name:</label>
                                    <p class="input-box">{{ $user->name }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Email Address:</label>
                                    <p class="input-box">{{ $user->email }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Contact Number:</label>
                                    <p class="input-box">{{ $user->contact_number ?? 'N/A' }}</p>
                                </div>
                                <div class="form-group">
                                    <label>Postal Code:</label>
                                    <p class="input-box">{{ $user->postal_code ?? 'N/A' }}</p>
                                </div>
                                <div class="form-group full-width">
                                    <label>Address:</label>
                                    @if($user->address)
                                        <p class="input-box address-box">{{ $user->address }}</p>
                                    @else
                                        <p class="input-box address-box text-danger">
                                            No address found. You must add an address to proceed.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Products for Checkout -->
                        <div class="rounded-card product-summary">
                            <h2>Products for Checkout</h2>
                            <div class="product-list">
                                @foreach($selectedItems as $item)
                                    <a href="{{ route('product-detail', $item->product->slug) }}" class="product-card-link">
                                        <div class="product-card">
                                            <div class="product-img">
                                                <img src="{{ $item->product->photo }}" alt="{{ $item->product->title }}">
                                            </div>
                                            <div class="product-details">
                                                <h4>{{ $item->product->title }}</h4>
                                                <p>₱ {{ number_format($item->price, 2) }} x {{ $item->quantity }}</p>
                                            </div>
                                            <div class="product-total">
                                                ₱ {{ number_format($item->amount, 2) }}
                                            </div>
                                        </div>
                                    </a>
                                @endforeach

                            </div>
                        </div>

                    </div>

                    <!-- Right column: Cart Totals -->
                    <div class="checkout-right">
                        <div class="rounded-card cart-totals">
                            <h2>CART TOTALS</h2>
                            <div class="content">
                                <ul>
                                    <li>
                                        <span>Cart Subtotal</span>
                                        <span>₱ {{ number_format($subtotal, 2) }}</span>
                                    </li>
                                    @if($coupon_value)
                                        <li class="discount">
                                            <span>You Save</span>
                                            <span>- ₱ {{ number_format($coupon_value, 2) }}</span>
                                        </li>
                                    @endif
                                    <li>
                                        <span>Shipping Fee</span>
                                        <span id="shipping-fee">₱ 0.00</span>
                                    </li>
                                    <li class="total">
                                        <span>Total</span>
                                        <span id="grand-total">₱
                                            {{ number_format($subtotal - $coupon_value, 2, '.', ',') }}</span>
                                    </li>
                                </ul>
                            </div>

                            <select name="shipping_id" id="shipping-select" required>
                                @foreach(App\Models\Shipping::all() as $ship)
                                    <option value="{{ $ship->id }}" data-price="{{ $ship->price }}">
                                        {{ $ship->title }} - ₱ {{ $ship->price }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="single-widget">
                                <h2>Payment Method</h2>
                                <div class="content">
                                    <div class="checkbox">
                                        <input name="payment_method" type="radio" value="cod" required>
                                        <label>Cash On Delivery</label><br>
                                        <input name="payment_method" type="radio" value="paypal" required>
                                        <label>PayPal</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Rounded Proceed Button -->
                            <div class="single-widget get-button mt-3">
                                @if(!$user->address)
                                    <button type="button" class="btn btn-danger btn-pill" disabled>
                                        Add Address to Proceed
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-primary btn-pill">Proceed to Checkout</button>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>

                <input type="hidden" name="cart_ids" value="{{ $selectedItems->pluck('id')->implode(',') }}">
            </form>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .btn-pill {
            width: 100%;
            padding: 14px 0;
            font-size: 16px;
            font-weight: 600;
            border-radius: 50px;
            text-transform: uppercase;
            background: #986FF8;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button.btn-pill {
            border-radius: 5px !important;
            /* override bootstrap */
        }



        .btn-pill:hover {
            background: #8559e0;
            transform: scale(1.02);
        }

        .btn-pill.btn-danger {
            background: #FF5B5B;
        }

        .btn-pill.btn-danger:hover {
            background: #e04848;
        }

        .btn-pill:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Flex container for equal height columns */
        .checkout-flex {
            display: flex;
            gap: 20px;
            align-items: stretch;
        }

        .checkout-left {
            flex: 2;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .checkout-right {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Rounded card style */
        .rounded-card {
            background: #fff;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .rounded-card h2 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        /* Checkout info form */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .input-box {
            min-height: 28px;
            /* smaller */
            padding: 6px 10px;
            /* smaller padding */
            font-size: 13px;
            display: flex;
            align-items: center;
            border-radius: 8px;
            /* slightly smaller rounding */
            background: #f9f9f9;
            color: #333;
        }

        .address-box {
            min-height: 50px;
            /* smaller than 60px */
            align-items: flex-start;
            padding-top: 4px;
            line-height: 1.3;
        }

        .rounded-card .form-group label {
            display: block;
            margin-bottom: 2px;
            /* very tight */
            font-weight: 500;
            font-size: 13px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            /* tighter spacing */
        }


        /* Cart Totals */
        .cart-totals ul {
            list-style: none;
            padding: 0;
            margin: 0 0 15px 0;
        }

        .cart-totals ul li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 12px;
            background: #f5f5ff;
            font-size: 15px;
            font-weight: 500;
            color: #333;
        }

        .cart-totals ul li.total {
            background: #986FF8;
            color: #fff;
            font-weight: 700;
            font-size: 17px;
        }

        .cart-totals ul li.discount {
            background: #fdeaea;
            color: #e04848;
        }

        /* Product Summary */
        .product-summary .product-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 0;
        }

        .product-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f5f5ff;
            padding: 12px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .product-card:hover {
            transform: scale(1.02);
        }

        .product-img img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product-details {
            flex: 1;
            margin-left: 12px;
        }

        .product-details h4 {
            font-size: 15px;
            font-weight: 600;
            margin: 0 0 4px;
        }

        .product-details p {
            margin: 0;
            font-size: 13px;
            color: #555;
        }

        .product-total {
            font-weight: 700;
            font-size: 15px;
            color: #333;
        }

        /* Clickable product card */
        .product-card-link {
            text-decoration: none;
            color: inherit;
        }

        /* Responsive */
        @media (max-width:991px) {
            .checkout-flex {
                flex-direction: column;
            }

            .checkout-right {
                order: -1;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush





@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const shippingSelect = document.getElementById('shipping-select');
            const shippingFeeEl = document.getElementById('shipping-fee');
            const grandTotalEl = document.getElementById('grand-total');
            let subtotal = {{ $subtotal - $coupon_value }};

            function updateTotals() {
                const selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
                const shippingPrice = parseFloat(selectedOption.dataset.price || 0);
                shippingFeeEl.textContent = '₱ ' + shippingPrice.toFixed(2);
                grandTotalEl.textContent = '₱ ' + (subtotal + shippingPrice).toFixed(2);
            }

            shippingSelect.addEventListener('change', updateTotals);
            updateTotals();
        });
    </script>
    <script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.shipping select[name=shipping]').change(function () {
                let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
                let subtotal = parseFloat($('.order_subtotal').data('price'));
                let coupon = parseFloat($('.coupon_price').data('price')) || 0;
                $('#order_total_price span').text('₱' + (subtotal + cost - coupon).toFixed(2));
            });
        });
    </script>

@endpush