@extends('frontend.pages.orders.my-orders')

@section('orders-content')
    @forelse($orders ?? [] as $order)
        @include('frontend.pages.orders._order-card', ['order' => $order])
    @empty
        <div class="tc-empty-state">
            <i class="fa fa-shopping-bag"></i>
            <p>No orders in this tab yet.</p>
            <a href="{{ route('product-grids') }}" class="btn-modern">Start Shopping</a>
        </div>
    @endforelse
@endsection
