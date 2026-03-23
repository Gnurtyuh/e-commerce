@extends('admin.layouts.admin')

@section('title', 'Trang chủ')
@section('page_title', 'Trang chủ quản trị')

@section('content')

    <div class="row">

        <div class="col-lg-3 col-6">
            <x-stat-card title="Doanh thu trung bình" :value="'VND ' . number_format($totalRevenue, 2)" icon="dollar-sign" color="success"
                url="{{ route('orders.index') }}" />
        </div>

        <div class="col-lg-3 col-6">
            <x-stat-card title="Tổng số đơn hàng" :value="$totalOrders" icon="shopping-bag" color="info"
                url="{{ route('orders.index') }}" />
        </div>

        <div class="col-lg-3 col-6">
            <x-stat-card title="Tổng số sản phẩm" :value="$totalProducts" icon="box" color="warning"
                url="{{ route('products.index') }}" />
        </div>

        <div class="col-lg-3 col-6">
            <x-stat-card title="Tổng số người dùng" :value="$totalUsers" icon="users" color="primary"
                url="{{ route('users.index') }}" />
        </div>

    </div>


    <div class="row">

        <div class="col-lg-6">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-bar mr-2" style="color:var(--success);opacity:0.7;"></i> Doanh thu theo tháng</h3>
                </div>

                <div class="card-body">
                    <canvas id="revenueChart" style="min-height:250px;height:250px"></canvas>
                </div>

            </div>
        </div>


        <div class="col-lg-6">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-line mr-2" style="color:var(--info);opacity:0.7;"></i> Đơn hàng theo ngày</h3>
                </div>

                <div class="card-body">
                    <canvas id="ordersChart" style="min-height:250px;height:250px"></canvas>
                </div>

            </div>
        </div>

    </div>


    <div class="row">

        <div class="col-12">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clock mr-2" style="color:var(--primary);opacity:0.7;"></i> Đơn hàng gần đây</h3>
                </div>

                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap">

                        <thead>
                            <tr>
                                <th>ID đơn hàng</th>
                                <th>Số tiền</th>
                                <th>Trạng thái</th>
                                <th>Ngày</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($recentOrders as $o)
                                <tr>

                                    <td><span style="font-weight:600;color:var(--text-primary);">#{{ $o['orderId'] }}</span></td>

                                    <td class="text-success font-weight-bold">
                                        {{ number_format($o['totalAmount'], 2) }} VND
                                    </td>

                                    <td>
                                        <x-status-badge :status="$o['status']" />
                                    </td>

                                    <td style="color:var(--text-secondary);">
                                        {{ \Carbon\Carbon::parse($o['createdAt'])->format('Y-m-d H:i') }}
                                    </td>

                                    <td>
                                        <a href="{{ route('orders.show', $o['orderId']) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center" style="padding:32px;color:var(--text-muted);">
                                        <i class="fas fa-inbox" style="font-size:1.5rem;display:block;margin-bottom:8px;opacity:0.3;"></i>
                                        Không tìm thấy đơn đặt hàng gần đây.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-6">
            <x-stat-card title="Hàng tồn kho thấp" :value="$lowStock" icon="exclamation-triangle" color="danger"
                url="{{ route('inventory.index') }}" />
        </div>
    </div>

@endsection


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const revLabels = @json($revenueByMonth->keys());
        const revData = @json($revenueByMonth->values());

        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: revLabels,
                datasets: [{
                    label: 'Doanh thu (VND)',
                    backgroundColor: '#10b981',
                    borderRadius: 6,
                    borderSkipped: false,
                    data: revData
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Inter', size: 11 } }
                    },
                    y: {
                        grid: { color: '#f3f4f6' },
                        ticks: { font: { family: 'Inter', size: 11 } }
                    }
                }
            }
        });

        const ordLabels = @json($ordersByDay->keys());
        const ordData = @json($ordersByDay->values());

        new Chart(document.getElementById('ordersChart'), {
            type: 'line',
            data: {
                labels: ordLabels,
                datasets: [{
                    label: 'Đơn hàng',
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.08)',
                    data: ordData,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#4f46e5',
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Inter', size: 11 } }
                    },
                    y: {
                        grid: { color: '#f3f4f6' },
                        ticks: { font: { family: 'Inter', size: 11 } }
                    }
                }
            }
        });
    </script>
@endpush
