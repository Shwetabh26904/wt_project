<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$sid = $_POST['survey_id'];
$user = $_SESSION['user'];

// 🚫 prevent duplicate
$check = $conn->query("SELECT * FROM responses 
WHERE survey_id='$sid' AND user='$user'");

if($check->num_rows > 0){
    echo "
    <div style='text-align:center;margin-top:100px;font-family:Segoe UI;'>
        <h3 style='color:red;'>⚠ You already submitted this survey</h3>
        <a href='index.php' style='padding:10px 20px;background:#007bff;color:white;border-radius:5px;text-decoration:none;'>Go to Dashboard</a>
    </div>
    ";
    exit();
}

// save responses
foreach($_POST as $k => $v){

    if(strpos($k,'q') === 0){

        $qid = substr($k,1);

        if(is_array($v)){
            foreach($v as $val){
                $conn->query("INSERT INTO responses (survey_id, question_id, answer, user)
                VALUES ('$sid','$qid','$val','$user')");
            }
        }
        else{
            $conn->query("INSERT INTO responses (survey_id, question_id, answer, user)
            VALUES ('$sid','$qid','$v','$user')");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Submitted</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(-45deg, #4facfe, #00f2fe, #667eea, #764ba2);
    background-size: 400% 400%;
    animation: gradientBG 10s ease infinite;
    font-family: 'Segoe UI', sans-serif;
}

@keyframes gradientBG {
    0% {background-position:0% 50%;}
    50% {background-position:100% 50%;}
    100% {background-position:0% 50%;}
}

.success-box {
    max-width: 400px;
    margin: 120px auto;
}

.card {
    border-radius: 15px;
}
</style>
</head>

<body>

<div class="success-box">

<div class="card shadow p-4 text-center">

<h3 class="text-success mb-3">✅ Submitted Successfully</h3>

<p>Your response has been recorded.</p>

<a href="index.php" class="btn btn-primary mt-3">🏠 Go to Dashboard</a>

</div>

</div>

</body>
</html>