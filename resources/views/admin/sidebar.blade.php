<nav class="sidebar">
    <div class="sidebar-profile text-center">
        <img src="{{ asset('/img/icon.png') }}" alt="Profile Photo" class="profile-photo">
        {{-- Replace the src above with the actual path to the user's photo --}}
        {{-- Example: {{ Auth::guard('admin')->user()->profile_photo_url ?? asset('images/default-avatar.png') }} --}}
        
        <h5 class="profile-name mt-2">
            {{Auth::guard('admin')->user()->full_name}}
            {{-- Replace with the actual user's name --}}
            {{-- Example: {{ Auth::guard('admin')->user()->name }} --}}
        </h5>
        <p class="profile-title">MAK Tutorials</p>
    </div>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{route('admin.dashboard')}}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('students.index') ? 'active' : '' }}" href="{{ route('students.index') }}">
                <i class="bi bi-people me-2"></i> Students
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('fees-records.index') ? 'active' : '' }}" href="{{ route('fees-records.index') }}">
                <i class="bi bi-cash-coin me-2"></i> Fees
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('attendance.index') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                <i class="bi bi-calendar-check me-2"></i> Attendance
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-gear me-2"></i> Settings
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('admin.change.password.form') }}">Change Password</a></li>
                <li><a class="dropdown-item" href="{{route('admin.logout')}}">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>

{{-- This PHP block for notifications is unchanged and kept at the end --}}
@php
    use App\Models\Notification;
    $latestNotifications = Notification::where('is_active', true)
        ->where(function ($query) {
            $query->where('audience', 'admin')
                  ->orWhere('audience', 'all');
        })
        ->latest()
        ->take(5)
        ->get();
@endphp