<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | E-Commerce</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="{{ asset('vendor/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/custom.css') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>E-Com</b> Quản lý</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Đăng nhập để bắt đầu phiên làm việc</p>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/admin/login') }}" method="post">
                @csrf
                <div class="form-group">
                    <label><i class="fas fa-envelope mr-1" style="font-size:0.75rem;color:var(--text-muted);"></i> Email</label>
                    <input type="email" name="email" class="form-control" placeholder="admin@example.com" required autofocus>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-lock mr-1" style="font-size:0.75rem;color:var(--text-muted);"></i> Mật khẩu</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block" style="padding:10px;font-weight:600;">
                    <i class="fas fa-sign-in-alt mr-1"></i> Đăng Nhập
                </button>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('vendor/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/js/adminlte.min.js') }}"></script>
</body>
</html>
