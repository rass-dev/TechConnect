@extends('frontend.pages.orders.my-orders')

@section('orders-content')
    @php $hasOrders = false; @endphp
    @foreach($orders ?? [] as $order)
        @if(in_array($order->status, ['process', 'on_the_way']))
            @php $hasOrders = true; @endphp
            @include('frontend.pages.orders._order-card', [
                'order' => $order,
                'statusLabel' => $order->status == 'on_the_way' ? 'On The Way' : ucfirst($order->status),
            ])
        @endif
    @endforeach
    @if(!$hasOrders)
        <div class="tc-empty-state">
            <i class="fa fa-truck"></i>
            <p>No orders to ship yet.</p>
            <a href="{{ route('product-grids') }}" class="btn-modern">Start Shopping</a>
        </div>
    @endif
@endsection
