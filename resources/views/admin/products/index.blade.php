@extends('admin.layouts.admin')

@section('title', 'Products')
@section('page_title', 'Product Management')

@section('content')

<!-- Filter Bar -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form action="{{ route('products.index') }}" method="GET" class="row align-items-end">
            <div class="col-md-4">
                <div class="form-group mb-0">
                    <label>Danh mục</label>
                    <select name="categoryId" class="form-control select2">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat['categoryId'] }}" {{ $categoryId == $cat['categoryId'] ? 'selected' : '' }}>
                                {{ $cat['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group mb-0">
                    <label>Tìm kiếm</label>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Tìm kiếm theo tên sản phẩm hoặc SKU...">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Lọc</button>
                    @if(request('category_id') || request('search'))
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Xoá</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-cubes mr-1"></i> Danh sách sản phẩm</h3>
        <div class="card-tools">
            <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Thêm sản phẩm
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped text-nowrap align-middle">
            <thead>
                <tr>
                    <th style="width: 50px">#</th>
                    <th>Name</th>
                    <th>Category ID</th>
                    <th>Status</th>
                    <th class="text-right">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="font-weight-bold">{{ $p['name'] }}</td>
                    <td>{{ $p['categoryId'] }}</td>
                    <td><x-status-badge :status="$p['status'] ?? 'ACTIVE'" /></td>
                    <td class="text-right">
                        <a href="{{ route('products.edit', $p['productId']) }}" class="btn btn-sm btn-info" title="Edit Product">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                        <button class="btn btn-sm btn-danger btn-delete"
                            data-id="{{ $p['productId'] }}"
                            data-name="{{ $p['name'] }}">
                            <i class="fas fa-trash"></i> Xoá
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Không tìm thấy sản phẩm.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('js')
<script>
    $('.btn-delete').click(function() {
        let id = $(this).data('id');
        let name = $(this).data('name');

        Swal.fire({
            title: 'Xoá sản phẩm',
            text: "Bạn có chắc chắn muốn xoá '" + name + "'?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Có, xoá nó!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#deleteForm').attr('action', '/admin/products/' + id).submit();
            }
        });
    });
</script>
@endpush
