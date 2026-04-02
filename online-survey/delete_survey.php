<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$survey_id = $_POST['survey_id'];
$user = $_SESSION['user'];

$check = $conn->query("SELECT * FROM surveys 
WHERE id='$survey_id' AND created_by='$user'");

if($check->num_rows > 0) {

    $conn->query("DELETE FROM responses WHERE survey_id=$survey_id");

    $conn->query("DELETE FROM options 
    WHERE question_id IN (SELECT id FROM questions WHERE survey_id=$survey_id)");

    $conn->query("DELETE FROM questions WHERE survey_id=$survey_id");

    $conn->query("DELETE FROM surveys WHERE id=$survey_id");

    header("Location: index.php");
    exit();
}
?>