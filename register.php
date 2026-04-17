<?php
session_start();
include 'db.php';

$error = "";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // HARDCODED ADMIN LOGIN (separate from user registrations)
    if(($username === 'Admin' || $username === 'admin') && $password === 'admin123'){
        $_SESSION['user'] = 'Admin';
        $_SESSION['role'] = 'admin';
        header("location: dashboard.php");
        exit();
    } else {
        // Regular user login - users use THEIR OWN password they created
        $user_stmt = $conn->prepare("SELECT * FROM users2 WHERE username=? AND password=?");
        $user_stmt->bind_param("ss", $username, $password);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();
        
        if($user_result->num_rows > 0){
            $_SESSION['user'] = $username;
            $_SESSION['role'] = 'user';
            header("location: order.php");
            exit();
        } else {
            $error = "Invalid username or password. Please check your credentials.";
        }
        $user_stmt->close();
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
            display: flex;
            justify-content: center;
            align-items: center;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('heaven-restaurant-boutique.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            opacity: 0.85;
            z-index: -2;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.65);
            z-index: -1;
        }

        .form-container {
            width: 100%;
            max-width: 450px;
            margin: 20px;
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        form {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.3);
            border-top: 5px solid #CD853F;
        }

        h2 {
            text-align: center;
            color: #CD853F;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .login-info {
            text-align: center;
            margin-bottom: 25px;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 8px;
            font-size: 13px;
            color: #666;
        }

        .login-info p {
            margin: 5px 0;
        }

        .login-info strong {
            color: #CD853F;
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

        .admin-note {
            text-align: center;
            font-size: 12px;
            color: #999;
            margin-top: 15px;
            padding: 8px;
            background: #fff3cd;
            border-radius: 8px;
            border-left: 3px solid #ffc107;
        }

        @media (max-width: 480px) {
            .form-container {
                margin: 15px;
            }
            
            form {
                padding: 25px;
            }
            
            h2 {
                font-size: 24px;
            }
            
            input, button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="form-container">
        <form method="POST">
            <h2>🔐 Welcome to SILVER Hotel</h2>
            
            <div class="login-info">
                <p>👤 <strong>Customers:</strong> Login with the username and password you created</p>
                <p>👑 <strong>Admin Access:</strong> Username: <strong>Admin</strong> | Password: <strong>admin123</strong></p>
            </div>
            
            <?php if(isset($error)): ?>
                <div class="error">⚠️ <?php echo $error; ?></div>
            <?php endif; ?>
            
            <input type="text" name="username" id="username" placeholder="Username" required autocomplete="off">
            <input type="password" name="password" id="password" placeholder="Your Password" required>
            
            <button type="submit" name="login">🚀 Login</button>
            
            <div class="register-link">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
            
            <div class="admin-note">
                💡 Note: Admin login is separate. Regular users cannot access admin dashboard.
            </div>
        </form>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            let btn = document.querySelector('button');
            btn.innerHTML = '⏳ Logging in...';
            btn.style.opacity = '0.7';
        });
    </script>
    
</body>
</html>