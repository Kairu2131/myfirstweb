<?php
session_start();


$servername = "localhost";
$dbUsername = "root"; 
$dbPassword = "";     
$dbName = "student_db";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    if ($username === "admin" && $password === "1234") {
        header("Location: admin.php");
        exit();
    }
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: Homepage.php");
            exit();
        } else {
            $message = "Incorrect password!";
        }
    } else {
        $message = "Username not found!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        .mid {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center; 
        }

        .login-box {
            border: solid;
            width: 300px;
            text-align: center;
            padding: 20px;
            background-color: aliceblue;
        }

        body{
            background-image: url(Login_bg.jpg);
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>  
<div class="mid">
<div class="login-box">
    <h1>LOGIN</h1>
    <?php if($message != "") { echo "<p class='error'>$message</p>"; } ?>
    <form action="" method="POST">
        <input name="username" style="margin-top: 30px; margin-bottom: 30px; font-size: 20px;" placeholder="Username" type="text" required>
        <input name="password" style="margin-bottom: 50px; font-size: 20px;" placeholder="Password" type="password" required>
        <div style="margin-top: 20px;">
            <button type="submit" style="font-size: 20px;">Login</button>
        </div>
    </form>
    <p>No account yet? <a href="Register.php">Register here!</a></p>
</div>
</div>
</body>
</html>