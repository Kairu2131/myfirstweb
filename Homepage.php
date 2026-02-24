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

$username = $_SESSION['username'];

$result = $conn->query("SELECT points FROM users WHERE username='$username'");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $points = (int)$row['points'];
} else {
    $points = 0;
}

if (isset($_POST['updatePoints'])) {
    $newPoints = intval($_POST['points']);
    $conn->query("UPDATE users SET points=$newPoints WHERE username='$username'");
    echo "success";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
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
            cursor: pointer; }
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
            font-size: 40px; 
            border-spacing: 380px 30px; 
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
        .bookcover { 
            height: 500px; 
            border: solid; 
        }
        .chapter { 
            display: none; 
            margin-top: 20px; 
            padding: 15px; 
            border: 1px solid #000; 
            background-color: azure; 
        }
        .locked { 
            color: gray; 
            cursor: not-allowed; 
        }
        .Answer { 
            margin-left: 15px; 
            border: solid; 
            height: 50px; 
            width: 70%; 
            font-size: 20px; 
            background-color: antiquewhite; 
        }
    </style>
</head>
<body>
<div class="bc">
    <h1></h1>
    <h2 style="margin-left: 1500px; position: fixed;"> Total Points: <span id="points"><?= $points ?></span></h2>
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
    <table>
        <tr>
            <th>
                <p>CUPID and PSYCHE</p>
                <a href="Book_1.html"><img class="bookcover" src="Cupid and Phyche.jpg"></a>
            </th>
        </tr>
        <tr>
            <th>
                <h1>Questions</h1>
                <div id="menu">
                    <button onclick="openChapter(1)">Chapter 1</button>
                    <button id="btn2" class="locked">Chapter 2</button>
                    <button id="btn3" class="locked">Chapter 3</button>
                    <button id="btn4" class="locked">Chapter 4</button>
                    <button id="btn5" class="locked">Chapter 5</button>
                </div>

    <div id="chapter1" class="chapter">
    <h2>Chapter 1</h2>
    <p>1. Who is the goddess who felt jealous against pysche?</p>
    <input class="Answer" id="c1q1"><br>
    <p>2. He was the person sent by venus to make pysche fall in love with the horrible wretch</p>
    <input class="Answer" id="c1q2"><br>
    <p>3. What happened to cupid when he's about to shoot his arrow?</p>
    <input class="Answer" id="c1q3"><br>
    <button onclick="checkChapter(1)" style="width:50px;height:40px;border:solid 2px;">Done</button>
    </div>
    
    <div id="chapter2" class="chapter">
    <h2>Chapter 2</h2>
    <p>1. Who is the person Psyche's father seek for help?</p>
    <input class="Answer" id="c2q1"><br>

    <p>2. Who lifted Psyche on the mountains?</p>
    <input class="Answer" id="c2q2"><br>

    <p>3. Why does psyche kept crying when she was at the palace?</p>
    <input class="Answer" id="c2q3"><br>

    <p>4. Why does cupid warned psyche not to let her sisters see either of them?</p>
    <input class="Answer" id="c2q4"><br>

    <button onclick="checkChapter(2)" style="width: 50px; height: 40px; border: solid 2px;" >Done</button>
</div>

<div id="chapter3" class="chapter">
    <h2>Chapter 3</h2>
    <p>1. What does psyche's sisters felt when they saw how rich the palace truly is?</p>
    <input class="Answer" id="c3q1"><br>

    <p>2. Why does psyche suddenly planned to secretly find out the truth about her husband's appearance?</p>
    <input class="Answer" id="c3q2"><br>

    <p>3. What does cupid gave that psyche took advantage of?</p>
    <input class="Answer" id="c3q3"><br>

    <button onclick="checkChapter(3)" style="width: 50px; height: 40px; border: solid 2px;" >Done</button>
</div>

<div id="chapter4" class="chapter">
    <h2>Chapter 4</h2>
    <p>1. Who does psyche seek when she's finding cupid?</p>
    <input class="Answer" id="c4q1"><br>

    <p>2. Give at least 1 task Venus gave to psyche to prove herself</p>
    <input class="Answer" id="c4q2"><br>

    <p>3. What is the hardest task of all?</p>
    <input class="Answer"id="c4q3"><br>

    <p>4. Why does Psyche opened the box of Proserpines beauty?</p>
    <input class="Answer"id="c4q4"><br>

    <button onclick="checkChapter(4)" style="width: 50px; height: 40px; border: solid 2px;" >Done</button>
</div>

<div id="chapter5" class="chapter">
    <h2>Chapter 5</h2>
    <p>1. Who saved Psyche from endless sleep?</p>
    <input class="Answer" id="c5q1"><br>

    <p>2. Who gave Psyche immortality?</p>
    <input class="Answer" id="c5q2"><br>

    <p>3. Did Venus still intercept the couple?</p>
    <input class="Answer" id="c5q3"><br>

    <button onclick="checkChapter(5)" style="width: 50px; height: 40px; border: solid 2px;" >Done</button>
</div>
            </th>
        </tr>
    </table>
</div>

<footer></footer>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
}

let points = <?= $points ?>;
let completedChapters = {};

const chapterPointsRequirement = [0, 0, 30, 70, 100, 130];
function openChapter(num) {
    if(points < chapterPointsRequirement[num]){
        alert(`You need ${chapterPointsRequirement[num]} points to unlock Chapter ${num}`);
        return;
    }
    document.querySelectorAll('.chapter').forEach(ch => ch.style.display = 'none');
    document.getElementById("chapter" + num).style.display = "block";
}

function checkChapter(chapter){
    const answers = {
        1:["venus","cupid","he accidentally shoot himself"],
        2:["apollo","zephyr","she wants to see her sisters","it will bring destruction for the both of them"],
        3:["they marvel with jealousy","doubt and fear consumed her","trust"],
        4:["venus","sorting a mountain of seeds before dawn","descend to the underworld and carry a box to fill it with proserpines beauty","she was insecure about herself"],
        5:["cupid","jupiter","no"]
    };

    let totalQuestions = answers[chapter].length;
    let correct = 0;

    for(let i=1; i<=totalQuestions; i++){
        let input = document.getElementById("c"+chapter+"q"+i).value.toLowerCase().trim().replace(/['’]/g,"").replace(/\s+/g," ");
        let correctAnswer = answers[chapter][i-1].toLowerCase().trim().replace(/['’]/g,"").replace(/\s+/g," ");
        if(input === correctAnswer){
            correct++;
            if(!completedChapters[chapter+"-"+i]){
                points += 10;
                completedChapters[chapter+"-"+i] = true;
            }
        }
    }

    document.getElementById("points").innerText = points;

    let xhr = new XMLHttpRequest();
    xhr.open("POST","",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhr.send("updatePoints=1&points="+points);

    if(correct === totalQuestions){
        alert(`Chapter ${chapter} completed!`);
        updateChapterButtons();
    }
}

function updateChapterButtons(){
    for(let i=2; i<=5; i++){
        let btn = document.getElementById("btn"+i);
        if(points >= chapterPointsRequirement[i]){
            btn.classList.remove("locked");
            btn.onclick = function(){ openChapter(i); };
        } else {
            btn.classList.add("locked");
            btn.onclick = function(){ alert(`You need ${chapterPointsRequirement[i]} points to unlock Chapter ${i}`); };
        }
    }
}

updateChapterButtons();
</script>
</body>
</html>