<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NURSESmed – Forgot Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8fafc;
      min-height: 100vh;
      display: flex;
      align-items: center;
    }
    .reset-box {
      max-width: 400px;
      margin: 2rem auto;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 6px 24px rgba(0,0,0,0.10);
      padding: 2.5rem;
      text-align: center;
    }
    .brand-logo {
      width: 64px;
      margin-bottom: 1.2rem;
    }
    h2 {
      font-weight: 700;
      margin-bottom: .5rem;
      color: #155293;
      letter-spacing: 1px;
    }
    .form-label {
      font-weight: 500;
    }
    .btn-primary {
      background: #155293;
      border: none;
      font-weight: 600;
      letter-spacing: .5px;
    }
    .btn-primary:hover {
      background: #1161a6;
    }
    .text-muted {
      font-size: 0.98rem;
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>
  <div class="reset-box">
    <img src="{{ asset('nursesmed-logo.png') }}" alt="NURSESmed" class="brand-logo">

    <h2>NURSESmed</h2>
    <div class="text-muted mb-4">Forgot your password? Enter your email below and we’ll send you a link to reset it.</div>

    @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
      @csrf

      <div class="mb-3 text-start">
        <label for="email" class="form-label">E-Mail Address</label>
        <input
          id="email"
          type="email"
          name="email"
          value="{{ old('email') }}"
          required
          autocomplete="email"
          autofocus
          class="form-control @error('email') is-invalid @enderror"
        >
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary w-100">
        Send Password Reset Link
      </button>
    </form>
    <div class="mt-3">
      <a href="{{ route('login') }}" class="text-secondary">Back to Login</a>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
