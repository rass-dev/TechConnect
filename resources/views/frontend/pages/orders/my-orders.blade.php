@extends('frontend.layouts.master')

@section('main-content')
    <section id="my-orders" class="my-orders section" style="padding-top:120px; padding-bottom:80px;">
        <div class="container-fluid">
            <div class="row justify-content-center">

                <!-- Orders Card -->
                <div class="col-12">
                    <div class="box card-style">
                        <div class="title mb-4 text-center">
                            <h2 class="fw-bold">My Orders</h2>
                        </div>

                        @php
                            $currentTab = request()->segment(2) ?? 'to-process';
                            $tabs = [
                                'to-process' => 'To Process',
                                'to-ship' => 'To Ship',
                                'to-receive' => 'To Receive',
                                'complete-delivered' => 'Complete Delivered',
                                'cancelled' => 'Cancelled'
                            ];
                        @endphp

                        <!-- Tabs -->
                        <ul class="nav nav-tabs modern-tabs mb-4" id="ordersTab" role="tablist">
                            @foreach($tabs as $key => $label)
                                <li class="nav-item flex-fill text-center">
                                    <a class="nav-link {{ $currentTab == $key ? 'active' : '' }}"
                                        href="{{ route('orders.' . $key) }}">
                                        {{ $label }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

<!-- Orders Content -->
<div class="tab-content">
    @foreach($tabs as $key => $label)
        <div class="tab-pane fade {{ $currentTab == $key ? 'show active' : '' }}">
            @yield('orders-content') <!-- THIS WILL LOAD THE TAB SPECIFIC CONTENT -->
        </div>
    @endforeach
</div>

                    </div>
                </div>
                <!-- /Orders Card -->

            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Card Style */
        .card-style {
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background: #fff;
            width: 100%;
            min-height: calc(100vh - 220px);
            /* Full viewport minus header/footer space */
        }

        /* Tabs */
        .modern-tabs {
            border-bottom: none;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .modern-tabs .nav-item.flex-fill {
            flex: 1 1 auto;
            text-align: center;
        }

        .modern-tabs .nav-link {
            border: none;
            border-radius: 12px;
            color: #555;
            font-weight: 600;
            padding: 12px 20px;
            background: #f2f2f2;
            transition: all 0.3s ease;
            margin: 4px;
        }

        .modern-tabs .nav-link.active {
            background: linear-gradient(90deg, #986EF9, #6B5BFF);
            color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .modern-tabs .nav-link:hover {
            background: #e6e6e6;
        }

        /* Order Card */
        .order-card {
            background: #fafafa;
            border-left: 6px solid #986EF9;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .order-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
        }

        /* Status Badges */
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: capitalize;
            color: #fff;
        }

        .status-new,
        .status-process {
            background: #f0ad4e;
        }

        .status-on_the_way {
            background: #5bc0de;
        }

        .status-delivered {
            background: #0275d8;
        }

        .status-completed {
            background: #5cb85c;
        }

        .status-cancel {
            background: #d9534f;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .modern-tabs {
                flex-direction: column;
            }

            .card-style {
                padding: 25px;
                min-height: auto;
            }
        }
    </style>
@endpush