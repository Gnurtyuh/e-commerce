@extends('admin.layouts.admin')

@section('title', 'Quản lý đơn hàng')
@section('page_title', 'Danh sách đơn hàng')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-shopping-cart mr-2" style="color:var(--primary);opacity:0.7;"></i> Tất cả đơn hàng</h3>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
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
                    <td><span style="font-weight:600;">#{{ $o['orderId'] }}</span></td>

                    <td style="color:var(--text-secondary);">{{ $o['userId'] }}</td>

                    <td class="font-weight-bold text-success">
                        {{ number_format($o['totalAmount'], 2) }} VND
                    </td>

                    <td>
                        <x-status-badge :status="$o['status']" />
                    </td>

                    <td style="color:var(--text-secondary);">
                        {{ \Carbon\Carbon::parse($o['createdAt'])->format('Y-m-d H:i') }}
                    </td>

                    <td>
                        <a href="{{ route('orders.show', $o['orderId']) }}"
                           class="btn btn-sm btn-info">
                            <i class="fas fa-eye mr-1"></i> Xem
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding:32px;">
                        <i class="fas fa-inbox" style="font-size:1.5rem;display:block;margin-bottom:8px;opacity:0.3;color:var(--text-muted);"></i>
                        <span style="color:var(--text-muted);">Không tìm thấy đơn hàng nào.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(is_object($orders) && method_exists($orders, 'hasPages') && $orders->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span class="text-muted" style="font-size:0.8125rem;">
            Hiển thị {{ $orders->firstItem() }}–{{ $orders->lastItem() }} / {{ $orders->total() }} đơn hàng
        </span>
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
