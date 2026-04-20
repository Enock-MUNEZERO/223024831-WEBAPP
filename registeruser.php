<?php include 'db.php'; ?>

<?php
if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $errors = array();
    
    // Check if username already exists
    $check_username = $conn->query("SELECT username FROM users2 WHERE username='$username'");
    if($check_username->num_rows > 0){
        $errors[] = "Username already exists! Please choose another username.";
    }
    
    // Check if email already exists
    $check_email = $conn->query("SELECT email FROM users2 WHERE email='$email'");
    if($check_email->num_rows > 0){
        $errors[] = "Email already exists!";
    }
    
    // If no errors, insert user
    if(empty($errors)){
        if($conn->query("INSERT INTO users2 VALUES(null,'$username','$email','$password')")){
            echo "<p style='color:#008000; text-align:center; font-weight:bold; background:#d4edda; padding:10px; border-radius:5px;'>✅ Account Created Successfully!</p>";
            // Clear form after successful registration
            $username = $email = $password = "";
        } else {
            echo "<p style='color:#dc3545; text-align:center; font-weight:bold;'>Error: " . $conn->error . "</p>";
        }
    } else {
        // Display all errors
        echo "<div style='color:#dc3545; text-align:center; font-weight:bold; background:#f8d7da; padding:10px; border-radius:5px; margin-bottom:10px;'>";
        foreach($errors as $error){
            echo "❌ " . $error . "<br>";
        }
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>

    <style>
    body {
        font-family: Arial;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
            url('pexels-macourt-media-1519726-32941658.jpg');
        background-size: cover;
        color: white;
    }

    form {
        width: 350px;
        margin: 100px auto;
        background: white;
        padding: 25px;
        border-radius: 10px;
        color: black;
        box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.4);
    }

    input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    input:focus {
        outline: none;
        border-color: #CD853F;
        box-shadow: 0 0 5px rgba(205, 133, 63, 0.3);
    }

    button {
        width: 100%;
        padding: 10px;
        background: #CD853F;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
    }

    button:hover {
        background: #b5723a;
    }

    h2 {
        text-align: center;
        color: #CD853F;
        margin-bottom: 20px;
    }
    
    a {
        color: #CD853F;
        text-decoration: none;
        font-weight: bold;
    }
    
    a:hover {
        text-decoration: underline;
    }
    </style>

</head>

<body>

    <form method="POST">
        <h2>Create Account For User</h2>

        <input type="text" name="username" placeholder="Username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required>
        <input type="email" name="email" placeholder="Email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
        <input type="password" name="password" placeholder="Password" required>

        <button name="register">Register</button>

        <p style="text-align:center;margin-top:15px;">
            Already have account? <a href="loginorder.php">Login here</a>
        </p>
    </form>

</body>

</html> 