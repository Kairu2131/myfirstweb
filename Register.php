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
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $age = $conn->real_escape_string($_POST['age']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $section = $conn->real_escape_string($_POST['section']);
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    if ($password !== $repeat_password) {
        $message = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        $check = $conn->query("SELECT * FROM users WHERE username='$username'");
        if ($check->num_rows > 0) {
            $message = "Username already exists!";
        } else {
            $sql = "INSERT INTO users (username, age, gender, section, password) 
                    VALUES ('$username', '$age', '$gender', '$section', '$hashed_password')";

            if ($conn->query($sql) === TRUE) {
                $success = "Registration successful!";
            } else {
                $message = "Error: " . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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

        .success {
            color: green;
            margin-bottom: 15px;
        }

        a {
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>
<body>  
<div class="mid">
<div class="login-box">
    <h1>Register</h1>
    <?php 
        if($message != "") { echo "<p class='error'>$message</p>"; } 
        if($success != "") { echo "<p class='success'>$success</p>"; } 
    ?>
    <form action="" method="POST">
        <input name="username" style="margin-top: 30px; margin-bottom: 20px; font-size: 20px;" placeholder="Username" type="text" required>
        <input name="age" style="margin-bottom: 20px; font-size: 20px;" placeholder="Age" type="text" required>
        <input name="gender" style="margin-bottom: 20px; font-size: 20px;" placeholder="Gender" type="text" required>
        <input name="section" style="margin-bottom: 20px; font-size: 20px;" placeholder="Section" type="text" required>
        <input name="password" style="margin-bottom: 20px; font-size: 20px;" placeholder="Password" type="password" required>
        <input name="repeat_password" style="margin-bottom: 50px; font-size: 20px;" placeholder="Repeat Password" type="password" required>
        <div style="margin-top: 20px;">
            <button type="submit" style="font-size: 20px;">Register</button>
        </div>
    </form>
    <p>Already have an account? <a href="index.php">Login here!</a></p>
</div>
</div>
</body>
</html>