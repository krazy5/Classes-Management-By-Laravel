<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'MAK Tutorials Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Adding Font Awesome for icons and Google Fonts for better typography --}}
    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" xintegrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
        

        /* Profile Section Styles */
.sidebar-profile {
    margin-bottom: 25px;
    border-bottom: 1px solid #e9ecef;
    padding-bottom: 20px;
}

.sidebar-profile .profile-photo {
    width: 90px;
    height: 90px;
    border-radius: 50%; /* Makes the image round */
    object-fit: cover; /* Prevents image distortion */
    border: 3px solid #f0f0f0;
}

.sidebar-profile .profile-name {
    color: #343a40;
    font-weight: 600;
    font-size: 1.1rem;
    margin-top: 10px;
    margin-bottom: 2px;
}

.sidebar-profile .profile-title {
    color: #6c757d;
    font-size: 0.85rem;
    margin-bottom: 0;
}


        .sidebar {
            min-height: 100vh;
            background-color: #ffffff;
        }
        .sidebar a, .sidebar .dropdown-toggle {
            color: rgb(5, 0, 0);
            text-decoration: none;
        }
        .sidebar .nav-link:hover, .sidebar .dropdown-toggle:hover {
            background-color: #a4e77b;
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
@php
  

    $guard = null;
    if (Auth::guard('admin')->check()) {
        $guard = 'admin';
    } elseif (Auth::guard('student')->check()) {
        $guard = 'student';
    }
@endphp
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 d-none d-md-flex justify-content-between">
    <div>
        <a class="navbar-brand fw-bold" href="#">MAK Tutorials</a>
    </div>
    
    <ul class="navbar-nav flex-row align-items-center">
        @php
            $navNotifications = collect();
            $unreadCount = 0;

            if (auth()->guard('student')->check()) {
                $student = auth()->guard('student')->user();

                $navNotifications = \App\Models\Notification::where('is_active', true)
                    ->where(function ($query) use ($student) {
                        $query->where('student_id', $student->id)
                            ->orWhereNull('student_id')
                            ->orWhere('audience', 'student')
                            ->orWhere('audience', 'all');
                    })
                    ->latest()
                    ->take(5)
                    ->get();

                $unreadCount = $navNotifications->where('is_read', false)->count();
            }
        @endphp


        @if($guard === 'student')
        <li class="nav-item dropdown me-3">
            <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell fs-5 text-white"></i>
                @if($unreadCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationDropdown" style="width: 300px;">
                <li class="dropdown-header">Notifications</li>
                @forelse($navNotifications as $notify)
                    <li>
                        <a href="{{ route('notifications.read', $notify->id) }}" class="dropdown-item d-flex justify-content-between align-items-start">
                            <div class="me-2">
                                <strong>{{ $notify->title }}</strong><br>
                                <small class="text-muted">{{ Str::limit($notify->message, 40) }}</small>
                            </div>
                            @if(!$notify->is_read)
                                <span class="badge bg-success ms-2">New</span>
                            @endif
                        </a>
                    </li>
                @empty
                    <li><span class="dropdown-item text-muted">No notifications</span></li>
                @endforelse
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a href="{{ route('student.dashboard') }}" class="dropdown-item text-center text-primary">View All</a>
                </li>
            </ul>
        </li>
        @endif

        <li class="nav-item">
            <a class="nav-link text-white" href="#">
                <i class="bi bi-person-circle fs-5"></i>
            </a>
        </li>
    </ul>
</nav>




<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Mobile toggle button -->
    <nav class="navbar navbar-dark bg-dark d-md-none">
        <div class="container-fluid">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i class="bi bi-list"></i> Menu
            </button>
        </div>
    </nav>


    <!-- putting the bell icon -->

    


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
