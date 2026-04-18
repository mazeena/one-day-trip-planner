<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - TripMalwana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
       body {
            font-family: 'Lato', sans-serif;
            background: linear-gradient(135deg, #1a6b3a 0%, #2d8a52 60%, #1a6b3a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 20px;
            padding: 48px 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
            width: 100%;
            max-width: 420px;
        }
        .login-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            color: #1a6b3a;
            text-align: center;
            margin-bottom: 8px;
        }
        .login-logo span { color: #f0a500; }
        .login-subtitle {
            text-align: center;
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 32px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 16px;
            border: 1.5px solid #e0e0e0;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: #1a6b3a;
            box-shadow: 0 0 0 3px rgba(26,107,58,0.12);
        }
        .input-group-text {
            background: #f8f9f4;
            border-radius: 10px 0 0 10px;
            border: 1.5px solid #e0e0e0;
            color: #1a6b3a;
        }
        .btn-login {
            background: #1a6b3a;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            width: 100%;
            transition: background 0.2s;
        }
        .btn-login:hover { background: #124d2a; }
        .back-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.87rem;
        }
        .back-link a { color: #1a6b3a; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <i class="fas fa-map-marked-alt me-2"></i>Trip<span>Malwana</span>
        </div>
        <p class="login-subtitle"><i class="fas fa-lock me-1"></i> Admin Panel Access</p>

        @if($errors->any())
            <div class="alert alert-danger rounded-3 py-2 mb-3" style="font-size: 0.88rem;">
                <i class="fas fa-exclamation-triangle me-1"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" class="form-control"
                           value="{{ old('username') }}" placeholder="Enter username" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                    <input type="password" name="password" class="form-control"
                           placeholder="Enter password" required>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Login to Admin Panel
            </button>
        </form>

        <div class="back-link">
            <a href="{{ route('home') }}"><i class="fas fa-arrow-left me-1"></i>Back to Website</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
