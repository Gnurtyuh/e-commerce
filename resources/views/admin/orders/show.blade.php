@extends('admin.layouts.admin')

@section('title', 'Chi tiết đơn hàng')
@section('page_title', 'Đơn hàng #' . ($order['orderId'] ?? ''))

@section('content')

    <div class="row">

        <div class="col-md-4">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-receipt mr-2" style="color:var(--primary);opacity:0.7;"></i> Thông tin đơn hàng</h3>
                </div>

                <div class="card-body">

                    <dl class="row mb-0">

                        <dt class="col-sm-5">ID đơn hàng</dt>
                        <dd class="col-sm-7"><span style="font-weight:600;">#{{ $order['orderId'] ?? '-' }}</span></dd>

                        <dt class="col-sm-5">ID người dùng</dt>
                        <dd class="col-sm-7">{{ $order['userId'] ?? '-' }}</dd>

                        <dt class="col-sm-5">Tổng cộng</dt>
                        <dd class="col-sm-7 font-weight-bold text-success">
                            {{ number_format($order['totalAmount'] ?? 0, 2) }} VND
                        </dd>

                        <dt class="col-sm-5">Trạng thái</dt>
                        <dd class="col-sm-7">
                            <x-status-badge :status="$order['status'] ?? 'PENDING'" />
                        </dd>

                        <dt class="col-sm-5">Ngày tạo</dt>
                        <dd class="col-sm-7" style="color:var(--text-secondary);">
                            {{ isset($order['createdAt']) ? \Carbon\Carbon::parse($order['createdAt'])->format('Y-m-d H:i') : '-' }}
                        </dd>

                    </dl>

                </div>
            </div>
        </div>


        <div class="col-md-8">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-boxes mr-2" style="color:var(--primary);opacity:0.7;"></i> Sản phẩm trong đơn hàng</h3>
                </div>

                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap">

                        <thead>
                            <tr>
                                <th>ID mặt hàng</th>
                                <th>ID biến thể</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tổng phụ</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($items as $i)
                                <tr>

                                    <td style="color:var(--text-secondary);">{{ $i['orderItemId'] ?? '-' }}</td>

                                    <td style="color:var(--text-secondary);">{{ $i['variantId'] ?? '-' }}</td>

                                    <td><span style="font-weight:600;">{{ $i['quantity'] ?? 0 }}</span></td>

                                    <td>{{ number_format($i['price'] ?? 0, 2) }} VND</td>

                                    <td class="text-success font-weight-bold">
                                        {{ number_format(($i['quantity'] ?? 0) * ($i['price'] ?? 0), 2) }} VND
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center" style="padding:32px;">
                                        <i class="fas fa-inbox" style="font-size:1.5rem;display:block;margin-bottom:8px;opacity:0.3;color:var(--text-muted);"></i>
                                        <span style="color:var(--text-muted);">Không tìm thấy sản phẩm nào trong đơn hàng này.</span>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>
            </div>
        </div>

    </div>

@endsection
