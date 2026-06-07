@extends('frontend.layouts.master')

@section('title', 'TechConnect | My Orders')

@section('main-content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="bread-inner">
                <ul class="bread-list">
                    <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                    <li class="active"><a href="javascript:void(0);">My Orders</a></li>
                </ul>
            </div>
        </div>
    </div>

    <section id="my-orders" class="account-page section">
        <div class="container">
            <div class="account-page-header">
                <h1>My Orders</h1>
                <p>Track and manage your purchases.</p>
            </div>

            <div class="account-card account-card-wide">
                @php
                    $currentTab = request()->segment(2) ?? 'to-process';
                    $tabs = [
                        'to-process' => 'To Process',
                        'to-ship' => 'To Ship',
                        'to-receive' => 'To Receive',
                        'complete-delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ];
                @endphp

                <ul class="orders-tabs" role="tablist">
                    @foreach($tabs as $key => $label)
                        <li>
                            <a class="orders-tab {{ $currentTab == $key ? 'active' : '' }}"
                               href="{{ route('orders.' . $key) }}">{{ $label }}</a>
                        </li>
                    @endforeach
                </ul>

                <div class="orders-tab-content">
                    @yield('orders-content')
                </div>
            </div>
        </div>
    </section>
@endsection
