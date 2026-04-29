@extends('frontend.layouts.master')
@section('title', 'Cart Page')

@section('main-content')

    @php
        $cartItems = Helper::getAllProductFromCart();
    @endphp

    <!-- Breadcrumbs -->
    <div class="breadcrumbs" style="background-color:#EEE9FE;">
        <div class="container">
            <div class="row">
                <div class="col-12"></div>
            </div>
        </div>
    </div>

    <!-- Shopping Cart -->
    <div class="shopping-cart section" style="background-color:#EEE9FE; min-height:80vh;">
        <div class="container py-5 custom-container">

            <!-- Cart Table Header -->
            <div class="cart-table-header row fw-bold py-2 mb-2 border-bottom text-center align-items-center">
                <div class="col-1" style="margin-left: 35px; margin-right: -10px;">
                    <input type="checkbox" id="selectAll" {{ $cartItems->count() > 0 && $cartItems->every(fn($c) => $c->is_checked) ? 'checked' : '' }}>
                </div>
                <div class="col-2" style="margin-right: -50px;">Product</div>
                <div class="col-3">Name</div>
                <div class="col-3" style="margin-left: -35px; margin-right: -75px;">Price</div>
                <div class="col-2">Quantity</div>
                <div class="col-1" style="margin-left: -10px;">Total</div>
                <div class="col-1">Remove</div>
            </div>

            <div id="cart_item_list">
                @if($cartItems->count() > 0)
                    @foreach($cartItems as $cart)
                        @php $photo = explode(',', $cart->product['photo']); @endphp

                        <div class="cart-item row align-items-center py-2 border-bottom bg-white rounded shadow-sm mb-2 mx-0"
                            data-id="{{ $cart->id }}">
                            <!-- Checkbox -->
                            <div class="col-1 text-center">
                                <input type="checkbox" class="cart-checkbox" data-id="{{ $cart->id }}" {{ $cart->is_checked ? 'checked' : '' }}>
                            </div>

                            <!-- Product Image -->
                            <div class="col-2 text-center">
                                <img src="{{ $photo[0] }}" alt="{{ $cart->product['title'] }}" class="img-fluid rounded fixed-img">
                            </div>

                            <!-- Product Name -->
                            <div class="col-3">
                                <a href="{{ route('product-detail', $cart->product['slug']) }}" class="text-dark fw-bold">
                                    {{ $cart->product['title'] }}
                                </a>
                                <p class="text-muted small mb-0">{!! $cart['summary'] !!}</p>
                            </div>

                            <!-- Unit Price -->
                            <div class="col-2 text-center price">
                                <span>₱ {{ number_format($cart['price'], 2, '.', ',') }}</span>
                            </div>

                            <!-- Quantity -->
                            <div class="col-2 text-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <button class="btn btn-outline-primary btn-sm btn-number me-1" data-type="minus">
                                        <i class="ti-minus"></i>
                                    </button>
                                    <input type="text" class="form-control input-number text-center" value="{{ $cart->quantity }}"
                                        data-min="1" data-max="100" style="width:60px;">
                                    <button class="btn btn-outline-primary btn-sm btn-number ms-1" data-type="plus">
                                        <i class="ti-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="col-1 text-center fw-bold cart_single_price">
                                <span>₱ {{ number_format($cart['amount'], 2, '.', ',') }}</span>
                            </div>

                            <!-- Remove -->
                            <div class="col-1 text-center">
                                <a href="{{ route('cart-delete', $cart->id) }}" class="text-danger"><i class="ti-trash"></i></a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div
                        class="cart-item row align-items-center py-4 border-bottom bg-white rounded shadow-sm mb-2 mx-0 text-center">
                        <div class="col-12 text-muted fw-bold text-center py-4">
                            Your cart is currently empty.
                            <a href="{{ route('product-grids') }}" class="text-primary fw-bold">Continue shopping</a>
                        </div>

                    </div>
                @endif
            </div>

            <!-- Coupon & Totals Section -->
            @if($cartItems->count() > 0)
                <div class="row mt-4">
                    <div class="col-lg-6 col-12 mb-3">
                        <div class="card p-3 shadow-sm">
                            <h5>Have a Coupon?</h5>
                            <form action="{{ route('coupon-store') }}" method="POST" class="d-flex mb-3">
                                @csrf
                                <input type="text" name="code" class="form-control me-2" placeholder="Enter coupon code">
                                <button class="btn btn-primary">Apply</button>
                            </form>
                            <form action="{{ route('cart-empty') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100">Empty Cart</button>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-6 col-12 mb-3">
                        <div class="card p-3 shadow-sm">
                            <h5>Order Summary</h5>
                            <ul class="list-unstyled mb-3">
                                <li class="d-flex justify-content-between order_subtotal">
                                    Cart Subtotal:
                                    <span>₱ {{ number_format(Helper::totalCartPrice(), 2, '.', ',') }}</span>
                                </li>
                                @if(session()->has('coupon'))
                                    <li class="d-flex justify-content-between text-success coupon_price"
                                        data-price="{{ Session::get('coupon')['value'] }}">
                                        You Save:
                                        <span>₱ {{ number_format(Session::get('coupon')['value'], 2, '.', ',') }}</span>
                                    </li>
                                @endif
                                @php
                                    $total_amount = Helper::totalCartPrice();
                                    if (session()->has('coupon')) {
                                        $total_amount -= Session::get('coupon')['value'];
                                    }
                                @endphp
                                <li class="d-flex justify-content-between fw-bold" id="order_total_price">
                                    Total:
                                    <span>₱ {{ number_format($total_amount, 2, '.', ',') }}</span>
                                </li>
                            </ul>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('product-grids') }}" class="btn btn-outline-secondary">Continue Shopping</a>
                                <a href="{{ route('checkout') }}" class="btn btn-success">Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>


    <!-- Meta for CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(function () {
                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });

                function formatCurrency(amount) {
                    return '₱ ' + Number(amount).toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }

                function updateCartTotals() {
                    let subtotal = 0;
                    $('#cart_item_list .cart-item').each(function () {
                        let $row = $(this);
                        let qty = parseInt($row.find('.input-number').val()) || 0;
                        let price = parseFloat($row.find('.price span').text().replace(/[₱,]/g, '')) || 0;
                        let total = qty * price;

                        $row.find('.cart_single_price span').text(formatCurrency(total));
                        if ($row.find('.cart-checkbox').is(':checked')) subtotal += total;
                    });

                    let coupon = parseFloat($('.coupon_price').data('price')) || 0;
                    $('.order_subtotal span').text(formatCurrency(subtotal));
                    $('#order_total_price span').text(formatCurrency(subtotal - coupon));
                }

                // Quantity change
                $(document).on('input change', '.input-number', function () {
                    let $input = $(this);
                    let cartId = $input.closest('.cart-item').data('id');
                    let quantity = parseInt($input.val());
                    let min = parseInt($input.attr('data-min')) || 1;
                    let max = parseInt($input.attr('data-max')) || 100;

                    if (quantity < min) quantity = min;
                    if (quantity > max) quantity = max;
                    $input.val(quantity);

                    updateCartTotals();

                    // Send to server
                    $.ajax({
                        url: '/cart/update-quantity/' + cartId,
                        type: 'POST',
                        data: { quantity: quantity },
                        success: function (res) {
                            if (!res.success) alert(res.message || 'Could not update cart.');
                        },
                        error: function (err) {
                            console.error(err.responseText);
                            alert('An error occurred while updating the cart.');
                        }
                    });
                });

                // Plus/Minus
                $(document).on('click', '.btn-number', function () {
                    let $input = $(this).closest('.cart-item').find('.input-number');
                    let currentVal = parseInt($input.val()) || 1;
                    if ($(this).data('type') === 'minus') currentVal--;
                    if ($(this).data('type') === 'plus') currentVal++;
                    $input.val(currentVal).trigger('change');
                });

                // Checkbox changes
                $(document).on('change', '.cart-checkbox, #selectAll', function () {
                    updateCartTotals();
                });

                updateCartTotals();
            });
        </script>
    @endpush

