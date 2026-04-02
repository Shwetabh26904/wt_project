<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$survey_id = $_GET['id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Results</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg,#e0eafc,#cfdef3);
}

.container-box {
    max-width: 900px;
    margin: 40px auto;
    background: white;
    padding: 30px;
    border-radius: 15px;
}

.question-card {
    background:#f9f9ff;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;
}
</style>
</head>

<body>

<div class="container-box">

<h2>📊 Survey Results</h2>

<?php
$q = $conn->query("SELECT * FROM questions WHERE survey_id=$survey_id");

while($row = $q->fetch_assoc()){

echo "<div class='question-card'>";
echo "<h5>".$row['question']."</h5>";

$type = $row['type'];

/* ================= RADIO / CHECKBOX ================= */
if($type == "radio" || $type == "checkbox"){

    $opt = $conn->query("SELECT * FROM options WHERE question_id=".$row['id']);

    while($o = $opt->fetch_assoc()){

        $count = $conn->query("SELECT COUNT(*) as total FROM responses 
                              WHERE question_id=".$row['id']." 
                              AND answer='".$o['id']."'");

        $data = $count->fetch_assoc();

        echo "<div>".$o['option_text']." → <b>".$data['total']."</b></div>";
    }
}

/* ================= TEXT ================= */
elseif($type == "text"){

    $res = $conn->query("SELECT answer FROM responses WHERE question_id=".$row['id']);

    echo "<ul>";
    while($r = $res->fetch_assoc()){
        echo "<li>".$r['answer']."</li>";
    }
    echo "</ul>";
}

/* ================= SLIDER ================= */
elseif($type == "slider"){

    $res = $conn->query("SELECT AVG(answer) as avg_val FROM responses WHERE question_id=".$row['id']);
    $data = $res->fetch_assoc();

    echo "<b>Average: ".round($data['avg_val'],2)."</b>";
}

/* ================= RATING ================= */
elseif($type == "rating"){

    $res = $conn->query("SELECT AVG(answer) as avg_val FROM responses WHERE question_id=".$row['id']);
    $data = $res->fetch_assoc();

    echo "<b>Average Rating: ".round($data['avg_val'],2)." ⭐</b>";
}

echo "</div>";
}
?>

</div>

</body>
</html>