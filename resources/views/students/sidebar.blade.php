<h4 class="text-white mb-3">MAK Tutorials</h4>
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link" href="{{route('student.dashboard')}}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" href="{{ route('student.fees.details', ['id' => Auth::guard('student')->user()->id]) }}"><i class="bi bi-cash-coin me-2"></i> Fees</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('student.attendance.summary',['id' => Auth::guard('student')->user()->id]) }}"><i class="bi bi-calendar-check me-2"></i> Attendance</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-gear me-2"></i> Settings</a>
        <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item" href="{{ route('student.change.password.form') }}">Change Password</a></li>

            <li><a class="dropdown-item" href="{{route('student.logout')}}">Logout</a></li>
        </ul>
    </li>
</ul>
