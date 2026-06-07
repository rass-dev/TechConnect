@extends('backend.layouts.master')

@section('main-content')

<div class="tc-page-card">
    <div class="tc-page-card-header">
        <div class="tc-page-card-title">
            <div class="tc-title-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div>
                <h5>Order Lists</h5>
                <p>Manage all customer orders</p>
            </div>
        </div>
    </div>

    <div class="tc-page-card-body">
        @if(count($orders) > 0)
        <div class="table-responsive">
            <table class="table tc-table" id="order-dataTable" width="100%" cellspacing="0">
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
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    @php
                        $shipping_charge = DB::table('shippings')->where('id', $order->shipping_id)->pluck('price');
                        $statusClasses = [
                            'new'        => 'tc-badge-new',
                            'process'    => 'tc-badge-process',
                            'on_the_way' => 'tc-badge-onway',
                            'delivered'  => 'tc-badge-success',
                            'completed'  => 'tc-badge-primary',
                            'cancel'     => 'tc-badge-danger',
                        ];
                        $statusLabels = [
                            'new'        => 'New',
                            'process'    => 'In Process',
                            'on_the_way' => 'On the Way',
                            'delivered'  => 'Delivered',
                            'completed'  => 'Completed',
                            'cancel'     => 'Cancelled',
                        ];
                    @endphp
                    <tr>
                        <td class="tc-td-num">{{ $order->id }}</td>
                        <td><span class="tc-order-num">{{ $order->order_number }}</span></td>
                        <td><span class="tc-name">{{ $order->name }}</span></td>
                        <td><span class="tc-email">{{ $order->email }}</span></td>
                        <td><span class="tc-qty">{{ $order->quantity }}</span></td>
                        <td>
                            @foreach($shipping_charge as $data)
                                <span class="tc-amount">₱ {{ number_format($data, 2) }}</span>
                            @endforeach
                        </td>
                        <td><span class="tc-amount tc-amount--bold">₱ {{ number_format($order->total_amount, 2) }}</span></td>
                        <td>
                            <span class="tc-badge {{ $statusClasses[$order->status] ?? 'tc-badge-dark' }}">
                                {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="tc-action-btns">
                                <a href="{{ route('order.show', $order->id) }}"
                                   class="tc-btn-icon tc-btn-icon-warning"
                                   data-toggle="tooltip" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('order.edit', $order->id) }}"
                                   class="tc-btn-icon tc-btn-icon-primary"
                                   data-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                        class="tc-btn-icon tc-btn-icon-info viewHistoryBtn"
                                        data-id="{{ $order->id }}"
                                        data-toggle="tooltip" title="History">
                                    <i class="fas fa-history"></i>
                                </button>
                                <form method="POST" action="{{ route('order.destroy', [$order->id]) }}" style="display:inline;">
                                    @csrf
                                    @method('delete')
                                    <button type="button"
                                            class="tc-btn-icon tc-btn-icon-danger dltBtn"
                                            data-id="{{ $order->id }}"
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
            {{ $orders->links() }}
        </div>
        @else
            <div class="tc-empty-state">
                <i class="fas fa-shopping-cart"></i>
                <p>No orders found yet.</p>
            </div>
        @endif
    </div>
</div>

