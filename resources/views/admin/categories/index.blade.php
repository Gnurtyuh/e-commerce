@extends('admin.layouts.admin')

@section('title', 'Danh mục')
@section('page_title', 'Quản lý danh mục')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-sitemap mr-1"></i> Cây danh mục</h3>
        <div class="card-tools">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCategory" id="btnCreateCategory">
                <i class="fas fa-plus"></i> Thêm Danh Mục
            </button>
        </div>
    </div>
        <div class="table-responsive p-0">
            <table class="table table-striped table-hover text-nowrap align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        {{-- <th style="width: 50px">ID</th> --}}
                        <th>Tên Danh Mục</th>
                        <th>ID Danh Mục Cha</th>
                        <th class="text-right" style="width: 150px">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                        <tr>
                            {{-- <td>{{ $cat['categoryId'] }}</td> --}}
                            <td class="font-weight-bold">{{ $cat['name'] }}</td>
                            <td>
                                @if(!empty($cat['parentId']))
                                    <span class="badge badge-info text-light">Parent ID {{ $cat['parentId'] }}</span>
                                @else
                                    <span class="badge badge-secondary">Cấp cao nhất</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <button class="btn btn-xs btn-info btn-edit-cat"
                                    data-id="{{ $cat['categoryId'] }}"
                                    data-name="{{ $cat['name'] }}"
                                    data-parent="{{ $cat['parentId'] }}"
                                    data-toggle="modal" data-target="#modalCategory">
                                    <i class="fas fa-edit"></i> Chỉnh sửa
                                </button>
                                <button class="btn btn-xs btn-danger btn-delete"
                                    data-id="{{ $cat['categoryId'] }}"
                                    data-name="{{ $cat['name'] }}">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Không tìm thấy danh mục nào. Click "Add Category" để tạo một danh mục mới.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCategory" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formCategory" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalCategoryLabel">Thêm Danh Mục</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên Danh Mục <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="catName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Danh Mục Cha</label>
                        <select name="parentId" id="catParent" class="form-control">
                            <option value="">-- None (Top Level) --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat['categoryId'] }}">{{ $cat['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu Danh Mục</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('js')
<script>
    $('#btnCreateCategory').click(function() {
        $('#modalCategoryLabel').text('Add Category');
        $('#formCategory').attr('action', '{{ route('categories.store') }}');
        $('#formMethod').val('POST');
        $('#catName').val('');
        $('#catParent').val('');
    });

    $('.btn-edit-cat').click(function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let parent = $(this).data('parent');

        $('#modalCategoryLabel').text('Edit Category: ' + name);
        $('#formCategory').attr('action', '/admin/categories/' + id);
        $('#formMethod').val('PUT');
        $('#catName').val(name);
        $('#catParent').val(parent || '');
    });

    $('.btn-delete').click(function() {
        let id = $(this).data('id');
        let name = $(this).data('name');

        Swal.fire({
            title: 'Xoá danh mục',
            text: "Bạn có chắc chắn muốn xóa '" + name + "'?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Có, xóa nó!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#deleteForm').attr('action', '/admin/categories/' + id).submit();
            }
        });
    });
</script>
@endpush
