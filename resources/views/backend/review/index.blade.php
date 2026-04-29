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
        <h6 class="m-0 font-weight-bold text-primary float-left">Review Lists</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(count($reviews) > 0)
            <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Review By</th>
                        <th>Product Title</th>
                        <th>Review</th>
                        <th>Rate</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Review By</th>
                        <th>Product Title</th>
                        <th>Review</th>
                        <th>Rate</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($reviews as $review)  
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td>{{ $review->user_info['name'] ?? 'N/A' }}</td>
                            <td>{{ optional($review->product)->title ?? 'N/A' }}</td>
                            <td>{{ $review->review }}</td>
                            <td>
                                <ul style="list-style:none;padding:0;margin:0">
                                    @for($i=1; $i<=5; $i++)
                                        <li style="float:left;color:#996EF8;">
                                            <i class="{{ $review->rate >= $i ? 'fa fa-star' : 'far fa-star' }}"></i>
                                        </li>
                                    @endfor
                                </ul>
                            </td>
                            <td>{{ $review->created_at->format('M d D, Y g:i a') }}</td>
                            <td>
                                <span class="badge {{ $review->status=='active' ? 'badge-success' : 'badge-warning' }}">
                                    {{ $review->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('review.edit', $review->id) }}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px;width:30px;border-radius:50%" data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                                <form method="POST" action="{{ route('review.destroy', $review->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm dltBtn" data-id="{{ $review->id }}" style="height:30px;width:30px;border-radius:50%" data-toggle="tooltip" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>  
                    @endforeach
                </tbody>
            </table>
            <span style="float:right">{{ $reviews->links() }}</span>
            @else
                <h6 class="text-center text-muted">There are currently no reviews to display.</h6>
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
<script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>

<script>
$('#order-dataTable').DataTable({
    "columnDefs":[
        { "orderable": false, "targets": [5,6] }
    ]
});

// SweetAlert Delete
$(document).ready(function(){
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
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
            if(willDelete){
                form.submit();
            } else {
                swal("Your data is safe!");
            }
        });
    });
});
</script>
@endpush
