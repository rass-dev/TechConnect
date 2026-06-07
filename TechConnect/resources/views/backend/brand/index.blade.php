@extends('backend.layouts.master')
@section('title','TechConnect | Brand Page')

@section('main-content')

<div class="tc-page-card">
    <div class="tc-page-card-header">
        <div class="tc-page-card-title">
            <div class="tc-title-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div>
                <h5>Brand List</h5>
                <p>Manage all product brands</p>
            </div>
        </div>
        <a href="{{ route('brand.create') }}" class="tc-btn-add">
            <i class="fas fa-plus"></i> Add Brand
        </a>
    </div>

    <div class="tc-page-card-body">
        @if(count($brands) > 0)
        <div class="table-responsive">
            <table class="table tc-table" id="banner-dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($brands as $brand)
                    <tr>
                        <td class="tc-td-num">{{ $brand->id }}</td>
                        <td><span class="tc-brand-title">{{ $brand->title }}</span></td>
                        <td>
                            @if($brand->status == 'active')
                                <span class="tc-badge tc-badge-success">Active</span>
                            @else
                                <span class="tc-badge tc-badge-warning">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="tc-action-btns">
                                <a href="{{ route('brand.edit', $brand->id) }}"
                                   class="tc-btn-icon tc-btn-icon-primary"
                                   data-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('brand.destroy', [$brand->id]) }}" style="display:inline;">
                                    @csrf
                                    @method('delete')
                                    <button type="button"
                                            class="tc-btn-icon tc-btn-icon-danger dltBtn"
                                            data-id="{{ $brand->id }}"
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
            {{ $brands->links() }}
        </div>
        @else
            <div class="tc-empty-state">
                <i class="fas fa-tags"></i>
                <p>No brands found yet.</p>
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
        flex-shrink: 0;
    }
    .tc-page-card-title h5 { margin: 0; font-size: 16px; font-weight: 700; color: #1F2340; }
    .tc-page-card-title p  { margin: 0; font-size: 12px; color: #9ca3af; }
    .tc-page-card-body { padding: 24px 28px; }

    /* Add button */
    .tc-btn-add {
        display: inline-flex; align-items: center; gap: 6px;
        background: linear-gradient(135deg, #6E43C1, #996EF8);
        color: #fff; border-radius: 8px;
        padding: 8px 16px; font-size: 13px; font-weight: 600;
        text-decoration: none; transition: opacity .2s;
    }
    .tc-btn-add:hover { opacity: .88; color: #fff; text-decoration: none; }

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
    .tc-brand-title { font-weight: 600; color: #1F2340; }

    /* Badges */
    .tc-badge {
        display: inline-flex; align-items: center;
        padding: 4px 10px; border-radius: 20px;
        font-size: 11px; font-weight: 600; letter-spacing: .3px;
    }
    .tc-badge-success { background: #d1fae5; color: #065f46; }
    .tc-badge-warning { background: #fef3c7; color: #92400e; }
    .tc-badge-primary { background: #ede8fb; color: #6E43C1; }
    .tc-muted { color: #d1d5db; font-size: 13px; }

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
    .tc-empty-state { text-align: center; padding: 60px 20px; color: #9ca3af; }
    .tc-empty-state i { font-size: 40px; margin-bottom: 12px; display: block; }
    .tc-empty-state p { font-size: 15px; margin: 0; }
</style>
@endpush

@push('scripts')
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
$('#banner-dataTable').DataTable({
    "columnDefs": [
        { "orderable": false, "targets": [2, 3] }
    ],
    "language": {
        "search": "Search:",
        "lengthMenu": "Show _MENU_ entries",
        "info": "Showing _START_ to _END_ of _TOTAL_ brands"
    }
});

$(document).ready(function(){
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $(document).on('click', '.dltBtn', function(e){
        var form = $(this).closest('form');
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this brand!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then(function(willDelete){
            if(willDelete){ form.submit(); }
            else { swal("Your brand is safe!"); }
        });
    });
});
</script>
@endpush