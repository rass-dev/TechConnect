@extends('frontend.pages.orders.my-orders')

@section('orders-content')
    @php $hasOrders = false; @endphp
    @foreach($orders ?? [] as $order)
        @if($order->status == 'cancel')
            @php $hasOrders = true; @endphp
            @include('frontend.pages.orders._order-card', ['order' => $order, 'statusLabel' => 'Cancelled'])
        @endif
    @endforeach
    @if(!$hasOrders)
        <div class="tc-empty-state">
            <i class="fa fa-times-circle"></i>
            <p>No cancelled orders.</p>
            <a href="{{ route('product-grids') }}" class="btn-modern">Start Shopping</a>
        </div>
    @endif
@endsection
