@extends('frontend.pages.orders.my-orders')

@section('orders-content')
    @php $hasOrders = false; @endphp
    @foreach($orders ?? [] as $order)
        @if($order->status == 'delivered')
            @php $hasOrders = true; @endphp
            @include('frontend.pages.orders._order-card', ['order' => $order])
        @endif
    @endforeach
    @if(!$hasOrders)
        <div class="tc-empty-state">
            <i class="fa fa-archive"></i>
            <p>No orders waiting to be received.</p>
            <a href="{{ route('product-grids') }}" class="btn-modern">Start Shopping</a>
        </div>
    @endif
@endsection
