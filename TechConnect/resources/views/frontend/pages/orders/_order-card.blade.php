<div class="order-item-card">
    <div class="order-item-top">
        <div>
            <span class="order-number">Order #{{ $order->order_number ?? $order->id }}</span>
            <span class="order-date">{{ $order->created_at->format('M d, Y') }}</span>
        </div>
        <span class="order-status-badge status-{{ $order->status }}">
            {{ $statusLabel ?? ucfirst(str_replace(['_', '-'], ' ', $order->status)) }}
        </span>
    </div>
    <div class="order-item-products">
        @foreach($order->items->take(2) as $item)
            <p>{{ $item->product->title ?? 'N/A' }} <small>x{{ $item->quantity }}</small></p>
        @endforeach
        @if($order->items->count() > 2)
            <p class="order-more">+ {{ $order->items->count() - 2 }} more item(s)</p>
        @endif
    </div>
    <div class="order-item-bottom">
        <span class="order-total">Total: <strong>₱ {{ number_format($order->total_amount, 2) }}</strong></span>
        <a href="{{ route('orders.show', $order->id) }}" class="btn-order-view">View Details</a>
    </div>
</div>
