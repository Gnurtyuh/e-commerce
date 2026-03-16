<div class="mb-3">
    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalImageAdd">
        <i class="fas fa-upload"></i> Tải lên hình ảnh
    </button>
</div>

<div class="row">
    @forelse($images as $img)
    <div class="col-md-3 col-sm-4 col-6 mb-4">
        <div class="card h-100 {{ filter_var($img['is_main'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 'border-success shadow' : '' }}">
            <img src="{{ isset($img['imagePath']) ? asset(ltrim($img['imagePath'], '/')) : '#' }}" class="card-img-top" alt="Product Image" style="object-fit: cover; height: 150px;">
            <div class="card-body p-2 text-center">
                @if(filter_var($img['is_main'] ?? false, FILTER_VALIDATE_BOOLEAN))
                    <span class="badge badge-success mb-2 d-block">Main Image</span>
                @else
                    <button class="btn btn-xs btn-outline-success btn-block mb-2 btn-set-main" data-id="{{ $img['imageId'] }}">
                        Đặt làm chính
                    </button>
                @endif
                <button class="btn btn-xs btn-outline-danger btn-block btn-delete-image" data-id="{{ $img['imageId'] }}">
                    <i class="fas fa-trash"></i> Xoá
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 mt-3 text-center text-muted">
        <div class="py-4">
            <i class="fas fa-image fa-3x mb-3 text-light"></i>
            <p>Chưa có hình ảnh nào được tải lên.</p>
        </div>
    </div>
    @endforelse
</div>

<!-- Modal Upload Image -->
<div class="modal fade" id="modalImageAdd" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formImageAdd" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Tải lên hình ảnh</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Chọn tệp hình ảnh <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="imageFile" name="file" accept="image/*" required>
                            <label class="custom-file-label" for="imageFile">Chọn tệp</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="isMainCheck" name="is_main" value="true">
                            <label for="isMainCheck" class="custom-control-label">Đặt làm hình ảnh chính</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="0" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="btnUploadImage">Tải lên</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    $('#formImageAdd').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let btn = $('#btnUploadImage');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');

        $.ajax({
            url: '/admin/products/{{ $id }}/images',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                if(res.success) {
                    $('.modal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    toastr.success('Image uploaded successfully');
                    loadImages();
                }
            },
            error: function(xhr) {
                let msg = 'Tải lên hình ảnh thất bại.';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                toastr.error(msg);
                btn.prop('disabled', false).text('Tải lên');
            }
        });
    });

    $('.btn-set-main').click(function() {
        let id = $(this).data('id');
        $.ajax({
            url: '/admin/images/' + id + '/main',
            type: 'PATCH',
            success: function(res) {
                if(res.success) {
                    toastr.success('Ảnh đã được đặt làm chính');
                    loadImages();
                }
            },
            error: function(xhr) {
                let msg = 'Có lỗi xảy ra khi cập nhật hình ảnh chính';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                toastr.error(msg);
            }
        });
    });

    $('.btn-delete-image').click(function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Delete Image?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/images/' + id,
                    type: 'DELETE',
                    success: function(res) {
                        if(res.success) {
                            toastr.success('Image deleted');
                            loadImages();
                        }
                    },
                    error: function(xhr) {
                        let msg = 'Có lỗi xảy ra khi xóa hình ảnh';
                        if(xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        toastr.error(msg);
                    }
                });
            }
        });
    });
</script>
