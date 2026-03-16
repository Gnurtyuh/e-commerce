@extends('admin.layouts.admin')

@section('title', 'Chi tiết đơn hàng')
@section('page_title', 'Đơn hàng #' . ($order['orderId'] ?? ''))

@section('content')

    <div class="row">

        <div class="col-md-4">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Thông tin đơn hàng</h3>
                </div>

                <div class="card-body">

                    <dl class="row mb-0">

                        <dt class="col-sm-4">ID đơn hàng</dt>
                        <dd class="col-sm-8">#{{ $order['orderId'] ?? '-' }}</dd>

                        <dt class="col-sm-4">ID người dùng</dt>
                        <dd class="col-sm-8">{{ $order['userId'] ?? '-' }}</dd>

                        <dt class="col-sm-4">Tổng cộng</dt>
                        <dd class="col-sm-8 font-weight-bold text-success">
                            {{ number_format($order['totalAmount'] ?? 0, 2) }} VND
                        </dd>

                        <dt class="col-sm-4">Trạng thái</dt>
                        <dd class="col-sm-8">
                            <x-status-badge :status="$order['status'] ?? 'PENDING'" />
                        </dd>

                        <dt class="col-sm-4">Ngày tạo</dt>
                        <dd class="col-sm-8">
                            {{ isset($order['createdAt']) ? \Carbon\Carbon::parse($order['createdAt'])->format('Y-m-d H:i') : '-' }}
                        </dd>

                    </dl>

                </div>
            </div>
        </div>


        <div class="col-md-8">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Sản phẩm trong đơn hàng</h3>
                </div>

                <div class="card-body table-responsive p-0">

                    <table class="table table-hover table-striped text-nowrap">

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

                                    <td>{{ $i['orderItemId'] ?? '-' }}</td>

                                    <td>{{ $i['variantId'] ?? '-' }}</td>

                                    <td>{{ $i['quantity'] ?? 0 }}</td>

                                    <td>${{ number_format($i['price'] ?? 0, 2) }}</td>

                                    <td class="text-success font-weight-bold">
                                        ${{ number_format(($i['quantity'] ?? 0) * ($i['price'] ?? 0), 2) }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center">
                                        Không tìm thấy sản phẩm nào trong đơn hàng này.
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
