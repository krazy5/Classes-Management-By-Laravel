# 🎓 Student Management System – Laravel Project

This is a complete **Student Management Web Application** built using **Laravel**, designed for educational institutions, coaching classes, or training centers. It provides a streamlined way to manage students, fees, attendance, enquiries, batches, and profiles from both admin and student perspectives.

This project includes secure authentication, multiple user roles, detailed route control using middleware, and a responsive dashboard for both students and admins.

---

## 📺 Video Demo

[![Watch the video](https://img.youtube.com/vi/FJ0Y31GimAA/0.jpg)](https://www.youtube.com/watch?v=FJ0Y31GimAA)

> Click above to watch the full demo of the application on YouTube.

---

## 🧾 Detailed Description

This Laravel project is divided into **3 major interfaces**:

### 🔓 Public Area
- Homepage with basic info
- About Us Page
- Courses offered
- Achievements showcase

### 👨‍💼 Admin Panel (Protected by `adminAuth` middleware)
- Secure Login & Logout for Admin
- Admin Dashboard
- Manage Students:
  - Add/Edit/Delete students
  - Upload/Delete attachments (e.g., documents, photos)
- Manage Fees:
  - Fee Chart (define fee structure)
  - Fee Payments (add/view)
  - Fee Records (track who paid)
- Attendance Management:
  - Daily attendance entry
  - Edit by date
  - Generate student-wise attendance reports
- Enquiry Management:
  - CRUD for student/parent enquiries
- Batch Management:
  - Create/Edit/Delete class batches
- Admin Password Change functionality

### 👨‍🎓 Student Panel (Protected by `studentAuth` middleware)
- Secure Login & Logout for Student
- Student Dashboard
- Edit Profile Information
- View Fees Profile & Payment Details
- View Attendance Summary
- Change Password

---

## 🛠️ Technologies Used

- **Laravel 10+**
- Blade Templates
- Eloquent ORM
- MySQL (or any SQL DB)
- Middleware for Role-based Access
- Laravel Resource Controllers
- Bootstrap for UI (can be customized)

---

## 🚦 Route Overview (from `web.php`)

### 🔸 Public Routes:
| URL | Description |
|-----|-------------|
| `/` | Homepage |
| `/aboutpage` | About Us |
| `/course` | Courses |
| `/achivements` | Achievements |

### 🔹 Admin Authentication:
| URL | Description |
|-----|-------------|
| `/login` | Show Login Form |
| `/admin/login` | Handle Login Submit |
| `/admin/logout` | Logout Admin |

### 🔹 Student Authentication:
| URL | Description |
|-----|-------------|
| `/student/login` | Show Login Form |
| `/student/login` (POST) | Handle Login |
| `/student/logout` | Logout Student |

### 🔹 Admin Protected Routes:
- `/admin/dashboard`
- `/admin/change-password`
- `/students` (CRUD)
- `/enquiries`
- `/fees_chart`
- `/fees-payments`
- `/fees-records`
- `/attendance` and student-wise reports
- `/batches`

### 🔹 Student Protected Routes:
- `/student/dashboard`
- `/student/change-password`
- `/edit-profile`
- `/fees-profile/{id}`
- `/attendance/summary/{id}`

---

## 🚀 Installation & Setup

```bash
# 1. Clone the repo
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name

# 2. Install dependencies
composer install

# 3. Create environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Configure your DB credentials in `.env`

# 6. Run database migrations
php artisan migrate

# 7. Serve the application
php artisan serve
