@extends('backend.layouts.master')
@section('title', 'TechConnect | Dashboard')
@section('main-content')

@php
use App\Models\User;
use App\Models\Order;

// Fetch counts
$userCount  = User::where('role','user')->count();
$adminCount = User::where('role','admin')->count();
$totalOrders = Order::count();
$pendingOrders = Order::where('status','new')->count();
$deliveredOrders = Order::where('status','delivered')->count();
$cancelledOrders = Order::where('status','cancelled')->count();
$totalRevenue = Order::where('status','delivered')->sum('total_amount');
@endphp

<div class="container-fluid">
    @include('backend.layouts.notification')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0" style="color:#2C175E;">Dashboard</h1>
    </div>

    <!-- Top Stats Row -->
    <div class="row">

        <!-- Users Box -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="background-color:#2C175E; border-left:.25rem solid #9870F9;">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1" style="color:#EEE9FE;">Users</div>
                    <div class="h5 mb-0 font-weight-bold" style="color:#EEE9FE;">{{ $userCount }}</div>
                </div>
            </div>
        </div>

        <!-- Admins Box -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="background-color:#9870F9; border-left:.25rem solid #2E1B60;">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1" style="color:#EEE9FE;">Admins</div>
                    <div class="h5 mb-0 font-weight-bold" style="color:#EEE9FE;">{{ $adminCount }}</div>
                </div>
            </div>
        </div>

        <!-- Orders Boxes -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="background-color:#2E1B60; border-left:.25rem solid #351F6C;">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1" style="color:#EEE9FE;">Orders</div>
                    <div class="h5 mb-0 font-weight-bold" style="color:#EEE9FE;">{{ $totalOrders }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="background-color:#351F6C; border-left:.25rem solid #9870F9;">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1" style="color:#EEE9FE;">Pending</div>
                    <div class="h5 mb-0 font-weight-bold" style="color:#EEE9FE;">{{ $pendingOrders }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="background-color:#9870F9; border-left:.25rem solid #2C175E;">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1" style="color:#EEE9FE;">Delivered</div>
                    <div class="h5 mb-0 font-weight-bold" style="color:#EEE9FE;">{{ $deliveredOrders }}</div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card shadow h-100 py-2" style="background-color:#2C175E; border-left:.25rem solid #351F6C;">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1" style="color:#EEE9FE;">Cancelled</div>
                    <div class="h5 mb-0 font-weight-bold" style="color:#EEE9FE;">{{ $cancelledOrders }}</div>
                </div>
            </div>
        </div>

        <!-- Total Revenue Box -->
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card shadow h-100 py-2" style="background-color:#2E1B60; border-left:.25rem solid #9870F9;">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1" style="color:#EEE9FE;">Total Revenue</div>
                    <div class="h5 mb-0 font-weight-bold" style="color:#EEE9FE;">
                        ₱ {{ number_format($totalRevenue,2) }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bar Chart Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Search Bar - MALINAO -->
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold" style="color:#2C175E;">Revenue (Delivered Orders)</h6>
                    <div class="d-flex" style="gap:10px;">
                        <select id="revenueType" class="form-control" style="max-width:120px;">
                            <option value="daily">Daily</option>
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                        <input type="text" id="revenueSearch" class="form-control" placeholder="Search product...">
                        <div id="productSuggestions" class="dropdown-menu" style="width:100%; max-height:200px; overflow-y:auto; position:absolute; z-index:1000; display:none;"></div>
                    </div>
                </div>
                <div class="card-body" style="height:400px;">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript">
const url = "{{ route('product.order.dashboard') }}"; // Updated route name from 'income' to 'product.order.dashboard' - MALINAO

Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#2C175E';

function number_format(number, decimals=2, dec_point='.', thousands_sep=',') {
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = Math.abs(decimals),
        s = '',
        toFixedFix = function(n, prec) { var k = Math.pow(10, prec); return '' + Math.round(n * k) / k; };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, thousands_sep);
    if ((s[1] || '').length < prec) s[1] = s[1] || '';
    while((s[1].length < prec)) { s[1] += '0'; }
    return s.join(dec_point);
}
// Bar Chart Updated - MALINAO
var ctx = document.getElementById("barChart");
var chartInstance = null;

function fetchRevenue() {
    const type = document.getElementById('revenueType').value;
    const product = document.getElementById('revenueSearch').value.trim();

    axios.get(url, { params: { type, product } })
    .then(function (response) {
        const data_keys = Object.keys(response.data);
        const data_values = Object.values(response.data);

        if (chartInstance) chartInstance.destroy();

        chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data_keys,
                datasets: [{
                    label: type.charAt(0).toUpperCase() + type.slice(1) + " Revenue",
                    backgroundColor: '#9870F9',
                    borderColor: '#2C175E',
                    borderWidth: 1,
                    hoverBackgroundColor: '#2E1B60',
                    hoverBorderColor: '#351F6C',
                    data: data_values
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{ gridLines: { display: false } }],
                    yAxes: [{
                        ticks: { beginAtZero:true, callback: function(value){ return '₱ '+number_format(value); } },
                        gridLines: { color: "rgb(234,236,244)" }
                    }]
                },
                legend: { display: false },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#2C175E",
                    titleFontColor: "#2C175E",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    callbacks: { label: function(tooltipItem) { return '₱ '+number_format(tooltipItem.yLabel); } }
                }
            }
        });
    })
    .catch(function (error) { console.log(error); });
}