{{-- Order History Modal --}}
<div class="modal fade" id="orderHistoryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content tc-modal">
            <div class="tc-modal-header">
                <div class="tc-modal-title">
                    <div class="tc-title-icon tc-title-icon--sm">
                        <i class="fas fa-history"></i>
                    </div>
                    <h5>Order History</h5>
                </div>
                <button type="button" class="tc-modal-close" data-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="order-history-content">
                    <p class="text-center tc-loading">Loading...</p>
                </div>
            </div>
        </div>
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
    .tc-title-icon--sm { width: 32px; height: 32px; font-size: 13px; border-radius: 8px; }
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
    .tc-order-num { font-family: monospace; font-weight: 700; color: #6E43C1; font-size: 12px; background: #f0edfb; padding: 2px 8px; border-radius: 5px; }
    .tc-name { font-weight: 600; color: #1F2340; }
    .tc-email { color: #6b7280; font-size: 12px; }
    .tc-qty { font-weight: 600; color: #374151; }
    .tc-amount { color: #374151; }
    .tc-amount--bold { font-weight: 700; color: #1F2340; }

    /* Badges */
    .tc-badge {
        display: inline-flex; align-items: center;
        padding: 4px 10px; border-radius: 20px;
        font-size: 11px; font-weight: 600; letter-spacing: .3px;
        white-space: nowrap;
    }
    .tc-badge-new      { background: #dbeafe; color: #1d4ed8; }
    .tc-badge-process  { background: #fef3c7; color: #92400e; }
    .tc-badge-onway    { background: #e0f2fe; color: #0369a1; }
    .tc-badge-success  { background: #d1fae5; color: #065f46; }
    .tc-badge-primary  { background: #ede8fb; color: #6E43C1; }
    .tc-badge-danger   { background: #fee2e2; color: #dc2626; }
    .tc-badge-dark     { background: #f3f4f6; color: #374151; }

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
    .tc-btn-icon-warning { background: #fef3c7; color: #b45309; }
    .tc-btn-icon-warning:hover { background: #f59e0b; color: #fff; }
    .tc-btn-icon-info { background: #e0f2fe; color: #0369a1; }
    .tc-btn-icon-info:hover { background: #0284c7; color: #fff; }
    .tc-btn-icon-danger { background: #fee2e2; color: #dc2626; }
    .tc-btn-icon-danger:hover { background: #dc2626; color: #fff; }

    /* Pagination */
    .tc-pagination-wrap { display: flex; justify-content: flex-end; padding-top: 16px; }

    /* Empty state */
    .tc-empty-state { text-align: center; padding: 60px 20px; color: #9ca3af; }
    .tc-empty-state i { font-size: 40px; margin-bottom: 12px; display: block; }
    .tc-empty-state p { font-size: 15px; margin: 0; }

    /* Modal */
    .tc-modal { border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 8px 32px rgba(110,67,193,.15); }
    .tc-modal-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 24px;
        border-bottom: 1px solid #f0edfb;
        background: linear-gradient(135deg, #faf8ff 0%, #fff 100%);
    }
    .tc-modal-title { display: flex; align-items: center; gap: 10px; }
    .tc-modal-title h5 { margin: 0; font-size: 15px; font-weight: 700; color: #1F2340; }
    .tc-modal-close {
        background: #f3f0fb; border: none; border-radius: 8px;
        width: 32px; height: 32px;
        display: flex; align-items: center; justify-content: center;
        color: #6E43C1; cursor: pointer; font-size: 13px;
        transition: all .2s;
    }
    .tc-modal-close:hover { background: #6E43C1; color: #fff; }
    .tc-loading { color: #9ca3af; font-size: 13px; padding: 20px 0; }
</style>
@endpush

@push('scripts')
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
$('#order-dataTable').DataTable({
    "columnDefs": [
        { "orderable": false, "targets": [8] }
    ],
    "language": {
        "search": "Search:",
        "lengthMenu": "Show _MENU_ entries",
        "info": "Showing _START_ to _END_ of _TOTAL_ orders"
    }
});

$(document).ready(function(){
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // Delete confirmation
    $(document).on('click', '.dltBtn', function(e){
        var form = $(this).closest('form');
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this order!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then(function(willDelete){
            if(willDelete){ form.submit(); }
            else { swal("Your order is safe!"); }
        });
    });

    // View History
    $(document).on('click', '.viewHistoryBtn', function(){
        let orderId = $(this).data('id');
        $('#order-history-content').html('<p class="text-center tc-loading">Loading...</p>');
        $('#orderHistoryModal').modal('show');
        $.get("{{ url('admin/order-history') }}/" + orderId, function(data){
            $('#order-history-content').html(data);
        }).fail(function(){
            $('#order-history-content').html('<p class="text-danger text-center">Failed to load order history.</p>');
        });
    });
});
</script>
@endpush