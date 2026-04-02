<?php
include 'db.php';
session_start();

$sid = $_POST['survey_id'];
$user = $_SESSION['user'];

// 🚫 prevent duplicate
$check = $conn->query("SELECT * FROM responses 
WHERE survey_id='$sid' AND user='$user'");

if($check->num_rows > 0){
    die("You already submitted this survey");
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

echo "<h3 style='text-align:center;'>✅ Submitted Successfully</h3>";
?>