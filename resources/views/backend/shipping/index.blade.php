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
      <h6 class="m-0 font-weight-bold text-primary float-left">Shipping List</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($shippings) > 0)
        <table class="table table-bordered" id="shipping-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No.</th>
              <th>Name</th>
              <th>Reference No</th>
              <th>Payment Method</th>
              <th>Address</th>
              <th>Total</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No.</th>
              <th>Name</th>
              <th>Reference No</th>
              <th>Payment Method</th>
              <th>Address</th>
              <th>Total</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach($shippings as $shipping)   
                <tr>
                    <td>{{ $shipping->id }}</td>
                    <td>{{ $shipping->name }}</td>
                    <td>{{ $shipping->reference_no }}</td>
                    <td>{{ $shipping->payment_method }}</td>
                    <td>{{ $shipping->address }}</td>
                    <td>₱ {{ number_format($shipping->total, 2) }}</td>
                    <td>
                        @if($shipping->status == 'pending')
                            <span class="badge badge-warning">{{ $shipping->status }}</span>
                        @elseif($shipping->status == 'processing')
                            <span class="badge badge-info">{{ $shipping->status }}</span>
                        @elseif($shipping->status == 'shipped')
                            <span class="badge badge-primary">{{ $shipping->status }}</span>
                        @elseif($shipping->status == 'delivered')
                            <span class="badge badge-success">{{ $shipping->status }}</span>
                        @else
                            <span class="badge badge-danger">{{ $shipping->status }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('shipping.edit', $shipping->id) }}" 
                           class="btn btn-primary btn-sm mr-1" style="height:30px;width:30px;border-radius:50%" 
                           title="Edit">
                           <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('shipping.destroy', $shipping->id) }}" style="display:inline;">
                            @csrf 
                            @method('delete')
                            <button class="btn btn-danger btn-sm dltBtn" data-id="{{ $shipping->id }}" 
                                    style="height:30px;width:30px;border-radius:50%" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{ $shippings->links() }}</span>
        @else
          <h6 class="text-center">No shippings found!!! Please create shipping</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
    div.dataTables_wrapper div.dataTables_paginate{
        display: none;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
$('#shipping-dataTable').DataTable({
    "columnDefs":[
        { "orderable": false, "targets": [8] } // disable ordering for action column
    ]
});

$(document).ready(function(){
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('.dltBtn').click(function(e){
        var form = $(this).closest('form');
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) form.submit();
            else swal("Your data is safe!");
        });
    });
});
</script>
@endpush
