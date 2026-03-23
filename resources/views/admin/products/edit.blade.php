@extends('admin.layouts.admin')

@section('title', 'Chỉnh sửa sản phẩm')
@section('page_title', 'Chỉnh sửa sảm phẩm: ' . ($product['name'] ?? ''))

@section('content')

<div class="card card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-info-tab" data-toggle="pill" href="#custom-tabs-info" role="tab" aria-controls="custom-tabs-info" aria-selected="true">
                    <i class="fas fa-info-circle mr-1"></i> Thông tin cơ bản
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-variants-tab" data-toggle="pill" href="#custom-tabs-variants" role="tab" aria-controls="custom-tabs-variants" aria-selected="false">
                    <i class="fas fa-tags mr-1"></i> Số lượng & Giá
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-images-tab" data-toggle="pill" href="#custom-tabs-images" role="tab" aria-controls="custom-tabs-images" aria-selected="false">
                    <i class="fas fa-images mr-1"></i> Hình ảnh
                </a>
            </li>
        </ul>
    </div>

    <div class="card-body">
        <div class="tab-content" id="custom-tabs-four-tabContent">
            <!-- TAB: INFO -->
            <div class="tab-pane fade show active" id="custom-tabs-info" role="tabpanel" aria-labelledby="custom-tabs-info-tab">
                <form action="{{ route('products.update', $product['productId']) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $product['name'] ?? '' }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Danh mục <span class="text-danger">*</span></label>
                            <select name="categoryId" class="form-control select2" required>
                                <option value="">Chọn danh mục</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat['categoryId'] }}" {{ ($product['categoryId'] ?? '') == $cat['categoryId'] ? 'selected' : '' }}>
                                        {{ $cat['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="description" class="form-control" rows="4">{{ $product['description'] ?? '' }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ ($product['status'] ?? '') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="inactive" {{ ($product['status'] ?? '') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                        </select>
                    </div>

                    <div class="mt-4 d-flex" style="gap:8px;">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Cập nhật sản phẩm</button>
                        <a href="{{ route('products.index') }}" class="btn btn-default">Hủy</a>
                    </div>
                </form>
            </div>

            <!-- TAB: VARIANTS -->
            <div class="tab-pane fade" id="custom-tabs-variants" role="tabpanel" aria-labelledby="custom-tabs-variants-tab">
                <div id="variants-container" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Đang tải...</span>
                    </div>
                </div>
            </div>

            <!-- TAB: IMAGES -->
            <div class="tab-pane fade" id="custom-tabs-images" role="tabpanel" aria-labelledby="custom-tabs-images-tab">
                <div id="images-container" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Đang tải...</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    const productId = {{ $product['productId'] }};

    function loadVariants() {
        $.get('/admin/products/' + productId + '/variants', function(html) {
            $('#variants-container').html(html);
        });
    }

    function loadImages() {
        $.get('/admin/products/' + productId + '/images', function(html) {
            $('#images-container').html(html);
        });
    }

    $(document).ready(function() {
        // Only load data when tabs are clicked
        let variantsLoaded = false;
        let imagesLoaded = false;

        $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
            let target = $(e.target).attr("href");

            if (target === '#custom-tabs-variants' && !variantsLoaded) {
                loadVariants();
                variantsLoaded = true;
            } else if (target === '#custom-tabs-images' && !imagesLoaded) {
                loadImages();
                imagesLoaded = true;
            }
        });
    });
</script>
@endpush
