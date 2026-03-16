@extends('admin.layouts.admin')

@section('title', 'Quản lý đơn hàng')
@section('page_title', 'Danh sách đơn hàng')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tất cả đơn hàng</h3>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped text-nowrap">
            <thead>
                <tr>
                    <th>ID đơn hàng</th>
                    <th>ID người dùng</th>
                    <th>Tổng số tiền</th>
                    <th>Trạng thái</th>
                    <th>Được tạo tại</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody>
                @forelse($orders as $o)
                <tr>
                    <td>#{{ $o['orderId'] }}</td>

                    <td>{{ $o['userId'] }}</td>

                    <td class="font-weight-bold text-success">
                        {{ number_format($o['totalAmount'], 2) }} VND
                    </td>

                    <td>
                        <x-status-badge :status="$o['status']" />
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($o['createdAt'])->format('Y-m-d H:i') }}
                    </td>

                    <td>
                        <a href="{{ route('orders.show', $o['orderId']) }}"
                           class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Xem
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Không tìm thấy đơn hàng nào.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>
@endsection