// Initial load
fetchRevenue();
document.getElementById('revenueType').addEventListener('change', fetchRevenue);
document.getElementById('revenueSearch').addEventListener('change', fetchRevenue);

// When a product is selected from dropdown
const suggestionsDiv = document.getElementById('productSuggestions');
suggestionsDiv.addEventListener('click', function(e) {
    if (e.target.classList.contains('dropdown-item')) {
        document.getElementById('revenueSearch').value = e.target.textContent;
        suggestionsDiv.style.display = 'none';
        fetchRevenue();
    }
});

// Autocomplete for product search
let productList = [];

axios.get("{{ route('admin.products.list') }}")
    .then(function(response) {
        productList = response.data;
    });

const searchInput = document.getElementById('revenueSearch');

searchInput.addEventListener('input', function() {
    const value = this.value.toLowerCase();
    suggestionsDiv.innerHTML = '';
    if (!value) {
        suggestionsDiv.style.display = 'none';
        return;
    }
    // Filter products
    const filtered = productList.filter(product => product.toLowerCase().includes(value));
    if (filtered.length === 0) {
        suggestionsDiv.style.display = 'none';
        return;
    }
    filtered.forEach(product => {
        const div = document.createElement('div');
        div.className = 'dropdown-item';
        div.textContent = product;
        div.onclick = function() {
            searchInput.value = product;
            suggestionsDiv.style.display = 'none';
            // Optionally trigger your search/filter logic here
        };
        suggestionsDiv.appendChild(div);
    });
    suggestionsDiv.style.display = 'block';
});

// Hide dropdown when clicking outside
document.addEventListener('click', function(e) {
    if (!searchInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
        suggestionsDiv.style.display = 'none';
    }
});
</script>
/* Custom styles for dropdown */
<style>
    /* Custom styles for dropdown  - MALINAO*/
/* Style for product suggestions dropdown */
#productSuggestions {
    border: 1px solid #ccc;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    position: absolute;
    left: 0;
    top: 100%;
    width: 100%;
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
}
#productSuggestions .dropdown-item {
    padding: 8px 16px;
    cursor: pointer;
    font-size: 15px;
    color: #2C175E;
    border-bottom: 1px solid #f2f2f2;
    background: #fff;
    transition: background 0.2s;
}
#productSuggestions .dropdown-item:last-child {
    border-bottom: none;
}
#productSuggestions .dropdown-item:hover {
    background: #EEE9FE;
    color: #9870F9;
}
.d-flex {
    position: relative; /* Needed for absolute dropdown positioning */
}
</style>
@endpush
