<?php
session_start();
if ($username === 'admin' && $password === '1234') {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "student_db");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (isset($_POST['update'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $name = $conn->real_escape_string($_POST['name']);
    $age = intval($_POST['age']);
    $section = $conn->real_escape_string($_POST['section']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $points = intval($_POST['points']);

    $conn->query("UPDATE users SET name='$name', age=$age, section='$section', gender='$gender', points=$points WHERE username='$username'");
    echo "<p style='color:green'>User updated!</p>";
}

$result = $conn->query("SELECT username, name, age, section, gender, points FROM users ORDER BY points DESC");
?>
<head>
    <style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background-image: url(admin_bg.jpg);
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        background-size: cover;
    }

    table, td, th {
        border: solid;
        background-color: white;
        margin-left: 60px;
        margin-right: 60px;
    }

    .contentcontainer{

    }

    h1{
        margin-left: 90px;
    }

        .bc {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 3;
            background: linear-gradient(90deg, #00a2ff, rgb(173, 226, 247));
            color: black;
            padding: 1.5rem 0;
            height: 90px;
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


    </style>
</head>
<body>
<div class="bc">
    <h1>Admin </h1>
</div>
<button class="menu-btn" onclick="toggleSidebar()">&#9776;</button>
    <div class="sidebar" id="sidebar">
    <button onclick="toggleSidebar()">X</button>
    <a href="index.php">Logout</a>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
    }
</script>

<h1>Admin</h1>

<table border="1" cellpadding="10">
    <tr>
        <th>Username</th>
        <th>Name</th>
        <th>Age</th>
        <th>Section</th>
        <th>Gender</th>
        <th>Points</th>
        <th>Action</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <form method="post">
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>"></td>
            <td><input type="number" name="age" value="<?= $row['age'] ?>"></td>
            <td><input type="text" name="section" value="<?= htmlspecialchars($row['section']) ?>"></td>
            <td>
                <select name="gender">
                    <option value="Male" <?= $row['gender']=='Male'?'selected':'' ?>>Male</option>
                    <option value="Female" <?= $row['gender']=='Female'?'selected':'' ?>>Female</option>
                </select>
            </td>
            <td><input type="number" name="points" value="<?= $row['points'] ?>"></td>
            <td>
                <input type="hidden" name="username" value="<?= htmlspecialchars($row['username']) ?>">
                <input type="submit" name="update" value="Update">
            </td>
        </form>
    </tr>
    <?php endwhile; ?>
</table>

    </body>