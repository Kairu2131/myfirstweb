<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "student_db";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$uploadMessage = "";
if(isset($_POST['upload'])) {
    if(isset($_FILES['pfp']) && $_FILES['pfp']['error'] === 0){
        $fileTmpPath = $_FILES['pfp']['tmp_name'];
        $fileName = $_SESSION['username'] . "_" . basename($_FILES['pfp']['name']);
        $destPath = "uploads/" . $fileName;

        if(!is_dir("uploads")) {
            mkdir("uploads", 0777, true);
        }

        if(move_uploaded_file($fileTmpPath, $destPath)){
            $conn->query("UPDATE users SET pfp='$fileName' WHERE username='{$_SESSION['username']}'");
            $uploadMessage = "";
        } else {
            $uploadMessage = "Error uploading file.";
        }
    } else {
        $uploadMessage = "No file selected.";
    }
}

$username = $_SESSION['username'];
$result = $conn->query("SELECT * FROM users WHERE username='$username'");
$user = $result->fetch_assoc();
$conn->close();

$pfpPath = isset($user['pfp']) && $user['pfp'] !== "" ? "uploads/".$user['pfp'] : "default_pfp.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Profile</title>
<style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: url(BC.jpg);
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
        }

        .bc {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 3;
            background: linear-gradient(90deg, #fbff00, rgb(255, 255, 222));
            color: black;
            padding: 1.5rem 0;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bc h1 {
            margin: 0;
            font-size: 2rem;
            letter-spacing: 1px;
        }

        .menu-btn {
            position: fixed;
            top: 10px;
            left: 10px;
            font-size: 2rem;
            background: none;
            border: none;
            cursor: pointer;
            z-index: 4;
        }


        .sidebar {
            position: fixed;
            top: 0;
            left: -220px;
            width: 200px;
            height: 100%;
            background-color: rgba(51, 51, 51, 0.95);
            color: white;
            padding-top: 60px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            transition: left 0.3s;
            z-index: 5;
        }

        .sidebar a, .sidebar button {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 1.2rem;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
        }

        .sidebar a:hover, .sidebar button:hover {
            background-color: #444;
        }

        .sidebar.active {
            left: 0;
        }

        .main-content {
            flex: 1; 
            padding-top: 70px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        table {
            font-size: 40px;
            border-spacing: 50px 20px;
            border-collapse: separate;
        }

        footer {
            background-color: black;
            color: white;
            text-align: center;
            width: 100%;
            padding: 20px 0;
            margin-top: auto;
        }

        .box{
            margin-top: 100px;
            border: solid;
            background-color: aliceblue;
            height: 400px;
            width: 80%;
            position: fixed;
        }
    </style>
</head>
<body>

<div class="bc"><h1>Profile</h1></div>
<button class="menu-btn" onclick="toggleSidebar()">&#9776;</button>

<div class="sidebar" id="sidebar">
    <button onclick="toggleSidebar()">X</button>
    <a href="Profile.php">Profile</a>
    <a href="Homepage.php">Home</a>
    <a href="Leaderboard.php">Leaderboard</a>
    <a href="index.php">Logout</a>
</div>

<div class="main-content">
    <div class="box">
        <img src="<?= $pfpPath ?>" alt="Profile Picture" width="150" style="display:block; margin-bottom:20px;">
    <form method="POST" enctype="multipart/form-data">
            <input type="file" name="pfp" accept="image/*">
    </form>
    <button type="submit" name="upload">Upload</button>
        <h2>Username: <?= htmlspecialchars($user['username']) ?></h2>
        <h2>Section: <?= htmlspecialchars($user['section']) ?></h2>
        <h2>Age: <?= htmlspecialchars($user['age']) ?></h2>
        <h2>Gender: <?= htmlspecialchars($user['gender']) ?></h2>
    </div>
</div>

<footer></footer>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
}
</script>

</body>
</html>