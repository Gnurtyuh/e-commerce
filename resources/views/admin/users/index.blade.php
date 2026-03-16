@extends('admin.layouts.admin')

@section('title', 'Quản lý người dùng')
@section('page_title', 'Danh sách người dùng')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tất cả người dùng</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped text-nowrap">
                <thead>
                    <tr>
                        <th>ID người dùng</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Điện thoại</th>
                        <th>Vai trò</th>
                        <th>Trạng thái</th>
                        <th>Được tạo tại</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr>
                            <td>{{ substr($u['userId'], 0, 8) }}..</td>
                            <td>{{ $u['fullName'] ?? 'N/A' }}</td>
                            <td>{{ $u['email'] }}</td>
                            <td>{{ $u['phone'] ?? 'N/A' }}</td>
                            <td><x-status-badge :status="$u['role']" /></td>
                            <td><x-status-badge :status="$u['status']" /></td>
                            <td>{{ \Carbon\Carbon::parse($u['createdAt'])->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Không tìm thấy người dùng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
