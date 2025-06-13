<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2>Reset Password</h2>

    <form method="POST" action="{{ route('password.update') }}">
      @csrf

      {{-- Include the token from the emailed link --}}
      <input type="hidden" name="token" value="{{ $token }}">

      <div class="mb-3">
        <label for="email" class="form-label">E-Mail Address</label>
        <input
          id="email"
          type="email"
          name="email"
          value="{{ $email ?? old('email') }}"
          required
          autocomplete="email"
          autofocus
          class="form-control @error('email') is-invalid @enderror"
        >
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">New Password</label>
        <input
          id="password"
          type="password"
          name="password"
          required
          autocomplete="new-password"
          class="form-control @error('password') is-invalid @enderror"
        >
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="password-confirm" class="form-label">Confirm Password</label>
        <input
          id="password-confirm"
          type="password"
          name="password_confirmation"
          required
          autocomplete="new-password"
          class="form-control"
        >
      </div>

      <button type="submit" class="btn btn-primary">
        Reset Password
      </button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
