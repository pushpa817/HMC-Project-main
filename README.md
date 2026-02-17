# HMC - Hall Management and Complaint System

A comprehensive web-based management platform for hostel/residential hall administration at educational institutions. This system manages rooms, mess, amenities, complaints, and staff across multiple halls with role-based access control.

## � Live Demo

**Coming Soon!** Deployment in progress on Render.com...

For now, try the [Docker setup](#-installation--setup) for local testing.

See [RENDER_DEPLOYMENT.md](RENDER_DEPLOYMENT.md) for deployment instructions.

## �🎯 Overview

The Hall Management and Complaint System (HMC) is designed to streamline the operations of multi-hall residential facilities. It provides a unified platform for students, wardens, mess managers, staff managers, and administrators to manage accommodation, dining, amenities, and complaint resolution efficiently.

## ✨ Features

### Student Features
- 📋 Personal profile management
- 🏠 Hall and room information
- 🍽️ Daily mess menu viewing (Vegetarian/Non-Vegetarian)
- 🎪 Amenity booking with date range and cost calculation
- 📝 Submit and track complaints (Mess/Hall)
- 💰 View billing information (room, mess, amenities)

### Warden Features
- 👥 Hall occupancy management
- 📊 Room detail updates and tracking
- 💬 Respond to student complaints
- 💵 Monthly payment processing
- 🏨 Amenity administration
- 📈 Occupancy reports

### Mess Manager Features
- 🍴 Manage daily meal menus
- 🗂️ Organize mess inventory
- 💬 Handle dining-related complaints
- 📊 Update mess billing details

### Staff Manager Features
- ✅ Track staff attendance
- 💼 Manage salary billing
- 👤 Maintain staff records
- 📋 Generate attendance reports

### Chairman Features
- 🔝 Comprehensive oversight of all operations
- 👔 Staff recruitment and management
- 💸 Salary management and approval
- 📊 Warden performance review
- 👥 View detailed staff information

## 🛠️ Technologies Used

### Backend
- **PHP** 7.4+ / 8.0+
- **MySQL/MariaDB** 10.4+
- **PHPMailer** 6.9 (Email functionality)
- **Composer** (Package manager)

### Frontend
- **HTML5** - Structure
- **CSS3** - Styling
- **JavaScript** (Vanilla) - Client-side interactions
- **AJAX/Fetch API** - Asynchronous requests
- **Boxicons** - Icon library
- **Phosphor Icons** - Alternative icons

### Database
- **Engine:** InnoDB
- **Charset:** UTF8MB4
- **Tables:** 11 (Students, Wardens, Halls, Rooms, Staff, Complaints, etc.)

## 📋 Project Structure

```
HMC-Project-main/
├── index.php                    # Login page (entry point)
├── login.php                    # Authentication handler
├── database.php                 # Database connection
├── forgot_password.php          # Password reset flow
├── verify_code.php              # Email verification
├── reset_password.php           # Password update
├── scripts.js                   # Frontend JavaScript
├── styles.css                   # Main CSS styling
├── README.md                    # This file
├── composer.json                # PHP dependencies
│
├── Student/                     # Student module
│   ├── dashboard.php
│   ├── profile.php
│   ├── hall.php
│   ├── amenities.php
│   ├── amenity_booking.php
│   ├── complaints.php
│   ├── submit_complaint.php
│   └── student_styles.css
│
├── Chairman/                    # Administrator module
│   ├── dashboard.php
│   ├── staff_details.php
│   ├── recurit_staff.php
│   ├── warden_details.php
│   ├── salary.php
│   └── chairman_styles.css
│
├── Warden/                      # Warden module
│   ├── dashboard.php
│   ├── Amenties.php
│   ├── mess_complaints.php
│   ├── monthly_pay.php
│   ├── update_room_details.php
│   └── warden_styles.css
│
├── MessManager/                 # Mess Manager module
│   ├── dashboard.php
│   ├── mess_menu.php
│   ├── mess_details.php
│   ├── mess_complaints.php
│   └── manager_styles.css
│
├── StaffManager/                # Staff Manager module
│   ├── dashboard.php
│   ├── attendance.php
│   ├── salary_bills.php
│   ├── staff_details.php
│   └── staffmanager_styles.css
│
├── project/
│   ├── HMC.sql                  # Database schema
│   └── [documentation files]
│
├── vendor/                      # Composer dependencies
│   └── phpmailer/
│
└── images/                      # Static images
```

## 🚀 Installation & Setup

### Quick Start with Docker 🐳 (Recommended)

The easiest way to run HMC is using Docker. No need to install PHP, MySQL separately!

```bash
# 1. Clone the repository
git clone https://github.com/pushpa817/HMC-Project-main.git
cd HMC-Project-main

# 2. Run one command to start everything
docker-compose up -d

# 3. Access the application
# Main App: http://localhost
# phpMyAdmin: http://localhost:8081
```

**That's it!** All services (PHP, Apache, MySQL, phpMyAdmin) will be running in containers.

For detailed Docker instructions, see [DOCKER_GUIDE.md](DOCKER_GUIDE.md)

---

### Traditional Installation

#### Prerequisites
- PHP 7.4 or higher
- MySQL/MariaDB 10.4+
- Composer
- Web server (Apache/Nginx)

#### Step 1: Clone the Repository
```bash
git clone https://github.com/pushpa817/HMC-Project-main.git
cd HMC-Project-main
```

### Step 2: Install Dependencies
```bash
composer install
```

### Step 3: Database Setup

1. Open phpMyAdmin or MySQL CLI
2. Create a new database:
```sql
CREATE DATABASE HMC;
```

3. Import the database schema:
```bash
mysql -u root -p HMC < project/HMC.sql
```

### Step 4: Configure Database Connection

Edit `database.php` and update credentials:
```php
<?php
$servername = "localhost";
$username = "root";           // Change if different
$password = "";               // Enter your password
$dbname = "HMC";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
```

### Step 5: Configure Web Server

#### For Apache:
```apache
DocumentRoot /path/to/HMC-Project-main
<Directory /path/to/HMC-Project-main>
    AllowOverride All
    Require all granted
</Directory>
```

#### For Nginx:
```nginx
server {
    listen 80;
    server_name hmc.local;
    root /path/to/HMC-Project-main;
    
    location / {
        try_files $uri $uri/ /index.php;
    }
}
```

### Step 6: Start the Application

1. Start your web server
2. Open browser: `http://localhost/HMC-Project-main/` or `http://hmc.local`
3. You're ready to go!

## 👥 User Roles & Login Credentials

| Role | ID Format | Sample ID | Password |
|------|-----------|-----------|----------|
| **Student** | ST2XXXXX | ST220001 | (see database) |
| **Warden** | WD9XXXXX | WD999991 | (see database) |
| **Mess Manager** | MM9XXXXX | MM999918 | virat1818 |
| **Chairman** | CH9XXXXX | CH999999 | ravi9999 |
| **Staff Manager** | SM9XXXXX | SM999991 | dravid9999 |

**Note:** Check `project/HMC.sql` for default credentials. Change passwords after first login.

## 📊 Database Schema

### Core Tables

1. **StudentPersonalDetails** - Student information
2. **StudentHallDetails** - Student-to-hall mapping with room assignment
3. **Halls** - 4 residential halls (Ramanujan, Infinity, Sarojini, Delta)
4. **Rooms** - Individual room records
5. **Wardens** - Hall supervisors
6. **Chairman** - Administrative user
7. **MessManager** - Mess operations
8. **Staff** - Cleaners and gardeners
9. **StaffManager** - Staff coordination
10. **Complaints** - Student grievances (Mess/Hall)
11. **Expenditures** - Hall-wise financial tracking

## 🔐 Security Features

✅ **Implemented:**
- Prepared statements (SQL injection prevention)
- Session-based authentication
- Role-based access control (RBAC)
- Email verification for password reset
- Password visibility toggle

⚠️ **Recommendations:**
- Use `password_hash()` and `password_verify()` for stronger password security
- Implement CSRF tokens for forms
- Enable HTTPS in production
- Use environment variables for sensitive credentials
- Implement rate limiting for login attempts
- Add input sanitization with `htmlspecialchars()` globally

## 📧 Email Configuration

For password reset functionality, update PHPMailer configuration in your code:

```php
$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'your-email@gmail.com';
$mail->Password = 'your-app-password';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
```

## 🌊 Project Flow

```
Login (index.php)
    ↓
Authentication (login.php)
    ↓
┌─────────────────────────────────────────┐
│                                         │
Student      Chairman    Warden    Mess   Staff
Module       Module      Module    Mgr    Mgr
│            │           │        Module  Module
├─Dashboard  ├─Dashboard ├─Dashboard │     │
├─Profile    ├─Staff     ├─Rooms    ├─Menu├─Attendance
├─Booking    │ Recruit   ├─Occupancy├─Menu├─Salary
├─Complaints ├─Salary    ├─Complaints│    │
└─Bills      └─Wardens   └─Monthly  └─Bills
             Payments
```

## 🚀 Features in Detail

### Amenity Booking
- Students can book amenities with date range
- System prevents overlapping bookings
- Automatic cost calculation
- Email confirmation (when configured)

### Complaint Management
- Students submit complaints (Mess/Hall)
- Wardens/Managers respond with ATR (Action Taken Report)
- Status tracking (Pending/Resolved)
- History maintenance

### Mess Menu
- Daily menus managed by Mess Manager
- Separate Vegetarian/Non-Vegetarian options
- Student preference selection
- Weekly planning capability

### Room Management
- Occupancy tracking
- Room type support (Single/Twin Sharing)
- Cost differentiation
- Auto-assignment capability

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is open source and available under the MIT License.

## 👨‍💼 Support & Documentation

For detailed documentation, refer to:
- Database Schema: `project/HMC.sql`
- System Design: `project/URD.odt` (Requirements Document)
- Architecture: `project/SRS.odt` (Software Specification)

## 📞 Contact & Support

For issues, questions, or suggestions:
- Create an issue on GitHub
- Email: [Your contact email]
- Visit: https://github.com/pushpa817/HMC-Project-main

## 🎓 Institution

Developed for RGUKT (Rajiv Gandhi University of Knowledge Technologies) hostel management system.

---

**Last Updated:** February 2026
**Version:** 1.0.0
**Status:** Active & Maintained
