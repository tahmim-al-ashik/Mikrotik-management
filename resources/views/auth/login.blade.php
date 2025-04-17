<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Login</div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

                <H4>
                    <p><strong> Login credentials: <br> email:test@example.com <br> Password: password123</strong></p>
                </H4>
            </div>
        </div>
    </div>
</div>
</body>
</html>
