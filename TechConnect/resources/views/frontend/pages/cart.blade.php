@extends('frontend.layouts.master')
@section('title', 'Cart Page')

@section('main-content')

    @php
        $cartItems = Helper::getAllProductFromCart();
    @endphp

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="bread-inner">
                <ul class="bread-list">
                    <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                    <li class="active"><a href="javascript:void(0);">Shopping Cart</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Shopping Cart -->
    <section class="tc-cart-page section">
        <div class="container">
            <div class="tc-cart-page-header">
                <h1>Shopping Cart</h1>
                <p>{{ $cartItems->count() }} {{ Str::plural('item', $cartItems->count()) }} in your cart</p>
            </div>

            @if($cartItems->count() > 0)
                <div class="tc-cart-table">
                    <div class="tc-cart-table-head">
                        <div class="tc-cart-col-check">
                            <label class="tc-checkbox-wrap" title="Select all">
                                <input type="checkbox" id="selectAll" {{ $cartItems->every(fn($c) => $c->is_checked) ? 'checked' : '' }}>
                                <span class="tc-checkbox-box"></span>
                            </label>
                        </div>
                        <div class="tc-cart-col-product">Product</div>
                        <div class="tc-cart-col-name">Name</div>
                        <div class="tc-cart-col-price">Price</div>
                        <div class="tc-cart-col-qty">Quantity</div>
                        <div class="tc-cart-col-total">Total</div>
                        <div class="tc-cart-col-remove"></div>
                    </div>

                    <div id="cart_item_list">
                        @foreach($cartItems as $cart)
                            @php $photo = explode(',', $cart->product['photo']); @endphp
                            <div class="tc-cart-row cart-item" data-id="{{ $cart->id }}">
                                <div class="tc-cart-col-check">
                                    <label class="tc-checkbox-wrap">
                                        <input type="checkbox" class="cart-checkbox" data-id="{{ $cart->id }}" {{ $cart->is_checked ? 'checked' : '' }}>
                                        <span class="tc-checkbox-box"></span>
                                    </label>
                                </div>
                                <div class="tc-cart-col-product">
                                    <a href="{{ route('product-detail', $cart->product['slug']) }}">
                                        <img src="{{ asset(trim($photo[0])) }}" alt="{{ $cart->product['title'] }}" class="tc-cart-img" onerror="this.src='{{ asset('images/logo.png') }}'">
                                    </a>
                                </div>
                                <div class="tc-cart-col-name">
                                    <a href="{{ route('product-detail', $cart->product['slug']) }}" class="tc-cart-title">{{ $cart->product['title'] }}</a>
                                    @if($cart['summary'])
                                        <p class="tc-cart-summary">{!! $cart['summary'] !!}</p>
                                    @endif
                                </div>
                                <div class="tc-cart-col-price price">
                                    <span>₱ {{ number_format($cart['price'], 2, '.', ',') }}</span>
                                </div>
                                <div class="tc-cart-col-qty">
                                    <div class="tc-qty-control" data-min="1" data-max="100">
                                        <button type="button" class="btn-number" data-type="minus" aria-label="Decrease quantity"><i class="ti-minus"></i></button>
                                        <span class="tc-qty-value" aria-live="polite">{{ $cart->quantity }}</span>
                                        <button type="button" class="btn-number" data-type="plus" aria-label="Increase quantity"><i class="ti-plus"></i></button>
                                    </div>
                                </div>
                                <div class="tc-cart-col-total cart_single_price">
                                    <span>₱ {{ number_format($cart['amount'], 2, '.', ',') }}</span>
                                </div>
                                <div class="tc-cart-col-remove">
                                    <a href="{{ route('cart-delete', $cart->id) }}" class="tc-cart-remove" title="Remove item"><i class="ti-trash"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="tc-cart-bottom row">
                    <div class="col-lg-6 col-12">
                        <div class="tc-cart-side-card">
                            <h5>Have a Coupon?</h5>
                            <form action="{{ route('coupon-store') }}" method="POST" class="tc-coupon-form">
                                @csrf
                                <input type="text" name="code" class="form-control" placeholder="Enter coupon code">
                                <button type="submit" class="btn tc-cart-btn-primary">Apply</button>
                            </form>
                            <form action="{{ route('cart-empty') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn tc-cart-btn-outline w-100">Empty Cart</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="tc-cart-side-card">
                            <h5>Order Summary</h5>
                            <ul class="tc-cart-summary-list">
                                <li class="order_subtotal">
                                    <span>Cart Subtotal</span>
                                    <span>₱ {{ number_format(Helper::totalCartPrice(), 2, '.', ',') }}</span>
                                </li>
                                @if(session()->has('coupon'))
                                    <li class="coupon_price text-success" data-price="{{ Session::get('coupon')['value'] }}">
                                        <span>You Save</span>
                                        <span>₱ {{ number_format(Session::get('coupon')['value'], 2, '.', ',') }}</span>
                                    </li>
                                @endif
                                @php
                                    $total_amount = Helper::totalCartPrice();
                                    if (session()->has('coupon')) {
                                        $total_amount -= Session::get('coupon')['value'];
                                    }
                                @endphp
                                <li class="tc-cart-total" id="order_total_price">
                                    <span>Total</span>
                                    <span>₱ {{ number_format($total_amount, 2, '.', ',') }}</span>
                                </li>
                            </ul>
                            <div class="tc-cart-actions">
                                <a href="{{ route('product-grids') }}" class="btn tc-cart-btn-outline">Continue Shopping</a>
                                <a href="{{ route('checkout') }}" class="btn tc-cart-btn-primary">Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="tc-cart-empty">
                    <div class="tc-cart-empty-icon"><i class="ti-shopping-cart"></i></div>
                    <h3>Your cart is empty</h3>
                    <p>Looks like you haven't added anything yet.</p>
                    <a href="{{ route('product-grids') }}" class="btn tc-cart-btn-primary">Continue Shopping</a>
                </div>
            @endif
        </div>
    </section>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @push('scripts')
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

                function getQtyLimits($control) {
                    return {
                        min: parseInt($control.data('min')) || 1,
                        max: parseInt($control.data('max')) || 100
                    };
                }

                function getRowQty($row) {
                    return parseInt($row.find('.tc-qty-value').text()) || 1;
                }

                function setRowQty($row, quantity) {
                    $row.find('.tc-qty-value').text(quantity);
                }

                function updateCartTotals() {
                    let subtotal = 0;
                    $('#cart_item_list .cart-item').each(function () {
                        let $row = $(this);
                        let qty = getRowQty($row);
                        let price = parseFloat($row.find('.price span').text().replace(/[₱,]/g, '')) || 0;
                        let total = qty * price;

                        $row.find('.cart_single_price span').text(formatCurrency(total));
                        if ($row.find('.cart-checkbox').is(':checked')) subtotal += total;
                    });

                    let coupon = parseFloat($('.coupon_price').data('price')) || 0;
                    $('.order_subtotal span:last').text(formatCurrency(subtotal));
                    $('#order_total_price span:last').text(formatCurrency(subtotal - coupon));
                }

                function syncCartQuantity($row, quantity) {
                    let $control = $row.find('.tc-qty-control');
                    let limits = getQtyLimits($control);
                    quantity = Math.min(Math.max(quantity, limits.min), limits.max);

                    setRowQty($row, quantity);
                    updateCartTotals();

                    $.ajax({
                        url: '/cart/update-quantity/' + $row.data('id'),
                        type: 'POST',
                        data: { quantity: quantity },
                        success: function (res) {
                            if (!res.success) alert(res.message || 'Could not update cart.');
                        },
                        error: function () {
                            alert('An error occurred while updating the cart.');
                        }
                    });
                }

                $(document).on('click', '.btn-number', function () {
                    let $row = $(this).closest('.cart-item');
                    let currentVal = getRowQty($row);
                    if ($(this).data('type') === 'minus') currentVal--;
                    if ($(this).data('type') === 'plus') currentVal++;
                    syncCartQuantity($row, currentVal);
                });

                $('#selectAll').on('change', function () {
                    let checked = $(this).is(':checked');
                    $('.cart-checkbox').prop('checked', checked);
                    updateCartTotals();
                    $.post('{{ route('cart.toggle-check-all') }}', { is_checked: checked ? 1 : 0 });
                });

                $(document).on('change', '.cart-checkbox', function () {
                    let allChecked = $('.cart-checkbox').length === $('.cart-checkbox:checked').length;
                    $('#selectAll').prop('checked', allChecked);
                    updateCartTotals();
                    $.post('/cart/toggle-check/' + $(this).data('id'), {
                        is_checked: $(this).is(':checked') ? 1 : 0
                    });
                });

                updateCartTotals();
            });
        </script>
    @endpush

@endsection
