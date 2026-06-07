<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>TechConnect - Invoice #{{ $order->order_number }}</title>
  <style>
    @page {
      margin: 30px;
    }

    body {
      font-family: "DejaVu Sans", sans-serif;
      font-size: 12px;
      color: #2D195C;
      background-color: #ffffff;
      margin: 0;
      padding: 0;
    }

    /* Header */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .logo img {
      width: 270px;
      margin-bottom: -50px;
    }

    .order-info {
      text-align: right;
      color: #2F1B5E;
    }

    /* Customer Info */
    .customer-info {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .customer-info td {
      vertical-align: top;
      width: 50%;
      border: none;
      padding: 5px;
    }

    .customer-info p {
      margin: 5px 0;
      font-size: 12px;
      color: #2D195C;
    }

    /* Table */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10px;
    }

    th,
    td {
      padding: 8px;
      font-size: 12px;
      border: 1px solid #ECE8FF;
    }

    th {
      background-color: #986FF8;
      color: #ffffff;
      text-align: left;
    }

    td {
      background-color: #ffffff;
    }

    /* Totals */
    .totals {
      width: 100%;
      margin-top: 10px;
      font-weight: bold;
      border-collapse: collapse;
    }

    .totals td {
      padding: 4px 10px;
      border: none;
    }

    .totals .label {
      text-align: right;
      width: 80%;
    }

    /* Footer */
    .thank-you {
      text-align: center;
      margin-top: 30px;
      font-size: 14px;
      color: #2F1B5E;
      font-weight: bold;
    }
  </style>
</head>

<body>

  <!-- Header -->
  <div class="header">
    <div class="logo">
      <img src="{{ public_path('backend/img/logo2.png') }}" alt="TechConnect Logo">
    </div>
    <div class="order-info">
      <h3>Order #{{ $order->order_number }}</h3>
      <p>{{ $order->created_at->format('D, d M Y, g:i a') }}</p>
    </div>
  </div>

  <!-- Customer Info -->
  <table class="customer-info">
    <tr>
      <!-- Left Column -->
      <td class="left">
        <p><strong>Full Name:</strong> {{ $order->name }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Phone:</strong> {{ $order->phone }}</p>
        <p><strong>Address:</strong> {{ $order->address }}</p>
      </td>

      <!-- Right Column -->
      <td class="right">
        <p><strong>Post Code:</strong> {{ $order->post_code }}</p>
        <p><strong>Status:</strong> {{ $order->status }}</p>
        <p><strong>Payment Method:</strong>
          {{ $order->payment_method == 'cod' ? 'Cash on Delivery' : 'Paypal' }}
        </p>
        <p><strong>Payment Status:</strong> {{ $order->payment_status }}</p>
      </td>
    </tr>
  </table>

  <!-- Order Items Table -->
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Item Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total Amount</th>
      </tr>
    </thead>
    <tbody>
      @foreach($order->items as $key => $item)
        <tr>
          <td>{{ $key + 1 }}</td>
          <td>{{ $item->product ? $item->product->title : 'Product not found' }}</td>
          <td>₱ {{ number_format($item->price, 2) }}</td>
          <td>{{ $item->quantity }}</td>
          <td>₱ {{ number_format($item->price * $item->quantity, 2) }}</td>
        </tr>
      @endforeach

      {{-- End marker row --}}
      <tr>
        <td colspan="5" style="text-align:center; font-style:italic; color:#555;">
          Nothing to follow
        </td>
      </tr>
    </tbody>
  </table>

  <!-- Totals -->
  <table class="totals">
    <tr>
      <td class="label">Shipping Fee:</td>
      <td>₱ {{ number_format($order->shipping ? $order->shipping->price : 0, 2) }}</td>
    </tr>
    <tr>
      <td class="label">Coupon:</td>
      <td>₱ {{ number_format($order->coupon, 2) }}</td>
    </tr>
    <tr>
      <td class="label">Total Amount:</td>
      <td>₱ {{ number_format($order->total_amount, 2) }}</td>
    </tr>
  </table>

  <div class="thank-you">
    Thank you for shopping with TechConnect! We hope you enjoy your new products.
  </div>

</body>
</html>
