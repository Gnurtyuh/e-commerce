@extends('admin.layouts.admin')

@section('title', 'Payments')
@section('page_title', 'Payments Management')

@section('content')

    <div class="card">

        <div class="card-header">

            <h3 class="card-title"><i class="fas fa-credit-card mr-2" style="color:var(--primary);opacity:0.7;"></i> Thanh toán</h3>

            <div class="card-tools">
                <form action="{{ route('admin.payments.index') }}" method="GET" class="form-inline">

                    <div class="input-group" style="width:280px;">

                        <input type="text" name="order_id" class="form-control" placeholder="Tìm kiếm theo ID đơn hàng"
                            value="{{ $orderId }}">

                        <div class="input-group-append">

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>

                            @if ($orderId)
                                <a href="{{ route('admin.payments.index') }}" class="btn btn-default">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif

                        </div>
                    </div>
                </form>
            </div>

        </div>


        <div class="card-body table-responsive p-0">

            <table class="table table-hover text-nowrap">

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

                            <td><span style="font-weight:600;">#{{ $p['paymentId'] }}</span></td>

                            <td>
                                <a href="{{ route('orders.show', $p['orderId']) }}" style="color:var(--primary);font-weight:500;">
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

                            <td style="color:var(--text-secondary);">
                                {{ isset($p['paidAt']) ? \Carbon\Carbon::parse($p['paidAt'])->format('Y-m-d H:i') : 'N/A' }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center" style="padding:32px;">
                                <i class="fas fa-credit-card" style="font-size:1.5rem;display:block;margin-bottom:8px;opacity:0.3;color:var(--text-muted);"></i>
                                <span style="color:var(--text-muted);">Nhập ID đơn hàng để tìm thanh toán, hoặc không tìm thấy thanh toán nào.</span>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        @if(is_object($payments) && method_exists($payments, 'hasPages') && $payments->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center">
            <span class="text-muted" style="font-size:0.8125rem;">
                Hiển thị {{ $payments->firstItem() }}–{{ $payments->lastItem() }} / {{ $payments->total() }} thanh toán
            </span>
            {{ $payments->links() }}
        </div>
        @endif

    </div>


    @if ($orderId)
        <div class="card mt-4">

            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus-circle mr-2" style="color:var(--success);opacity:0.7;"></i> Ghi nhận thanh toán mới cho đơn hàng #{{ $orderId }}</h3>
            </div>

            <div class="card-body">

                <form action="{{ route('admin.payments.create', $orderId) }}" method="POST">

                    @csrf

                    <div class="row align-items-end">
                        <div class="col-md-4 form-group">
                            <label>Số tiền ($)</label>
                            <input type="number" step="0.01" name="amount" class="form-control" required placeholder="0.00">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Trạng thái</label>
                            <select name="status" class="form-control" required>
                                <option value="PAID">ĐÃ TRẢ</option>
                                <option value="PENDING">Đang chờ xử lý</option>
                                <option value="FAILED">THẤT BẠI</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-plus mr-1"></i> Thêm thanh toán
                            </button>
                        </div>
                    </div>

                </form>

            </div>

        </div>
    @endif

@endsection
