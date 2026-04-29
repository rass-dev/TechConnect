@extends('backend.layouts.master')

@section('main-content')
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="row">
      <div class="col-md-12">
        @include('backend.layouts.notification')
      </div>
    </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Order Lists</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($orders) > 0)
          <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No.</th>
                <th>Order No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Quantity</th>
                <th>Charge</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No.</th>
                <th>Order No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Quantity</th>
                <th>Charge</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach($orders as $order)
                @php
                  $shipping_charge = DB::table('shippings')->where('id', $order->shipping_id)->pluck('price');
                @endphp
                <tr>
                  <td>{{$order->id}}</td>
                  <td>{{$order->order_number}}</td>
                  <td>{{$order->name}}</td>
                  <td>{{$order->email}}</td>
                  <td>{{$order->quantity}}</td>
                  <td>@foreach($shipping_charge as $data) ₱ {{number_format($data, 2)}} @endforeach</td>
                  <td>₱ {{number_format($order->total_amount, 2)}}</td>
                  <td>
                    @php
                      $statusClasses = [
                        'new' => 'blue',   
                        'process' => 'warning',   
                        'on_the_way' => 'info',      
                        'delivered' => 'success',  
                        'completed' => 'primary',  
                        'cancel' => 'danger',
                      ];

                      $statusLabels = [
                        'new' => 'New',
                        'process' => 'In Process',
                        'on_the_way' => 'On the Way',
                        'delivered' => 'Delivered',
                        'completed' => 'Completed',
                        'cancel' => 'Cancelled',
                      ];
                    @endphp

                    <span class="badge badge-{{ $statusClasses[$order->status] ?? 'dark' }}">
                      {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                    </span>
                  </td>

                  <td>
                    <a href="{{route('order.show', $order->id)}}" class="btn btn-warning btn-sm float-left mr-1"
                      style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view"
                      data-placement="bottom"><i class="fas fa-eye"></i></a>
                    <a href="{{route('order.edit', $order->id)}}" class="btn btn-primary btn-sm float-left mr-1"
                      style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                      data-placement="bottom"><i class="fas fa-edit"></i></a>
                    
                    <!-- History Button -->
                    <button type="button" class="btn btn-info btn-sm float-left mr-1 viewHistoryBtn"
                      data-id="{{$order->id}}" style="height:30px; width:30px;border-radius:50%" 
                      data-toggle="tooltip" title="History" data-placement="bottom">
                      <i class="fas fa-history"></i>
                    </button>

                    <form method="POST" action="{{route('order.destroy', [$order->id])}}" style="display:inline-block">
                      @csrf
                      @method('delete')
                      <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}}
                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom"
                        title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <span style="float:right">{{$orders->links()}}</span>
        @else
          <h6 class="text-center">No orders found!!! Please order some products</h6>
        @endif
      </div>
    </div>
  </div>

  <!-- Order History Modal -->
  <div class="modal fade" id="orderHistoryModal" tabindex="-1" role="dialog" aria-labelledby="orderHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Order History</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="order-history-content">
            <p class="text-center">Loading...</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
    div.dataTables_wrapper div.dataTables_paginate {
      display: none;
    }
  </style>
@endpush

@push('scripts')
  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>
    // Initialize DataTable
    $('#order-dataTable').DataTable({
      "columnDefs": [
        {
          "orderable": false,
          "targets": [8] // Disable sorting on Action column
        }
      ]
    });

    $(document).ready(function () {
      // Set CSRF token for Ajax
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      // Delete confirmation
      $('.dltBtn').click(function (e) {
        var form = $(this).closest('form');
        e.preventDefault();
        swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
            form.submit();
          } else {
            swal("Your data is safe!");
          }
        });
      });

      // View History button click
      $('.viewHistoryBtn').click(function () {
        let orderId = $(this).data('id');

        // 🔹 Debug: log selected order ID
        console.log('Selected orderId:', orderId);

        $('#order-history-content').html('<p class="text-center">Loading...</p>');
        $('#orderHistoryModal').modal('show');

        // Ajax request to fetch order history
        $.get("{{ url('admin/order-history') }}/" + orderId, function (data) {
          // 🔹 Debug: log returned data
          console.log('Order history data:', data);

          $('#order-history-content').html(data);
        }).fail(function (xhr, status, error) {
          // 🔹 Debug: log error details
          console.error('Failed to load order history:', status, error, xhr.responseText);
          $('#order-history-content').html('<p class="text-danger text-center">Failed to load order history.</p>');
        });
      });
    });
  </script>
@endpush
