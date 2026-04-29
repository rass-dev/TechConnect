@extends('frontend.pages.orders.my-orders')

@section('orders-content')
<div class="container py-4">
    <h4 class="mb-4" style="color:#2C185C;">Cancelled Orders</h4>

    @forelse($orders ?? [] as $order)
        @if($order->status == 'cancel')
        <div class="order-card row align-items-start mb-3 p-4 shadow-sm rounded-3">
            <!-- Top: Item preview -->
            <div class="col-12 mb-3">
                @php
                    $previewItems = $order->items->take(2);
                @endphp

                @foreach($previewItems as $item)
                    <p class="mb-1" style="color:#2E1A5E;">
                        {{ $item->product->title ?? 'N/A' }} 
                        <small class="text-muted">x{{ $item->quantity }}</small>
                    </p>
                @endforeach

                @if($order->items->count() > 2)
                    <p class="text-muted small">+ {{ $order->items->count() - 2 }} more items</p>
                @endif
            </div>

            <!-- Date + Status + Action -->
            <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <p class="mb-1"><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                    <p class="mb-0"><strong>Total:</strong> ₱ {{ number_format($order->total_amount, 2) }}</p>
                </div>

                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <span class="badge status-cancelled">
                        Cancelled
                    </span>

                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-view">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        @endif
    @empty
        <p class="text-muted">No orders found in this tab.</p>
    @endforelse
</div>
@endsection

@push('styles')
<style>
/* Card */
.order-card {
    background-color: #F8EDEB; /* light red/pink for cancelled */
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    transition: box-shadow 0.3s ease;
    margin-bottom: 20px;
}

.order-card:hover {
    box-shadow: 0 6px 12px rgba(0,0,0,0.08);
}

/* Status badges */
.status-cancelled { background-color: #E74C3C; color: #fff; }

.badge {
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 6px;
    padding: 4px 8px;
}

/* View Details Button */
.btn-view {
    background-color: #996EF8;
    color: #fff !important;
    border: none;
    border-radius: 8px;
    padding: 8px 18px;
    font-weight: 500;
    transition: background 0.2s ease-in-out;
    text-decoration: none;
}

.btn-view:hover {
    background-color: #7a53d9;
}

/* Text Colors */
.order-card p { color: #2E1A5E; }
.order-card small { color: #555; }

/* Spacing */
.order-card p,
.order-card small { margin-bottom: 6px; }

/* Gap between status and button */
.d-flex.align-items-center.gap-3 span.badge { margin-right: 15px; }

/* Responsive */
@media(max-width:768px){
    .order-card { flex-direction: column; text-align: left; padding: 20px; }
    .order-card .d-flex { justify-content: flex-start; gap: 10px; margin-top: 10px; }
}
</style>
@endpush
