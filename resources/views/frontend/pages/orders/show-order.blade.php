@extends('frontend.layouts.master')

@section('title', 'Order Detail')

@section('main-content')
<div class="container py-5">
    @if($order)
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="margin-top: 80px;">
            <h3 class="fw-bold mb-2">Order #{{ $order->order_number }}</h3>

            <div class="d-flex flex-wrap gap-2">
                {{-- Cancel button --}}
                @if(!in_array($order->status, ['completed', 'cancel']) && $order->status != 'delivered')
                    <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn custom-btn-danger" onclick="return confirm('Are you sure you want to cancel this order?');">
                            Cancel
                        </button>
                    </form>
                @endif

                {{-- Confirm Delivery button --}}
                @if($order->status == 'delivered')
                    <form action="{{ route('order.confirm', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn custom-btn-primary" onclick="return confirm('Have you received this order? Confirm delivery?');">
                            Confirm Delivery
                        </button>
                    </form>
                @endif

                {{-- Download PDF --}}
                <a href="{{ route('order.pdf', $order->id) }}" class="btn custom-btn-primary" onclick="return confirm('Do you want to download the PDF?');">
                    Download PDF
                </a>

                {{-- Back --}}
                <a href="{{ route('my-orders') }}" class="btn custom-btn-secondary">
                    Back
                </a>
            </div>
        </div>

        <!-- Order Items Table -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Order Items</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="small text-muted">
                            <tr>
                                <th>No.</th>
                                <th>Item Name</th>
                                <th class="text-end">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product->title ?? 'Product not found' }}</td>
                                    <td class="text-end">₱{{ number_format($item->price, 2) }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No items found for this order.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="row g-4">
            <!-- Order Info -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Order Information</h5>
                        <ul class="list-group list-group-flush small">
                            <li class="list-group-item"><strong>Order Number:</strong> {{ $order->order_number }}</li>
                            <li class="list-group-item"><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y g:i A') }}</li>
                            <li class="list-group-item"><strong>Quantity:</strong> {{ $order->quantity }}</li>
                            @php
                                $statusLabels = [
                                    'new' => 'New',
                                    'process' => 'In Process',
                                    'on_the_way' => 'On the Way',
                                    'delivered' => 'Delivered',
                                    'completed' => 'Completed',
                                    'cancel' => 'Cancelled',
                                ];
                            @endphp
                            <li class="list-group-item"><strong>Status:</strong> {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}</li>
                            <li class="list-group-item"><strong>Shipping Charge:</strong> ₱{{ number_format($order->shipping->price ?? 0, 2) }}</li>
                            <li class="list-group-item"><strong>Coupon:</strong> ₱{{ number_format($order->coupon ?? 0, 2) }}</li>
                            <li class="list-group-item"><strong>Total Amount:</strong> <span class="fw-bold" style="color:#996FF8;">₱{{ number_format($order->total_amount, 2) }}</span></li>
                            <li class="list-group-item"><strong>Payment Method:</strong> {{ $order->payment_method == 'cod' ? 'Cash on Delivery' : 'Paypal' }}</li>
                            <li class="list-group-item"><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Shipping Information</h5>
                        <ul class="list-group list-group-flush small">
                            <li class="list-group-item"><strong>Full Name:</strong> {{ $order->name }}</li>
                            <li class="list-group-item"><strong>Email:</strong> {{ $order->email }}</li>
                            <li class="list-group-item"><strong>Phone:</strong> {{ $order->phone }}</li>
                            <li class="list-group-item"><strong>Address:</strong> {{ $order->address }}</li>
                            <li class="list-group-item"><strong>Post Code:</strong> {{ $order->post_code }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    @else
        <p class="text-center text-muted">Order not found.</p>
    @endif
</div>
@endsection

@push('styles')
<style>
/* Base styling */
body { font-family: 'Inter', sans-serif; background-color: #EDE8FE; }
h3, h5 { font-weight: 600; margin-bottom: 0.5rem; }
.card { padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); background:#fff; transition: 0.3s; }
.card:hover { box-shadow:0 6px 12px rgba(0,0,0,0.08); }
.list-group-item { border:none; padding:0.5rem 0; font-size:0.9rem; }

/* Buttons */
.btn {
    min-width: 110px; height: 40px; font-size:0.9rem; font-weight:600; border-radius:8px;
    display:inline-flex; align-items:center; justify-content:center; gap:6px;
    transition:all 0.2s ease-in-out; cursor:pointer; text-decoration:none; border:none;
    margin-right:12px;
}

/* Primary */
.custom-btn-primary { background-color:#2D185D; color:#fff !important; }
.custom-btn-primary:hover { background-color:#2F1B5E; }
.custom-btn-primary:active { background-color:#361E6E; }

/* Danger */
.custom-btn-danger { background-color:#2D185D; color:#fff; }
.custom-btn-danger:hover { background-color:#2F1B5E; }
.custom-btn-danger:active { background-color:#361E6E; }

/* Secondary */
.custom-btn-secondary { background-color:#EDE8FE; color:#2D185D; border:2px solid #2D185D; }
.custom-btn-secondary:hover { background-color:#986FF8; color:#fff; }
.custom-btn-secondary:active { background-color:#361E6E; color:#fff; }

/* Table hover */
table.table-hover tbody tr:hover { background-color:#f3f0ff; }

/* Responsive */
@media(max-width:768px){
    .card { padding:15px; }
    .btn { min-width:100%; margin-bottom:10px; margin-right:0; }
}
</style>
@endpush
