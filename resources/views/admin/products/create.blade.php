@extends('admin.layouts.admin')

@section('title', 'Create Product')
@section('page_title', 'Add New Product')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus-circle mr-2"></i> Thông tin sản phẩm</h3>
            </div>

            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="Nhập tên sản phẩm">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Danh mục <span class="text-danger">*</span></label>
                            <select name="categoryId" class="form-control select2" required>
                                <option value="">Chọn danh mục</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat['categoryId'] }}">{{ $cat['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Nhập mô tả sản phẩm"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="active">Hoạt động</option>
                            <option value="inactive">Không hoạt động</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer bg-light">
                    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:12px;">
                        <div>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Lưu & Tiếp tục</button>
                            <a href="{{ route('products.index') }}" class="btn btn-default ml-2">Hủy</a>
                        </div>
                        <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Các biến thể và hình ảnh có thể được thêm sau khi lưu.</small>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
