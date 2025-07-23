<!DOCTYPE html>
<html lang="en">
<head>
    <title>MAK TUTORIALS | A Perfect Place To Learn.</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <style>
        /* Professional Font & Basic Reset */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Body Styling */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f2f5; /* Light gray background */
            overflow: hidden;
        }

        /* Main container for the forms */
        .wrapper {
            position: relative;
            width: 400px;
            background: #fff;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: height 0.3s ease;
        }

        /* Common style for both form wrappers */
        .form-wrapper {
            display: none; /* Hide both forms by default */
            flex-direction: column;
            align-items: center;
            width: 100%;
            transition: opacity 0.4s ease-in-out;
        }

        /* Class to show the active form */
        .form-wrapper.active {
            display: flex;
        }

        /* Form Header */
        h2 {
            font-size: 28px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Input field container */
        .input-group {
            position: relative;
            width: 100%;
            margin: 25px 0;
        }

        .input-group label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            font-size: 16px;
            color: #888;
            padding: 0 5px;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .input-group input {
            width: 100%;
            height: 45px;
            font-size: 16px;
            color: #333;
            padding: 0 15px;
            background: transparent;
            border: 1px solid #ccc;
            outline: none;
            border-radius: 5px;
        }

        /* Floating label effect */
        .input-group input:focus~label,
        .input-group input:valid~label {
            top: 0;
            font-size: 12px;
            color: #007bff; /* Accent color on focus */
            background: #fff;
        }

        .input-group input:focus {
            border-color: #007bff; /* Accent color on focus */
        }

        /* "Remember Me" checkbox styling */
        .remember-me-group {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #555;
            margin: -10px 0 20px 5px;
        }

        .remember-me-group input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* Submit Button */
        .btn {
            width: 100%;
            height: 45px;
            background-color: #007bff; /* Professional blue */
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            border-radius: 5px;
            border: none;
            outline: none;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        /* Link to switch between forms */
        .sign-link {
            font-size: 14px;
            text-align: center;
            margin-top: 25px;
        }

        .sign-link p {
            color: #555;
        }

        .sign-link p a {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }

        .sign-link p a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="form-wrapper admin-form active">
            <form action='{{route('admin.login.submit')}}' method="post">
                @csrf
                <h2>ADMIN LOGIN</h2>
                <div class="input-group">
                    <input type="text" name="email" required>
                    <label for="">Email</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password" required>
                    <label for="">Password</label>
                </div>
                <div class="remember-me-group">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember Me</label>
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="sign-link">
                    <p>Not an Admin? <a href="#" class="toggle-link">Student Login</a></p>
                </div>
            </form>
        </div>

        <div class="form-wrapper student-form">
            <form action="{{route('student.login.submit')}}" method="post">
                @csrf
                <h2>STUDENT LOGIN</h2>
                <input type="hidden" class="form-control" name="id">
                <div class="input-group">
                    <input type="text" name="email" required>
                    <label for="">Email</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password" required>
                    <label for="">Password</label>
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="sign-link">
                    <p>Not a Student? <a href="#" class="toggle-link">Admin Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const adminForm = document.querySelector('.admin-form');
            const studentForm = document.querySelector('.student-form');
            const toggleLinks = document.querySelectorAll('.toggle-link');

            toggleLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault(); // Prevent page refresh
                    
                    // Toggle the 'active' class on both forms
                    adminForm.classList.toggle('active');
                    studentForm.classList.toggle('active');
                });
            });
        });
    </script>
</body>
</html>