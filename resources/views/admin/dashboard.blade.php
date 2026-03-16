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
                    <h3 class="card-title">Doanh thu theo tháng</h3>
                </div>

                <div class="card-body">
                    <canvas id="revenueChart" style="min-height:250px;height:250px"></canvas>
                </div>

            </div>
        </div>


        <div class="col-lg-6">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Đơn hàng theo ngày</h3>
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
                    <h3 class="card-title">Đơn hàng gần đây</h3>
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

                                    <td>#{{ $o['orderId'] }}</td>

                                    <td class="text-success font-weight-bold">
                                        {{ number_format($o['totalAmount'], 2) }} VND
                                    </td>

                                    <td>
                                        <x-status-badge :status="$o['status']" />
                                    </td>

                                    <td>
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
                                    <td colspan="5" class="text-center">
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
    <x-stat-card title="Hàng tồn kho thấp" :value="$lowStock" icon="exclamation-triangle" color="danger"
        url="{{ route('inventory.index') }}" />

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
                    backgroundColor: '#28a745',
                    data: revData
                }]
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
                    borderColor: '#17a2b8',
                    data: ordData,
                    fill: false,
                    tension: 0.1
                }]
            }
        });
    </script>
@endpush
