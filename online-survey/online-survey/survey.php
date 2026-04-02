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
<title>Survey</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(-45deg, #4facfe, #00f2fe, #667eea, #764ba2);
    background-size: 400% 400%;
    animation: gradientBG 10s ease infinite;
    font-family:'Segoe UI';
}

@keyframes gradientBG {
    0% {background-position:0% 50%;}
    50% {background-position:100% 50%;}
    100% {background-position:0% 50%;}
}

.container-box {
    max-width:900px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:15px;
}

.question-card {
    padding:15px;
    border-radius:10px;
    background:#f9f9ff;
    margin-bottom:20px;
}

.question-img {
    max-width:100%;
    margin-top:10px;
    border-radius:10px;
}
</style>
</head>

<body>

<div class="container-box">

<h2>📋 Fill Survey</h2>

<form action="submit.php" method="POST">

<input type="hidden" name="survey_id" value="<?php echo $survey_id; ?>">

<?php
$qno = 1;

$q = $conn->query("SELECT * FROM questions WHERE survey_id=$survey_id");

while($row = $q->fetch_assoc()){

echo "<div class='question-card'>";
echo "<h5>Q".$qno.". ".$row['question']."</h5>";

if(!empty($row['image'])){
echo "<img src='".$row['image']."' class='question-img'>";
}

$type = $row['type'];

$options = $conn->query("SELECT * FROM options WHERE question_id=".$row['id']);

if($type == "radio"){
while($o = $options->fetch_assoc()){
echo "<div><input type='radio' name='q".$row['id']."' value='".$o['id']."' required> ".$o['option_text']."</div>";
}
}
elseif($type == "checkbox"){
while($o = $options->fetch_assoc()){
echo "<div><input type='checkbox' name='q".$row['id']."[]' value='".$o['id']."'> ".$o['option_text']."</div>";
}
}
elseif($type == "text"){
echo "<input type='text' name='q".$row['id']."' class='form-control'>";
}
elseif($type == "rating"){
for($i=1;$i<=5;$i++){
echo "<input type='radio' name='q".$row['id']."' value='$i'> ⭐$i ";
}
}
elseif($type == "slider"){
echo "<input type='range' name='q".$row['id']."' min='1' max='10' class='form-range'>";
}

echo "</div>";

$qno++;
}
?>

<button class="btn btn-primary w-100">Submit</button>

</form>

</div>

</body>
</html>