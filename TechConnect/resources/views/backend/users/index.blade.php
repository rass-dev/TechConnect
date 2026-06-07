@extends('backend.layouts.master')

@section('main-content')

<div class="tc-page-card">
    <div class="tc-page-card-header">
        <div class="tc-page-card-title">
            <i class="fas fa-users tc-title-icon"></i>
            <div>
                <h5>Users List</h5>
                <p>Manage all registered users</p>
            </div>
        </div>
        <a href="{{ route('users.create') }}" class="tc-btn-add">
            <i class="fas fa-plus"></i> Add User
        </a>
    </div>

    <div class="tc-page-card-body">
        @if(count($users) > 0)
        <div class="table-responsive">
            <table class="table tc-table" id="user-dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Photo</th>
                        <th>Joined</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $currentUser = auth()->user(); @endphp
                    @foreach($users as $user)
                    <tr class="{{ $currentUser->id === $user->id ? 'tc-row-self' : '' }}">
                        <td class="tc-td-num">{{ $user->id }}</td>
                        <td>
                            <div class="tc-user-cell">
                                @if($user->photo && file_exists(public_path($user->photo)))
                                    <img src="{{ asset($user->photo) }}" class="tc-user-photo" alt="{{ $user->name }}">
                                @else
                                    <div class="tc-user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                @endif
                                <div>
                                    <span class="tc-user-name">{{ $user->name }}</span>
                                    @if($currentUser->id === $user->id)
                                        <span class="tc-self-tag">You</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="tc-email">{{ $user->email }}</td>
                        <td>
                            @if($user->photo && file_exists(public_path($user->photo)))
                                <img src="{{ asset($user->photo) }}" class="tc-photo-thumb" alt="{{ $user->name }}">
                            @else
                                <img src="{{ asset('backend/img/avatar.png') }}" class="tc-photo-thumb" alt="avatar">
                            @endif
                        </td>
                        <td>
                            <span class="tc-date">{{ $user->created_at ? $user->created_at->format('M d, Y') : '' }}</span>
                            <span class="tc-time">{{ $user->created_at ? $user->created_at->diffForHumans() : '' }}</span>
                        </td>
                        <td>
                            @php
                                $roleClass = match($user->role) {
                                    'superadmin' => 'tc-role-super',
                                    'admin'      => 'tc-role-admin',
                                    default      => 'tc-role-user',
                                };
                            @endphp
                            <span class="tc-role-badge {{ $roleClass }}">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td>
                            @if($user->status == 'active')
                                <span class="tc-badge tc-badge-success">Active</span>
                            @else
                                <span class="tc-badge tc-badge-warning">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="tc-action-btns">
                                @if($currentUser->id === $user->id)
                                    <span class="tc-logged-in-tag">
                                        <i class="fas fa-user-check"></i> Logged In
                                    </span>
                                @elseif($currentUser->role === 'superadmin')
                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="tc-btn-icon tc-btn-icon-primary"
                                       data-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline;">
                                        @csrf
                                        @method('delete')
                                        <button type="button"
                                                class="tc-btn-icon tc-btn-icon-danger dltBtn"
                                                data-id="{{ $user->id }}"
                                                data-toggle="tooltip" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @elseif($currentUser->role === 'admin' && $user->role === 'user')
                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="tc-btn-icon tc-btn-icon-primary"
                                       data-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline;">
                                        @csrf
                                        @method('delete')
                                        <button type="button"
                                                class="tc-btn-icon tc-btn-icon-danger dltBtn"
                                                data-id="{{ $user->id }}"
                                                data-toggle="tooltip" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="tc-no-action">—</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tc-pagination-wrap">
            {{ $users->links() }}
        </div>
        @else
            <div class="tc-empty-state">
                <i class="fas fa-users"></i>
                <p>No users found. <a href="{{ route('users.create') }}">Add the first user</a></p>
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

    /* Add button */
    .tc-btn-add {
        display: inline-flex; align-items: center; gap: 7px;
        background: linear-gradient(135deg, #6E43C1, #996EF8);
        color: #fff;
        padding: 9px 18px;
        border-radius: 9px;
        font-size: 13px; font-weight: 600;
        text-decoration: none;
        transition: all .2s;
        box-shadow: 0 4px 12px rgba(110,67,193,.25);
    }
    .tc-btn-add:hover {
        background: linear-gradient(135deg, #5a34a8, #7c58e0);
        color: #fff; text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(110,67,193,.35);
    }

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
    .tc-row-self { background: #f8f5ff !important; }
    .tc-table tbody td {
        padding: 13px 16px;
        font-size: 13px;
        color: #374151;
        border-bottom: 1px solid #f3f0fb;
        vertical-align: middle;
    }
    .tc-td-num { font-weight: 600; color: #9ca3af; font-size: 12px; }

    /* User cell */
    .tc-user-cell { display: flex; align-items: center; gap: 10px; }
    .tc-user-photo {
        width: 36px; height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ede8fb;
        flex-shrink: 0;
    }
    .tc-user-avatar {
        width: 36px; height: 36px;
        background: linear-gradient(135deg, #6E43C1, #996EF8);
        color: #fff; border-radius: 50%;
        font-size: 14px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .tc-user-name { font-weight: 600; color: #1F2340; font-size: 13px; display: block; }
    .tc-self-tag {
        display: inline-block;
        background: #ede8fb; color: #6E43C1;
        font-size: 10px; font-weight: 700;
        padding: 1px 6px; border-radius: 4px;
        margin-top: 2px;
    }

    /* Photo thumb */
    .tc-photo-thumb {
        width: 40px; height: 40px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #f0edfb;
    }

    /* Email */
    .tc-email { color: #6b7280; font-size: 12px; }

    /* Date/time stacked */
    .tc-date { display: block; font-size: 13px; color: #374151; font-weight: 500; }
    .tc-time { display: block; font-size: 11px; color: #9ca3af; }

    /* Role badges */
    .tc-role-badge {
        display: inline-flex; align-items: center;
        padding: 4px 10px; border-radius: 20px;
        font-size: 11px; font-weight: 600; letter-spacing: .3px;
    }
    .tc-role-super { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .tc-role-admin { background: #ede8fb; color: #6E43C1; border: 1px solid #c4b5fd; }
    .tc-role-user  { background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; }

    /* Status badges */
    .tc-badge {
        display: inline-flex; align-items: center;
        padding: 4px 10px; border-radius: 20px;
        font-size: 11px; font-weight: 600; letter-spacing: .3px;
    }
    .tc-badge-success { background: #d1fae5; color: #065f46; }
    .tc-badge-warning { background: #fef3c7; color: #92400e; }

    /* Action buttons */
    .tc-action-btns { display: flex; align-items: center; gap: 6px; justify-content: center; }
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

    /* Logged-in tag */
    .tc-logged-in-tag {
        display: inline-flex; align-items: center; gap: 5px;
        background: #ede8fb; color: #6E43C1;
        padding: 5px 10px; border-radius: 8px;
        font-size: 11px; font-weight: 600;
        white-space: nowrap;
    }

    /* No action */
    .tc-no-action { color: #d1d5db; font-size: 16px; }

    /* Pagination */
    .tc-pagination-wrap { display: flex; justify-content: flex-end; padding-top: 16px; }

    /* Empty state */
    .tc-empty-state { text-align: center; padding: 60px 20px; color: #9ca3af; }
    .tc-empty-state i { font-size: 40px; margin-bottom: 12px; display: block; }
    .tc-empty-state p { font-size: 15px; margin: 0; }
    .tc-empty-state a { color: #6E43C1; }
</style>
@endpush

@push('scripts')
<script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
$('#user-dataTable').DataTable({
    "columnDefs": [
        { "orderable": false, "targets": [3, 7] }
    ],
    "language": {
        "search": "Search:",
        "lengthMenu": "Show _MENU_ entries",
        "info": "Showing _START_ to _END_ of _TOTAL_ users"
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
            text: "Once deleted, you will not be able to recover this user!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then(function(willDelete){
            if(willDelete){ form.submit(); }
            else { swal("User data is safe!"); }
        });
    });
});
</script>
@endpush