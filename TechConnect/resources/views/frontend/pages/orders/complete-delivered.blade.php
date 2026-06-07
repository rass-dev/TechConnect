@extends('frontend.pages.orders.my-orders')

@section('orders-content')
    @php $hasOrders = false; @endphp
    @foreach($orders ?? [] as $order)
        @if(in_array($order->status, ['delivered', 'completed']))
            @php $hasOrders = true; @endphp
            @include('frontend.pages.orders._order-card', [
                'order' => $order,
                'statusLabel' => $order->status == 'completed' ? 'Completed' : 'Delivered',
            ])
        @endif
    @endforeach
    @if(!$hasOrders)
        <div class="tc-empty-state">
            <i class="fa fa-check-circle"></i>
            <p>No completed orders yet.</p>
            <a href="{{ route('product-grids') }}" class="btn-modern">Start Shopping</a>
        </div>
    @endif
@endsection
