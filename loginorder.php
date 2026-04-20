<?php
session_start();
include 'db.php';

$error = "";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check if login is for admin
    if($username === 'Admin' || $username === 'admin' || $username === 'ADMIN'){
        // Admin login - check admin table
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username=? AND password=?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0){
            $_SESSION['user'] = $username;
            $_SESSION['role'] = 'admin';
            header("location: dashboard.php");
            exit();
        } else {
            $error = "Invalid admin credentials";
        }
        $stmt->close();
    } else {
        // Regular user login
        $stmt = $conn->prepare("SELECT * FROM users2 WHERE username=? AND password=?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0){
            $_SESSION['user'] = $username;
            $_SESSION['role'] = 'user';
            header("location: order.php");
            exit();
        } else {
            $error = "Invalid username or password";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SILVER Hotel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            position: relative;
            padding-top: 120px;
            padding-bottom: 150px;
        }

        /* HEADER STYLES */
        .header {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background: #CD853F;
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .nav a {
            color: #FFFF00;
            margin: 0 12px;
            font-size: 18px;
            text-decoration: none;
            font-weight: bold;
            font-family: Arial, sans-serif;
            transition: all 0.3s;
        }

        .nav a:hover {
            color: white;
        }

        /* SLIDER CONTAINER */
        .slider {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .slide.active {
            opacity: 1;
        }

        /* Dark overlay for better text visibility */
        .slider::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 2;
        }

        /* FORM STYLES */
        form {
            position: relative;
            z-index: 3;
            width: 450px;
            margin: 0 auto;
            padding: 40px;
            background: white;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            animation: fadeIn 0.5s ease;
            border-top: 5px solid #CD853F;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            color: #CD853F;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .login-type {
            text-align: center;
            margin-bottom: 25px;
            padding: 8px;
            background: #ffffff;
            border-radius: 5px;
            display: flex;
            gap: 10px;
        }

        .login-type button {
            flex: 1;
            padding: 10px;
            margin: 0;
            background: #e0e0e0;
            color: #666;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .login-type button.active {
            background: #CD853F;
            color: white;
        }

        .login-type button:hover {
            background: #b5702e;
            color: white;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            transition: all 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #CD853F;
            box-shadow: 0 0 8px rgba(205,133,63,0.3);
        }

        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background: #CD853F;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 20px;
            font-weight: bold;
        }

        button[type="submit"]:hover {
            background: #b5702e;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(205,133,63,0.4);
        }

        .error {
            color: #d9534f;
            text-align: center;
            margin-bottom: 20px;
            padding: 12px;
            background: #f9e6e6;
            border-radius: 8px;
            border-left: 3px solid #d9534f;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .register-link a {
            color: #CD853F;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .info-text {
            text-align: center;
            font-size: 12px;
            color: #999;
            margin-top: 15px;
        }

        /* FOOTER STYLES */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #523a23de;
            color: white;
            text-align: center;
            padding: 15px;
            z-index: 10;
            font-size: 14px;
        }

        .footer p {
            margin: 5px 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 10px;
            }
            
            .logo {
                font-size: 22px;
            }
            
            .nav a {
                margin: 0 10px;
                font-size: 14px;
            }
            
            form {
                width: 90%;
                margin: 0 auto;
                padding: 25px;
            }
            
            h2 {
                font-size: 24px;
            }
            
            .footer {
                font-size: 11px;
                padding: 10px;
            }
            
            body {
                padding-top: 130px;
                padding-bottom: 120px;
            }
            
            .login-type button {
                font-size: 12px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <div class="logo">
            SILVER Hotel
        </div>
        <div class="nav">
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
            <a href="menu.php">Menu</a>
            <a href="gallery.php">Gallery</a>
            <a href="loginorder.php">Order</a>
            <a href="contact.php">Contact</a>
        </div>
    </div>

    <!-- BACKGROUND SLIDER -->
    <div class="slider">
        <div class="slide active" style="background-image: url('heaven-restaurant-boutique.jpg');"></div>
        <div class="slide" style="background-image: url('pic.jpg');"></div>
        <div class="slide" style="background-image: url('enis-yavuz-yy4rMNaL6fw-unsplash.jpg');"></div>
        <div class="slide" style="background-image: url('pool6.jpg');"></div>
        <div class="slide" style="background-image: url('jose-marroquin-vU7MuUlgsQQ-unsplash.jpg');"></div>
    </div>

    <!-- LOGIN FORM -->
    <form method="POST" id="loginForm">
        <h2>Welcome to SILVER Hotel</h2>
        
        <div class="login-type">
            <button type="button" id="userBtn" class="active" onclick="setLoginType('user')">User Login</button>
            <button type="button" id="adminBtn" onclick="redirectToAdminLogin()">Admin Login</button>
        </div>
        
        <input type="text" name="username" id="username" placeholder="Username" required autocomplete="off">
        <input type="password" name="password" id="password" placeholder="Password" required>
        
        <button type="submit" name="login" id="loginBtn">Login</button>
        
        <div class="register-link" id="registerLink">
            No account? <a href="registeruser.php">Register as User</a>
        </div>
        
        <div class="info-text" id="infoText">
            User: Regular account to place orders
        </div>
    </form>

    <!-- FOOTER -->
    <div class="footer">
        <p>Contact: +250 788354678 | Email: goldenh123@gmail.com</p>
        <p>Follow us: Facebook | Instagram | Twitter</p>
        <p>© 2026 Golden Horizon Hotel. All rights reserved.</p>
    </div>

    <script>
        // Automatic slideshow functionality
        let slides = document.querySelectorAll('.slide');
        let currentSlide = 0;
        let totalSlides = slides.length;
        
        function changeSlide() {
            slides[currentSlide].classList.remove('active');
            currentSlide++;
            if(currentSlide >= totalSlides) {
                currentSlide = 0;
            }
            slides[currentSlide].classList.add('active');
        }
        
        setInterval(changeSlide, 4000);
        
        // Redirect to admin login page
        function redirectToAdminLogin() {
            window.location.href = "http://localhost/PROJECT%20THREE/login.php";
        }
        
        // Login type switching for user only
        let currentType = 'user';
        
        function setLoginType(type) {
            currentType = type;
            const userBtn = document.getElementById('userBtn');
            const adminBtn = document.getElementById('adminBtn');
            const registerLink = document.getElementById('registerLink');
            const infoText = document.getElementById('infoText');
            const loginBtn = document.getElementById('loginBtn');
            const usernameField = document.getElementById('username');
            
            if(type === 'admin') {
                // This will redirect instead of changing UI
                redirectToAdminLogin();
            } else {
                userBtn.classList.add('active');
                adminBtn.classList.remove('active');
                registerLink.innerHTML = 'No account? <a href="registeruser.php">Register as User</a>';
                infoText.innerHTML = 'User: Regular account to place orders and track deliveries';
                loginBtn.innerHTML = 'Login';
                usernameField.placeholder = 'Username';
            }
        }
        
        // Auto-detect if username field contains admin-related text
        document.getElementById('username').addEventListener('input', function() {
            let val = this.value.toLowerCase();
            if(val === 'admin' || val === 'administrator') {
                redirectToAdminLogin();
            }
        });
        
        // Form validation before submit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            let btn = document.getElementById('loginBtn');
            btn.innerHTML = 'Processing...';
            btn.style.opacity = '0.7';
        });
    </script>
    
</body>
</html>