@extends('admin.layouts.admin')

@section('title', 'Quản lý người dùng')
@section('page_title', 'Danh sách người dùng')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-users mr-2" style="color:var(--primary);opacity:0.7;"></i> Tất cả người dùng</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
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
                            <td style="color:var(--text-muted);font-family:monospace;font-size:0.8125rem;">{{ substr($u['userId'], 0, 8) }}..</td>
                            <td class="font-weight-bold">{{ $u['fullName'] ?? 'N/A' }}</td>
                            <td>{{ $u['email'] }}</td>
                            <td style="color:var(--text-secondary);">{{ $u['phone'] ?? 'N/A' }}</td>
                            <td><x-status-badge :status="$u['role']" /></td>
                            <td><x-status-badge :status="$u['status']" /></td>
                            <td style="color:var(--text-secondary);">{{ \Carbon\Carbon::parse($u['createdAt'])->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center" style="padding:32px;">
                                <i class="fas fa-users" style="font-size:1.5rem;display:block;margin-bottom:8px;opacity:0.3;color:var(--text-muted);"></i>
                                <span style="color:var(--text-muted);">Không tìm thấy người dùng nào.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(is_object($users) && method_exists($users, 'hasPages') && $users->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center">
            <span class="text-muted" style="font-size:0.8125rem;">
                Hiển thị {{ $users->firstItem() }}–{{ $users->lastItem() }} / {{ $users->total() }} người dùng
            </span>
            {{ $users->links() }}
        </div>
        @endif
    </div>
@endsection
