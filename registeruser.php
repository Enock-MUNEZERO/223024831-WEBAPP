<?php include 'db.php'; ?>

<?php
if(isset($_POST['register'])){
$username=$_POST['username'];
$email=$_POST['email'];
$password=$_POST['password'];

$conn->query("INSERT INTO users2 VALUES(null,'$username','$email','$password')");
echo "<p style='color:#008000

;text-align:center;'>Account Created Successfully!</p>";
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
    }

    button {
        width: 100%;
        padding: 10px;
        background: #008080;
        color: white;
        border: none;
    }

    h2 {
        text-align: center;
        color: #008080F;
    }
    </style>

</head>

<body>

    <form method="POST">
        <h2>Create Account For User</h2>

        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button name="register">Register</button>

        <p style="text-align:center;margin-top:10px;">
            Already have account? <a href="loginorder.php">Login</a>
        </p>

    </form>

</body>

</html>