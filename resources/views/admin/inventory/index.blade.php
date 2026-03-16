@extends('admin.layouts.admin')

@section('title', 'Inventory')
@section('page_title', 'Inventory Management')

@section('content')

    <div class="card">

        <div class="card-header">
            <h3 class="card-title">Kho hàng</h3>
        </div>

        <div class="card-body table-responsive p-0">

            <table class="table table-hover">

                <thead>

                    <tr>
                        <th>ID biến thể</th>
                        <th>ID sản phẩm</th>
                        <th>Giá</th>
                        <th>Còn hàng</th>
                        <th>Trạng thái</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($variants as $v)
                        <tr>

                            <td>#{{ $v['variantId'] }}</td>

                            <td>{{ $v['productId'] }}</td>

                            <td>${{ number_format($v['price'], 2) }}</td>

                            <td>{{ $v['stock'] }}</td>

                            <td>

                                @if ($v['stock'] > 10)
                                    <span class="badge badge-success">In Stock</span>
                                @elseif($v['stock'] > 0)
                                    <span class="badge badge-warning">Low Stock</span>
                                @else
                                    <span class="badge badge-danger">Out of Stock</span>
                                @endif

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    </div>

@endsection
