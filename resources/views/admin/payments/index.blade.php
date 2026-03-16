@extends('admin.layouts.admin')

@section('title', 'Payments')
@section('page_title', 'Payments Management')

@section('content')

    <div class="card">

        <div class="card-header">

            <form action="{{ route('admin.payments.index') }}" method="GET" class="form-inline">

                <div class="input-group">

                    <input type="text" name="order_id" class="form-control" placeholder="Search by Order ID"
                        value="{{ $orderId }}">

                    <div class="input-group-append">

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>

                        @if ($orderId)
                            <a href="{{ route('admin.payments.index') }}" class="btn btn-default">
                                Đặt lại
                            </a>
                        @endif

                    </div>
                </div>
            </form>

        </div>


        <div class="card-body table-responsive p-0">

            <table class="table table-hover table-striped text-nowrap">

                <thead>

                    <tr>
                        <th>ID thanh toán</th>
                        <th>ID đơn hàng</th>
                        <th>Số tiền</th>
                        <th>Trạng thái</th>
                        <th>Được thanh toán tại</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($payments as $p)
                        <tr>

                            <td>#{{ $p['paymentId'] }}</td>

                            <td>
                                <a href="{{ route('orders.show', $p['orderId']) }}">
                                    #{{ $p['orderId'] }}
                                </a>
                            </td>

                            <td>
                                <span class="text-success font-weight-bold">
                                    ${{ number_format($p['amount'], 2) }}
                                </span>
                            </td>

                            <td>
                                <x-status-badge :status="$p['status']" />
                            </td>

                            <td>
                                {{ isset($p['paidAt']) ? \Carbon\Carbon::parse($p['paidAt'])->format('Y-m-d H:i') : 'N/A' }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center">
                                Nhập ID đơn hàng để tìm thanh toán, hoặc không tìm thấy thanh toán nào.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    @if ($orderId)
        <div class="card mt-4">

            <div class="card-header">
                <h3 class="card-title">Ghi nhận thanh toán mới cho đơn hàng #{{ $orderId }}</h3>
            </div>

            <div class="card-body">

                <form action="{{ route('admin.payments.create', $orderId) }}" method="POST" class="form-inline">

                    @csrf

                    <label class="mr-2">Số tiền ($):</label>

                    <input type="number" step="0.01" name="amount" class="form-control mr-3" required>

                    <label class="mr-2">Trạng thái:</label>

                    <select name="status" class="form-control mr-3" required>

                        <option value="PAID">ĐÃ TRẢ</option>
                        <option value="PENDING">Đang chờ xử lý</option>
                        <option value="FAILED">THẤT BẠI</option>

                    </select>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus"></i> Thêm thanh toán
                    </button>

                </form>

            </div>

        </div>
    @endif

@endsection
