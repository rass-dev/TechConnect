@extends('backend.layouts.master')
@section('title', 'TechConnect | Dashboard')

@section('main-content')

@php
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

$userCount       = User::where('role', 'user')->count();
$adminCount      = User::whereIn('role', ['admin', 'superadmin'])->count();
$totalOrders     = Order::count();
$pendingOrders   = Order::where('status', 'new')->count();
$deliveredOrders = Order::whereIn('status', ['delivered', 'completed'])->count();
$cancelledOrders = Order::where('status', 'cancel')->count();
$totalRevenue    = Order::whereIn('status', ['delivered', 'completed'])->sum('total_amount');

$revenueChart = $revenueChart ?? ['labels' => [], 'delivered' => [], 'cancelled' => []];
$paymentChart = $paymentChart ?? [
    'labels' => ['Online', 'Cash on Delivery'],
    'counts' => [0, 0],
    'amounts' => [0, 0],
];
$productList = Product::pluck('title')->values();
@endphp

<div class="tc-dashboard">
    <div class="tc-dashboard-head">
        <div>
            <h1 class="tc-dashboard-title">Dashboard</h1>
            <p class="tc-dashboard-subtitle">Overview of store activity, revenue, and payment methods</p>
        </div>
    </div>

    <div class="tc-stat-grid">
        <div class="tc-stat-card">
            <div class="tc-stat-icon"><i class="fas fa-users"></i></div>
            <div>
                <div class="tc-stat-label">Users</div>
                <div class="tc-stat-value">{{ $userCount }}</div>
            </div>
        </div>
        <div class="tc-stat-card">
            <div class="tc-stat-icon"><i class="fas fa-user-shield"></i></div>
            <div>
                <div class="tc-stat-label">Admins</div>
                <div class="tc-stat-value">{{ $adminCount }}</div>
            </div>
        </div>
        <div class="tc-stat-card">
            <div class="tc-stat-icon tc-stat-icon--orders">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div>
                <div class="tc-stat-label">Orders</div>
                <div class="tc-stat-value">{{ $totalOrders }}</div>
            </div>
        </div>
        <div class="tc-stat-card">
            <div class="tc-stat-icon"><i class="fas fa-clock"></i></div>
            <div>
                <div class="tc-stat-label">Pending</div>
                <div class="tc-stat-value">{{ $pendingOrders }}</div>
            </div>
        </div>
        <div class="tc-stat-card">
            <div class="tc-stat-icon"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="tc-stat-label">Delivered</div>
                <div class="tc-stat-value">{{ $deliveredOrders }}</div>
            </div>
        </div>
        <div class="tc-stat-card">
            <div class="tc-stat-icon"><i class="fas fa-times-circle"></i></div>
            <div>
                <div class="tc-stat-label">Cancelled</div>
                <div class="tc-stat-value">{{ $cancelledOrders }}</div>
            </div>
        </div>
        <div class="tc-stat-card tc-stat-card--revenue">
            <div class="tc-stat-icon tc-stat-icon--light"><i class="fas fa-wallet"></i></div>
            <div>
                <div class="tc-stat-label">Total Revenue</div>
                <div class="tc-stat-value">₱{{ number_format($totalRevenue, 2) }}</div>
            </div>
        </div>
    </div>

    <div class="tc-analytics-grid">
        {{-- Revenue chart --}}
        <div class="tc-chart-card">
            <div class="tc-chart-header">
                <div>
                    <h6>Revenue (Delivered &amp; Cancelled Orders)</h6>
                    <p class="tc-chart-subtitle">Compare fulfilled vs cancelled order amounts</p>
                </div>
                <div class="tc-chart-controls">
                    <div class="tc-field">
                        <label class="tc-field-label" for="revenueType">Period</label>
                        <select id="revenueType" class="tc-select">
                            <option value="yearly">Yearly</option>
                            <option value="monthly" selected>Monthly</option>
                            <option value="daily">Daily</option>
                        </select>
                    </div>
                    <div class="tc-field tc-field--search">
                        <label class="tc-field-label" for="revenueSearch">Product</label>
                        <div class="tc-search-wrap">
                            <input type="text" id="revenueSearch" class="tc-input" placeholder="Filter by product..." autocomplete="off">
                            <i class="fas fa-search search-icon"></i>
                            <div id="productSuggestions" class="tc-suggestions"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tc-chart-summary">
                <div class="tc-chart-metric">
                    <span class="tc-chart-metric-label">Delivered total</span>
                    <strong id="deliveredTotal" class="tc-text-success">₱ 0.00</strong>
                </div>
                <div class="tc-chart-metric">
                    <span class="tc-chart-metric-label">Cancelled total</span>
                    <strong id="cancelledTotal" class="tc-text-danger">₱ 0.00</strong>
                </div>
            </div>

            <div class="tc-chart-legend">
                <span class="tc-legend-item"><i class="tc-legend-dot tc-legend-dot--delivered"></i> Delivered</span>
                <span class="tc-legend-item"><i class="tc-legend-dot tc-legend-dot--cancelled"></i> Cancelled</span>
            </div>

            <div class="tc-chart-body">
                <div id="chartEmpty" class="tc-chart-empty" style="display:none;">
                    <i class="fas fa-chart-bar"></i>
                    <p>No order data for this period yet.</p>
                    <span>Charts update when orders are recorded.</span>
                </div>
                <div class="tc-chart-canvas-wrap">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Payment method pie chart --}}
        <div class="tc-chart-card tc-chart-card--payment">
            <div class="tc-chart-header">
                <div>
                    <h6>Payment Methods</h6>
                    <p class="tc-chart-subtitle">Online vs Cash on Delivery</p>
                </div>
            </div>

            <div class="tc-chart-body tc-chart-body--pie">
                <div id="pieEmpty" class="tc-chart-empty" style="display:none;">
                    <i class="fas fa-chart-pie"></i>
                    <p>No payment data yet.</p>
                </div>
                <div class="tc-chart-canvas-wrap">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>

            <div class="tc-payment-legend" id="paymentLegend">
                <div class="tc-payment-legend-item">
                    <span class="tc-legend-dot tc-legend-dot--online"></span>
                    <div>
                        <strong>Online</strong>
                        <span id="onlineCount">0 orders</span>
                    </div>
                </div>
                <div class="tc-payment-legend-item">
                    <span class="tc-legend-dot tc-legend-dot--cod"></span>
                    <div>
                        <strong>Cash on Delivery</strong>
                        <span id="codCount">0 orders</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function initDashboardCharts() {
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded.');
        return;
    }

    const revenueUrl = "{{ route('product.order.dashboard') }}";
    const paymentUrl = "{{ route('admin.dashboard.payments') }}";

    const initialRevenue = @json($revenueChart);
    const initialPayment = @json($paymentChart);

    const barCanvas = document.getElementById('barChart');
    const pieCanvas = document.getElementById('pieChart');
    const emptyState = document.getElementById('chartEmpty');
    const pieEmpty = document.getElementById('pieEmpty');
    const deliveredTotalEl = document.getElementById('deliveredTotal');
    const cancelledTotalEl = document.getElementById('cancelledTotal');
    const onlineCountEl = document.getElementById('onlineCount');
    const codCountEl = document.getElementById('codCount');

    let barChart = null;
    let pieChart = null;
    let productList = @json($productList);

    Chart.defaults.global.defaultFontFamily = 'Inter, Nunito, sans-serif';
    Chart.defaults.global.defaultFontColor = '#6B7289';

    function formatMoney(value, decimals) {
        var n = parseFloat(value);
        if (!isFinite(n)) n = 0;
        decimals = (decimals === undefined || decimals === null) ? 0 : decimals;
        return n.toLocaleString('en-PH', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        });
    }

    function number_format(number, decimals) {
        return formatMoney(number, decimals == null ? 2 : decimals);
    }

    function sumValues(values) {
        return (values || []).reduce(function (sum, v) { return sum + (parseFloat(v) || 0); }, 0);
    }

    function hasChartData(delivered, cancelled) {
        return sumValues(delivered) > 0 || sumValues(cancelled) > 0;
    }

    function renderBarChart(data) {
        const labels = data.labels || [];
        const delivered = data.delivered || [];
        const cancelled = data.cancelled || [];

        deliveredTotalEl.textContent = '₱ ' + number_format(sumValues(delivered), 2);
        cancelledTotalEl.textContent = '₱ ' + number_format(sumValues(cancelled), 2);

        if (barChart) {
            barChart.destroy();
            barChart = null;
        }

        if (!hasChartData(delivered, cancelled)) {
            barCanvas.parentElement.style.display = 'none';
            emptyState.style.display = 'flex';
            return;
        }

        barCanvas.parentElement.style.display = 'block';
        emptyState.style.display = 'none';

        barChart = new Chart(barCanvas, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Delivered',
                        backgroundColor: 'rgba(153, 110, 248, 0.9)',
                        borderColor: '#6E43C1',
                        borderWidth: 1,
                        hoverBackgroundColor: '#6E43C1',
                        data: delivered
                    },
                    {
                        label: 'Cancelled',
                        backgroundColor: 'rgba(239, 68, 68, 0.75)',
                        borderColor: '#DC2626',
                        borderWidth: 1,
                        hoverBackgroundColor: '#DC2626',
                        data: cancelled
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { top: 4, right: 4, bottom: 0, left: 0 } },
                scales: {
                    xAxes: [{
                        gridLines: { display: false },
                        ticks: { fontColor: '#6B7289', fontSize: 11, maxRotation: 45, maxTicksLimit: 12 }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontColor: '#6B7289',
                            fontSize: 11,
                            callback: function (value) {
                                if (value === undefined || value === null || value === '') return '';
                                var num = Number(value);
                                if (!isFinite(num)) return '';
                                return '₱' + formatMoney(num, 0);
                            }
                        },
                        gridLines: { color: 'rgba(110, 67, 193, 0.08)', borderDash: [4, 4] }
                    }]
                },
                legend: { display: false },
                tooltips: {
                    backgroundColor: '#fff',
                    bodyFontColor: '#1F2340',
                    titleFontColor: '#1F2340',
                    borderColor: 'rgba(110, 67, 193, 0.15)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function (tooltipItem, chartData) {
                            const label = chartData.datasets[tooltipItem.datasetIndex].label || '';
                            return label + ': ₱ ' + number_format(tooltipItem.yLabel, 2);
                        }
                    }
                }
            }
        });

        setTimeout(function () {
            if (barChart) barChart.resize();
        }, 50);
    }

    function renderPieChart(data) {
        const amounts = data.amounts || [0, 0];
        const counts = data.counts || [0, 0];
        const total = sumValues(amounts);

        onlineCountEl.textContent = counts[0] + ' order' + (counts[0] === 1 ? '' : 's') + ' · ₱' + number_format(amounts[0], 2);
        codCountEl.textContent = counts[1] + ' order' + (counts[1] === 1 ? '' : 's') + ' · ₱' + number_format(amounts[1], 2);

        if (pieChart) {
            pieChart.destroy();
            pieChart = null;
        }

        const orderTotal = (counts[0] || 0) + (counts[1] || 0);

        if (total <= 0 && orderTotal <= 0) {
            pieCanvas.parentElement.style.display = 'none';
            pieEmpty.style.display = 'flex';
            return;
        }

        pieCanvas.parentElement.style.display = 'block';
        pieEmpty.style.display = 'none';

        const pieValues = total > 0 ? amounts : counts;

        pieChart = new Chart(pieCanvas, {
            type: 'doughnut',
            data: {
                labels: data.labels || ['Online', 'Cash on Delivery'],
                datasets: [{
                    data: pieValues,
                    backgroundColor: ['#6E43C1', '#996EF8'],
                    borderColor: '#fff',
                    borderWidth: 3,
                    hoverBackgroundColor: ['#361E6E', '#6E43C1']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 62,
                legend: { display: false },
                tooltips: {
                    backgroundColor: '#fff',
                    bodyFontColor: '#1F2340',
                    titleFontColor: '#1F2340',
                    borderColor: 'rgba(110, 67, 193, 0.15)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function (tooltipItem, chartData) {
                            const value = chartData.datasets[0].data[tooltipItem.index];
                            const count = counts[tooltipItem.index] || 0;
                            return chartData.labels[tooltipItem.index] + ': ₱' + number_format(value, 2) + ' (' + count + ' orders)';
                        }
                    }
                }
            }
        });

        setTimeout(function () {
            if (pieChart) pieChart.resize();
        }, 50);
    }

    function fetchJson(url, params) {
        const query = params ? '?' + new URLSearchParams(params).toString() : '';
        return fetch(url + query, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin'
        }).then(function (res) {
            if (!res.ok) throw new Error('Request failed');
            return res.json();
        });
    }

    function fetchRevenue() {
        const type = document.getElementById('revenueType').value;
        const product = document.getElementById('revenueSearch').value.trim();

        fetchJson(revenueUrl, { type: type, product: product })
            .then(renderBarChart)
            .catch(function () { renderBarChart(initialRevenue); });
    }

    function fetchPayments() {
        fetchJson(paymentUrl)
            .then(renderPieChart)
            .catch(function () { renderPieChart(initialPayment); });
    }

    renderBarChart(initialRevenue);
    renderPieChart(initialPayment);

    document.getElementById('revenueType').addEventListener('change', fetchRevenue);

    const suggestionsDiv = document.getElementById('productSuggestions');
    const searchInput = document.getElementById('revenueSearch');

    suggestionsDiv.addEventListener('click', function (e) {
        if (e.target.classList.contains('tc-suggestion-item')) {
            searchInput.value = e.target.textContent;
            suggestionsDiv.style.display = 'none';
            fetchRevenue();
        }
    });

    searchInput.addEventListener('input', function () {
        const value = this.value.toLowerCase();
        suggestionsDiv.innerHTML = '';
        if (!value) {
            suggestionsDiv.style.display = 'none';
            fetchRevenue();
            return;
        }
        const filtered = productList.filter(function (p) { return p.toLowerCase().includes(value); });
        if (!filtered.length) {
            suggestionsDiv.style.display = 'none';
            return;
        }
        filtered.slice(0, 8).forEach(function (product) {
            const div = document.createElement('div');
            div.className = 'tc-suggestion-item';
            div.textContent = product;
            suggestionsDiv.appendChild(div);
        });
        suggestionsDiv.style.display = 'block';
    });

    searchInput.addEventListener('change', fetchRevenue);

    document.addEventListener('click', function (e) {
        if (!searchInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
            suggestionsDiv.style.display = 'none';
        }
    });

    fetchPayments();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDashboardCharts);
} else {
    initDashboardCharts();
}
</script>
@endpush