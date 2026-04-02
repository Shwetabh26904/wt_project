<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$sid = $_POST['survey_id'];
$user = $_SESSION['user'];

// ✅ Only allow deleting own surveys
$check = $conn->query("SELECT * FROM surveys WHERE id='$sid' AND created_by='$user'");

if($check->num_rows){

    // delete related data first
    $conn->query("DELETE FROM responses WHERE survey_id=$sid");

    $conn->query("DELETE FROM options WHERE question_id IN 
    (SELECT id FROM questions WHERE survey_id=$sid)");

    $conn->query("DELETE FROM questions WHERE survey_id=$sid");

    $conn->query("DELETE FROM surveys WHERE id=$sid");
}

header("Location: index.php");
exit();
?>