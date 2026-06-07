@extends('backend.layouts.master')

@section('main-content')

<div class="tc-page-card">
    <div class="tc-page-card-header">
        <div class="tc-page-card-title">
        <div class="tc-title-icon">
            <i class="fas fa-star"></i>
        </div>
            <div>
                <h5>Review Lists</h5>
                <p>Manage all product reviews</p>
            </div>
        </div>
    </div>

    <div class="tc-page-card-body">
        @if(count($reviews) > 0)
        <div class="table-responsive">
            <table class="table tc-table" id="order-dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Review By</th>
                        <th>Product Name</th>
                        <th>Review</th>
                        <th>Rating</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                    <tr>
                        <td class="tc-td-num">{{ $review->id }}</td>
                        <td>
                            <div class="tc-user-cell">
                                <div class="tc-user-avatar-sm">{{ strtoupper(substr($review->user_info['name'] ?? 'N', 0, 1)) }}</div>
                                <span>{{ $review->user_info['name'] ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="tc-product-name">
                                {{ $review->product->title ?? ($review->product->name ?? 'N/A') }}
                            </span>
                        </td>
                        <td>
                            <span class="tc-review-text" title="{{ $review->review }}">
                                {{ $review->review ? Str::limit($review->review, 60) : 'No comment' }}
                            </span>
                        </td>
                        <td>
                            <div class="tc-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $review->rate >= $i ? 'fas fa-star' : 'far fa-star' }}"></i>
                                @endfor
                            </div>
                        </td>
                        <td>
                            <span class="tc-date">{{ $review->created_at->format('M d, Y') }}</span>
                            <span class="tc-time">{{ $review->created_at->format('g:i a') }}</span>
                        </td>
                        <td>
                            @if($review->status == 'active')
                                <span class="tc-badge tc-badge-success">Active</span>
                            @else
                                <span class="tc-badge tc-badge-warning">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="tc-action-btns">
                                <a href="{{ route('review.edit', $review->id) }}"
                                   class="tc-btn-icon tc-btn-icon-primary"
                                   data-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('review.destroy', $review->id) }}" style="display:inline;">
                                    @csrf
                                    @method('delete')
                                    <button type="button"
                                            class="tc-btn-icon tc-btn-icon-danger dltBtn"
                                            data-id="{{ $review->id }}"
                                            data-toggle="tooltip" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tc-pagination-wrap">
            {{ $reviews->links() }}
        </div>
        @else
            <div class="tc-empty-state">
                <i class="fas fa-star-half-alt"></i>
                <p>No reviews found yet.</p>
            </div>
        @endif
    </div>
</div>

@endsection

@push('styles')
<link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
    div.dataTables_wrapper div.dataTables_paginate { display: none; }
    div.dataTables_wrapper div.dataTables_length label,
    div.dataTables_wrapper div.dataTables_filter label { font-size: 13px; color: #6b7280; }
    div.dataTables_wrapper div.dataTables_info { font-size: 13px; color: #6b7280; }

    /* ── Page Card ── */
    .tc-page-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(110,67,193,.08);
        overflow: hidden;
        margin-bottom: 24px;
    }
    .tc-page-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 28px;
        border-bottom: 1px solid #f0edfb;
        background: linear-gradient(135deg, #faf8ff 0%, #fff 100%);
    }
    .tc-page-card-title {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .tc-title-icon {
        width: 42px; height: 42px;
        background: linear-gradient(135deg, #6E43C1, #996EF8);
        color: #fff;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
    }
    .tc-page-card-title h5 { margin: 0; font-size: 16px; font-weight: 700; color: #1F2340; }
    .tc-page-card-title p  { margin: 0; font-size: 12px; color: #9ca3af; }
    .tc-page-card-body { padding: 24px 28px; }

    /* ── Table ── */
    .tc-table { border-collapse: separate; border-spacing: 0; width: 100%; }
    .tc-table thead th {
        background: #f8f5ff;
        color: #6E43C1;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .7px;
        text-transform: uppercase;
        padding: 12px 16px;
        border-bottom: 2px solid #ede8fb;
        white-space: nowrap;
    }
    .tc-table tbody tr { transition: background .15s; }
    .tc-table tbody tr:hover { background: #faf8ff; }
    .tc-table tbody td {
        padding: 13px 16px;
        font-size: 13px;
        color: #374151;
        border-bottom: 1px solid #f3f0fb;
        vertical-align: middle;
    }
    .tc-td-num { font-weight: 600; color: #9ca3af; font-size: 12px; }

    /* User cell */
    .tc-user-cell { display: flex; align-items: center; gap: 9px; }
    .tc-user-avatar-sm {
        width: 30px; height: 30px;
        background: linear-gradient(135deg, #6E43C1, #996EF8);
        color: #fff; border-radius: 50%;
        font-size: 12px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* Product name */
    .tc-product-name { font-weight: 600; color: #1F2340; }

    /* Review text */
    .tc-review-text { color: #6b7280; font-size: 13px; max-width: 220px; display: block; }

    /* Stars */
    .tc-stars { display: flex; gap: 2px; }
    .tc-stars .fas.fa-star { color: #f59e0b; font-size: 13px; }
    .tc-stars .far.fa-star { color: #d1d5db; font-size: 13px; }

    /* Date/time stacked */
    .tc-date { display: block; font-size: 13px; color: #374151; font-weight: 500; }
    .tc-time { display: block; font-size: 11px; color: #9ca3af; }

    /* Badges */
    .tc-badge {
        display: inline-flex; align-items: center;
        padding: 4px 10px; border-radius: 20px;
        font-size: 11px; font-weight: 600; letter-spacing: .3px;
    }
    .tc-badge-success { background: #d1fae5; color: #065f46; }
    .tc-badge-warning { background: #fef3c7; color: #92400e; }

    /* Action buttons */
    .tc-action-btns { display: flex; align-items: center; gap: 6px; justify-content: center; }
    .tc-table tbody td:last-child { text-align: center; vertical-align: middle; padding-top: 0; padding-bottom: 0; }
    .tc-btn-icon {
        width: 32px; height: 32px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 13px; border: none; cursor: pointer;
        transition: all .2s; text-decoration: none;
    }
    .tc-btn-icon-primary { background: #ede8fb; color: #6E43C1; }
    .tc-btn-icon-primary:hover { background: #6E43C1; color: #fff; }
    .tc-btn-icon-danger { background: #fee2e2; color: #dc2626; }
    .tc-btn-icon-danger:hover { background: #dc2626; color: #fff; }

    /* Pagination */
    .tc-pagination-wrap { display: flex; justify-content: flex-end; padding-top: 16px; }

    /* Empty state */
    .tc-empty-state {
        text-align: center; padding: 60px 20px; color: #9ca3af;
    }
    .tc-empty-state i { font-size: 40px; margin-bottom: 12px; display: block; }
    .tc-empty-state p { font-size: 15px; margin: 0; }
</style>
@endpush

@push('scripts')
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
$('#order-dataTable').DataTable({
    "columnDefs": [
        { "orderable": false, "targets": [3, 4, 7] }
    ],
    "language": {
        "search": "Search:",
        "lengthMenu": "Show _MENU_ entries",
        "info": "Showing _START_ to _END_ of _TOTAL_ reviews"
    }
});

$(document).ready(function(){
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $(document).on('click', '.dltBtn', function(e){
        var btn  = $(this);
        var form = btn.closest('form');
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this review!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then(function(willDelete){
            if(willDelete){ form.submit(); }
            else { swal("Your review is safe!"); }
        });
    });
});
</script>
@endpush