@endsection




@push('styles')
    <style>
        body {
            background-color: #EEE9FE;
        }

        .custom-container {
            max-width: 1400px;
        }

        .fixed-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        .input-number {
            width: 60px;
            text-align: center;
        }

        .btn-number {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--purple);
            color: #fff;
            border: none;
            border-radius: 6px;
            transition: filter 0.2s ease-in-out;
        }

        .btn-number:hover {
            filter: brightness(0.9);
        }

        .btn-number:active {
            filter: brightness(0.85);
        }

        .shopping-cart .btn-primary,
        .shopping-cart .btn-success,
        .shopping-cart .btn-outline-secondary,
        .shopping-cart .btn-outline-danger {
            background: var(--purple) !important;
            border: none !important;
            color: #fff !important;
            font-weight: 500;
            border-radius: 8px !important;
            padding: 10px 15px;
        }

        .shopping-cart .btn-outline-secondary,
        .shopping-cart .btn-outline-danger {
            background: transparent !important;
            color: var(--purple) !important;
            border: 1px solid var(--purple) !important;
        }

        .cart-item .btn-number {
            background: var(--purple);
        }

        .card,
        .cart-item {
            background-color: #fff !important;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease;
        }

        .cart-item:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        }

        .cart-table-header div {
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
                text-align: center;
            }

            .cart-table-header {
                display: none;
            }
        }


        /* Cart Row */
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

        /* Remove the "move up" effect */
        .cart-item:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: none;
        }

        /* Fixed image size */
        .fixed-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Quantity buttons */
        .input-number {
            width: 50px;
        }

        .btn-number {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        /* Table header */
        .cart-table-header div {
            font-size: 0.9rem;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
                text-align: center;
            }

            .cart-item .text-end {
                text-align: center !important;
            }
        }

        /* Modern button style for cart page */
        .shopping-cart .btn-primary,
        .shopping-cart .btn-success,
        .shopping-cart .btn-outline-secondary,
        .shopping-cart .btn-outline-danger {
            background: var(--purple) !important;
            border: none !important;
            color: #fff !important;
            font-weight: 500;
            border-radius: 8px !important;
            padding: 10px 15px;
            transition: filter 0.2s ease-in-out;
        }

        .shopping-cart .btn-primary:hover,
        .shopping-cart .btn-success:hover,
        .shopping-cart .btn-outline-secondary:hover,
        .shopping-cart .btn-outline-danger:hover {
            filter: brightness(0.9);
        }

        .shopping-cart .btn-primary:active,
        .shopping-cart .btn-success:active,
        .shopping-cart .btn-outline-secondary:active,
        .shopping-cart .btn-outline-danger:active {
            filter: brightness(0.85);
        }

        /* Plus/Minus Buttons */
        .cart-item .btn-number {
            background: var(--purple) !important;
            color: #fff !important;
            border-radius: 6px !important;
            border: none !important;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: filter 0.2s ease-in-out;
        }

        .cart-item .btn-number:hover {
            filter: brightness(0.9);
        }

        .cart-item .btn-number:active {
            filter: brightness(0.85);
        }

        /* Apply to all white boxes */
        .white-box,
        .card,
        .cart-item {
            background-color: #fff !important;
            border-radius: 12px !important;
            padding: 20px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease;
        }

        /* Hover effect: only slightly darker shadow, no lift */
        .white-box:hover,
        .card:hover,
        .cart-item:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
            transform: none;
        }

        /* Images inside boxes */
        .white-box img,
        .card img,
        .cart-item img {
            border-radius: 10px;
        }

        /* Example margin for spacing between boxes */
        .white-box {
            margin-bottom: 15px;
        }

        /* Plus/Minus Buttons Container */
        .cart-item .d-flex.justify-content-center.align-items-center {
            gap: 8px;
        }

        /* Optional: make input a bit wider */
        .cart-item .input-number {
            width: 60px;
            text-align: center;
        }

        /* Buttons styling */
        .cart-item .btn-number {
            min-width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            background: var(--purple);
            color: #fff;
            border: none;
            transition: filter 0.2s ease-in-out;
        }

        /* Coupon form spacing */
        .shopping-cart form.d-flex.mb-3 {
            gap: 8px;
        }

        /* Optional: make input take more space */
        .shopping-cart form.d-flex.mb-3 input.form-control {
            flex: 1;
        }

        /* Spacing for 'Have a Coupon?' section */
        .shopping-cart .card h5 {
            margin-bottom: 15px;
            margin-top: 0;
            font-weight: 600;
        }
    </style>
@endpush