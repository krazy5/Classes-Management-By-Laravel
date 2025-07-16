<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'MAK Tutorials Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
{{-- Adding Font Awesome for icons and Google Fonts for better typography --}}
    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" xintegrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
        
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar a, .sidebar .dropdown-toggle {
            color: white;
            text-decoration: none;
        }
        .sidebar .nav-link:hover, .sidebar .dropdown-toggle:hover {
            background-color: #495057;
        }
        .card-title {
            font-size: 1.25rem;
        }

         /* Custom styles for a more professional look */
        body {
            background-color: #f8f9fa; /* A lighter gray for the background */
            font-family: 'Poppins', sans-serif; /* A modern, clean font */
            min-height: 100vh;
        }

        .dashboard-heading {
            color: #343a40;
            font-weight: 700;
        }

        /* Enhanced card styles */
        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
            color: #fff;
            overflow: hidden; /* To contain the icon */
            position: relative;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-card .card-body {
            position: relative;
            z-index: 2;
        }

        .stat-card .card-title {
            font-weight: 600;
        }

        .stat-card .card-text {
            font-size: 2rem;
            font-weight: 700;
        }
        
        .stat-card .icon {
            position: absolute;
            top: 50%;
            right: -15px;
            transform: translateY(-50%);
            font-size: 5rem;
            opacity: 0.2;
            transition: all 0.3s ease;
            z-index: 1;
        }

        .stat-card:hover .icon {
            opacity: 0.3;
            transform: translateY(-50%) scale(1.1);
        }

        /* Custom gradient backgrounds for cards */
        .bg-gradient-primary { background: linear-gradient(45deg, #5664d2, #2435a1); }
        .bg-gradient-success { background: linear-gradient(45deg, #23b794, #057d65); }
        .bg-gradient-info { background: linear-gradient(45deg, #39a5d5, #1d72b8); }
        .bg-gradient-warning { background: linear-gradient(45deg, #f39c12, #e67e22); }
        .bg-gradient-danger { background: linear-gradient(45deg, #e74c3c, #c0392b); }
        .bg-gradient-secondary { background: linear-gradient(45deg, #6c757d, #343a40); }

        .chart-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .chart-card .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 600;
            color: #495057;
            border-radius: 12px 12px 0 0;
        }

    </style>

    @stack('styles')
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Mobile toggle button -->
    <nav class="navbar navbar-dark bg-dark d-md-none">
        <div class="container-fluid">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i class="bi bi-list"></i> Menu
            </button>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
                @php
                    use Illuminate\Support\Facades\Auth;

                    $guard = null;
                    if (Auth::guard('admin')->check()) {
                        $guard = 'admin';
                    } elseif (Auth::guard('student')->check()) {
                        $guard = 'student';
                    }
                @endphp

            <!-- Desktop Sidebar -->
            <div class="col-md-3 col-lg-2 d-none d-md-block sidebar p-3">
                @if($guard === 'admin')
                    @include('admin.sidebar')
                @elseif($guard === 'student')
                    @include('students.sidebar')
                @endif
            </div>

            <!-- Mobile Sidebar -->
            <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">MAK Tutorials</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    @if($guard === 'admin')
                        @include('admin.sidebar')
                    @elseif($guard === 'student')
                        @include('students.sidebar')
                    @endif
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
    <!-- Add this in layout/app.blade.php before closing </body> OR inside @section('scripts') -->


</body>
</html>
@endpush
