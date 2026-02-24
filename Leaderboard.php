<?php
session_start();

if (!isset($_SESSION['username'])) {
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

$result = $conn->query("SELECT username, points FROM users ORDER BY points DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leaderboard</title>
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
            padding-top: 90px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        table {
            width: 60%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.9);
            margin-top: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 12px 20px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        footer {
            background-color: black;
            color: white;
            text-align: center;
            width: 100%;
            padding: 20px 0;
            margin-top: auto;
        }
    </style>
</head>
<body>
<div class="bc">
    <h1>Leaderboard</h1>
</div>

<button class="menu-btn" onclick="toggleSidebar()">&#9776;</button>

<div class="sidebar" id="sidebar">
    <button onclick="toggleSidebar()">X</button>
    <a href="Profile.php">Profile</a>
    <a href="Homepage.php">Home</a>
    <a href="Leaderboard.php">Leaderboard</a>
    <a href="index.php">Logout</a>
</div>

<div class="main-content">
    <h1>Top Players</h1>
    <table>
        <tr>
            <th>Rank</th>
            <th>Username</th>
            <th>Points</th>
        </tr>
        <?php
        $rank = 1;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$rank}</td>";
                echo "<td>".htmlspecialchars($row['username'])."</td>";
                echo "<td>{$row['points']}</td>";
                echo "</tr>";
                $rank++;
            }
        } else {
            echo "<tr><td colspan='3'>No users found</td></tr>";
        }
        ?>
    </table>
</div>

<footer></footer>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
    }
</script>
</body>
</html>
<?php $conn->close(); ?>