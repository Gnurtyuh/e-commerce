<div class="mb-3">
    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalVariantAdd">
        <i class="fas fa-plus"></i> Thêm biến thể
    </button>
</div>

<div class="table-responsive p-0 border">
    <table class="table table-striped table-hover text-nowrap align-middle mb-0">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                <th>Màu sắc</th>
                <th>Kích thước</th>
                <th>MÃ HÀNG</th>
                <th>Giá</th>
                <th>Còn hàng</th>
                <th class="text-right">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($variants as $v)
            <tr>
                <td>{{ $v['variantId'] }}</td>
                <td class="font-weight-bold">{{ $v['color'] ?? '-' }}</td>
                <td>{{ $v['size'] ?? '-' }}</td>
                <td>{{ $v['sku'] ?? '-' }}</td>
                <td class="text-success font-weight-bold">${{ number_format($v['price'] ?? 0, 2) }}</td>
                <td>
                    <span class="badge {{ ($v['stock'] ?? 0) > 0 ? 'badge-success' : 'badge-danger' }}">
                        {{ $v['stock'] ?? 0 }}
                    </span>
                </td>
                <td class="text-right">
                    <button class="btn btn-xs btn-info btn-edit-variant"
                        data-variant='@json($v)'
                        data-toggle="modal" data-target="#modalVariantEdit">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </button>
                    <button class="btn btn-xs btn-danger btn-delete-variant"
                        data-id="{{ $v['variantId'] }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4 text-muted">Không tìm thấy biến thể nào. Thêm một biến thể ở trên.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Add Variant -->
<div class="modal fade" id="modalVariantAdd" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formVariantAdd" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm biến thể</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="productId" value="{{ $id }}">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Màu sắc</label>
                            <input type="text" name="color" class="form-control" placeholder="e.g. Red, Blue">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Kích thước</label>
                            <input type="text" name="size" class="form-control" placeholder="e.g. S, M, XL">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Giá ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số lượng tồn kho <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control" required value="0" min="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>SKU</label>
                        <input type="text" name="sku" class="form-control" placeholder="Unique SKU">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" onclick="submitVariantForm('#formVariantAdd', '/admin/products/{{$id}}/variants', 'POST')" class="btn btn-primary">Lưu biến thể</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Variant -->
<div class="modal fade" id="modalVariantEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formVariantEdit" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Chỉnh sửa biến thể</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="variantId" id="edit_variant_id">
                    <input type="hidden" name="productId" value="{{ $id }}">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Màu sắc</label>
                            <input type="text" name="color" id="edit_color" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Kích thước</label>
                            <input type="text" name="size" id="edit_size" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Giá ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" id="edit_price" class="form-control" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số lượng tồn kho <span class="text-danger">*</span></label>
                            <input type="number" name="stock" id="edit_stock" class="form-control" required min="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>SKU</label>
                        <input type="text" name="sku" id="edit_sku" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" onclick="submitVariantForm('#formVariantEdit', '/admin/variants/' + $('#edit_variant_id').val(), 'PUT')" class="btn btn-primary">Update Variant</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('.btn-edit-variant').click(function() {
        let v = $(this).data('variant');
        $('#edit_variant_id').val(v.variantId);
        $('#edit_color').val(v.color);
        $('#edit_size').val(v.size);
        $('#edit_price').val(v.price);
        $('#edit_stock').val(v.stock);
        $('#edit_sku').val(v.sku);
    });

    function submitVariantForm(formId, url, method) {
        let data = $(formId).serialize();
        $(formId).find('button[type="button"].btn-primary').prop('disabled', true);

        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function(res) {
                if(res.success) {
                    $('.modal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    toastr.success('Biến thể đã được lưu thành công');
                    loadVariants(); // reload the inner HTML
                }
            },
            error: function(xhr) {
                let msg = 'Lỗi khi lưu biến thể';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                toastr.error(msg);
                $(formId).find('button[type="button"].btn-primary').prop('disabled', false);
            }
        });
    }

    $('.btn-delete-variant').click(function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Xóa biến thể?',
            text: 'Bạn không thể hoàn tác hành động này.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Có, xóa nó!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/variants/' + id,
                    type: 'DELETE',
                    success: function(res) {
                        if(res.success) {
                            toastr.success('Biến thể đã được xóa');
                            loadVariants();
                        }
                    },
                    error: function(xhr) {
                        let msg = 'Lỗi khi xóa biến thể';
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
