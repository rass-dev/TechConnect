@extends('backend.layouts.master')

@section('title', 'Order Detail')

@section('main-content')
  <div class="container py-4">
    @if($order)
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Order #{{$order->order_number}}</h3>
        <a href="{{ route('order.pdf', $order->id) }}" class="btn btn-primary shadow-sm">
          <i class="fas fa-download"></i> Generate PDF
        </a>

      </div>

      <!-- Order Items Table -->
      <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
          <table class="table table-borderless table-hover">
            <thead class="text-muted small text-uppercase">
              <tr>
                <th>No.</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Amount</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @if($order->items && $order->items->count() > 0)
                @foreach($order->items as $key => $item)
                  <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->product ? $item->product->title : 'Product not found' }}</td>
                    <td>₱ {{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₱ {{ number_format($item->price * $item->quantity, 2) }}</td>
                    <td>
                      <form method="POST" action="{{ route('order.item.destroy', [$item->id]) }}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-outline-danger btn-sm" title="Delete">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="6" class="text-center">No items found for this order.</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>

      <!-- Order & Shipping Info -->
      <div class="row g-4">
        <!-- Order Info -->
        <div class="col-md-6">
          <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
              <h5 class="card-title text-center mb-4">Order Information</h5>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Order Number:</strong> {{$order->order_number}}</li>
                <li class="list-group-item"><strong>Order Date:</strong> {{$order->created_at->format('D d M, Y')}} at
                  {{$order->created_at->format('g:i a')}}
                </li>
                <li class="list-group-item"><strong>Quantity:</strong> {{$order->quantity}}</li>
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

                <li class="list-group-item">
                  <strong>Status:</strong>
                  {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                </li>

                <li class="list-group-item"><strong>Shipping Charge:</strong> ₱
                  {{ number_format($order->shipping ? $order->shipping->price : 0, 2) }}
                </li>
                <li class="list-group-item"><strong>Coupon:</strong> ₱ {{ number_format($order->coupon, 2) }}</li>
                <li class="list-group-item"><strong>Total Amount:</strong> ₱ {{ number_format($order->total_amount, 2) }}
                </li>
                <li class="list-group-item"><strong>Payment Method:</strong>
                  {{ $order->payment_method == 'cod' ? 'Cash on Delivery' : 'Paypal' }}</li>
                <li class="list-group-item"><strong>Payment Status:</strong> {{$order->payment_status}}</li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Shipping Info -->
        <div class="col-md-6">
          <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
              <h5 class="card-title text-center mb-4">Shipping Information</h5>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Full Name:</strong> {{$order->name}}</li>
                <li class="list-group-item"><strong>Email:</strong> {{$order->email}}</li>
                <li class="list-group-item"><strong>Phone:</strong> {{$order->phone}}</li>
                <li class="list-group-item"><strong>Address:</strong> {{$order->address}}</li>
                <li class="list-group-item"><strong>Post Code:</strong> {{$order->post_code}}</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    @endif
  </div>
@endsection

@push('styles')
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .card-title {
      font-weight: 600;
      text-decoration: underline;
      letter-spacing: 0.5px;
    }

    table.table-hover tbody tr:hover {
      background-color: #f1f3f5;
    }

    .list-group-item {
      border: none;
      padding: 0.75rem 1rem;
    }
  </style>
@endpush