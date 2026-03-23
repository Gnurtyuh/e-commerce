@extends('admin.layouts.admin')

@section('title', 'Kho hàng')
@section('page_title', 'Quản lý kho hàng')

@section('content')

    <div class="card">

        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-warehouse mr-2" style="color:var(--primary);opacity:0.7;"></i> Kho hàng</h3>
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

                    @forelse ($variants as $v)
                        <tr>

                            <td><span style="font-weight:600;">#{{ $v['variantId'] }}</span></td>

                            <td style="color:var(--text-secondary);">{{ $v['productId'] }}</td>

                            <td class="font-weight-bold">{{ number_format($v['price'], 2) }} VND</td>

                            <td>
                                <span style="font-weight:600;{{ $v['stock'] <= 10 ? 'color:var(--danger);' : 'color:var(--text-primary);' }}">
                                    {{ $v['stock'] }}
                                </span>
                            </td>

                            <td>

                                @if ($v['stock'] > 10)
                                    <span class="badge badge-success">Còn hàng</span>
                                @elseif($v['stock'] > 0)
                                    <span class="badge badge-warning">Sắp hết</span>
                                @else
                                    <span class="badge badge-danger">Hết hàng</span>
                                @endif

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center" style="padding:32px;">
                                <i class="fas fa-warehouse" style="font-size:1.5rem;display:block;margin-bottom:8px;opacity:0.3;color:var(--text-muted);"></i>
                                <span style="color:var(--text-muted);">Không tìm thấy biến thể nào.</span>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>
        @if(is_object($variants) && method_exists($variants, 'hasPages') && $variants->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center">
            <span class="text-muted" style="font-size:0.8125rem;">
                Hiển thị {{ $variants->firstItem() }}–{{ $variants->lastItem() }} / {{ $variants->total() }} biến thể
            </span>
            {{ $variants->links() }}
        </div>
        @endif
    </div>

@endsection
