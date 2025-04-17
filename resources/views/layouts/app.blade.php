<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISP Management</title>
    <!-- Add Bootstrap CSS for styling -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">ISP Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                {{--                <li class="nav-item active">--}}
                {{--                    <a class="nav-link" href="{{ route('devices.index') }}">Dashboard</a>--}}
                {{--                </li>--}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('devices.index') }}">MikroTik Devices</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('olts.index') }}">OLT Devices</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content Section -->
<div class="container mt-4">



    @yield('content') <!-- Content will be injected here -->
</div>

<!-- Footer Section -->
<footer class="bg-light py-3 mt-4">
    <div class="container text-center">
        <p>&copy; 2025 ISP Management System. All Rights Reserved.</p>
    </div>
</footer>

<!-- Add Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
