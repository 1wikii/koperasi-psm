@extends('layouts.admin-layout')

@section('title')
    <title>Dashboard</title>
@endsection

@section('main')
    <div class="p-6 space-y-6" x-data="charts()" x-init="init()">
        <!-- Header -->
        <div>
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <p class="text-gray-600">Selamat datang kembali! Berikut ini yang sedang terjadi di toko Anda hari ini.</p>
        </div>

        <!-- Stats Cards -->
        <div class="w-full flex justify-center items-center">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-[auto_auto_auto_auto] gap-6 mx-auto">

                <!-- Total Orders -->
                <div
                    class="w-60 bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600">Total Pesanan</div>
                        <div class="text-2xl font-bold mt-1">{{ $totalOrders }}</div>
                        <div class="text-green-600 text-sm mt-1">+{{ $ordersThisWeek }} pesanan minggu ini</div>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <!-- Heroicon: Clipboard Document -->
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 2h6a2 2 0 0 1 2 2v1h1a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h1V4a2 2 0 0 1 2-2z" />
                        </svg>
                    </div>
                </div>

                <!-- Total Payments -->
                <div
                    class="w-60 bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600">Total Pendapatan</div>
                        <div class="text-2xl font-bold mt-1">Rp.{{ number_format($totalRevenue, 0, ',', '.') }}</div>
                        <div class="text-green-600 text-sm mt-1">+{{ $revenueThisWeek }} dari minggu ini</div>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <!-- Heroicon: Credit Card -->
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 8.25h19.5m-19.5 3h19.5m-16.5 6h13.5a2.25 2.25 0 0 0 2.25-2.25v-7.5A2.25 2.25 0 0 0 18.75 5.25H5.25A2.25 2.25 0 0 0 3 7.5v7.5A2.25 2.25 0 0 0 5.25 17.25z" />
                        </svg>
                    </div>
                </div>

                <!-- Returns -->
                <div
                    class="w-60 bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600">Pengembalian</div>
                        <div class="text-2xl font-bold mt-1">{{ $totalReturns }}</div>
                    </div>
                    <div class="bg-red-100 p-3 rounded-full">
                        <!-- Heroicon: Arrow U-turn Left -->
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 15l-6-6 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                        </svg>
                    </div>
                </div>

                <!-- Successfully Shipped -->
                <div
                    class="w-60 bg-white p-6 rounded-lg shadow-sm border border-gray-200 flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600">Barang Terkirim</div>
                        <div class="text-2xl font-bold mt-1">{{ $totalCompletedOrders }}</div>
                        <div class="text-green-600 text-sm mt-1">+{{ $completedOrdersThisWeek }} dari minggu ini</div>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <!-- Heroicon: Truck -->
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 7.5V18a2.25 2.25 0 0 0 2.25 2.25h1.5A2.25 2.25 0 0 0 9 18v-3h7.5a2.25 2.25 0 0 0 2.25-2.25V9.75A2.25 2.25 0 0 0 16.5 7.5H3zM21 16.5h-1.125a2.25 2.25 0 0 1-2.25-2.25v-1.5h2.25A1.125 1.125 0 0 1 21 13.875v2.625z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics + Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Analytics -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 lg:col-span-2">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Ringkasan Analisis Mingguan</h2>
                </div>
                <div class="h-64">
                    <canvas id="analyticsChart"></canvas>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-lg font-semibold mb-4">Tombol Cepat</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.products') }}"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200  hover:bg-gray-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Tambah Produk</span>
                    </a>
                    <a href="{{ route('admin.orders') }}"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 hover:bg-gray-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <span>Proses Pesanan</span>
                    </a>
                </div>

            </div>
        </div>

        <!-- Recent Orders & Payments -->
        <div class="grid grid-cols-1 gap-6">
            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-4 border-b">
                    <h2 class="text-lg font-semibold">Pesanan Terbaru</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-600">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-2 text-left">Pelanggan</th>
                                <th class="px-4 py-2 text-left">Order ID</th>
                                <th class="px-4 py-2 text-left">Jumlah</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestOrders as $order)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $order->customer_name }}</td>
                                    <td class="px-4 py-2">#{{ $order->order_number }}</td>
                                    <td class="px-4 py-2">Rp.{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-green-600">{{ ucfirst($order->status) }}</td>
                                    <td class="px-4 py-2">{{ $order->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Load Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        const dailyOrders = @json($dailyOrders);

        function charts() {
            return {
                chart: null,
                init() {
                    const ctx = document.getElementById('analyticsChart').getContext('2d');
                    this.chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                            datasets: [
                                {
                                    label: 'Pesanan',
                                    data: dailyOrders,
                                    borderColor: '#10b981',
                                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                                    borderWidth: 2,
                                    tension: 0.3,
                                    fill: true,
                                    pointRadius: 4,
                                    pointBackgroundColor: '#10b981'
                                },
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: true, position: 'bottom' }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1,
                                        callback: function (value) {
                                            return value.toFixed(0);
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            }
        }
    </script>
@endsection