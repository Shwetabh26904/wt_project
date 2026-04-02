<?php
include 'db.php';
session_start();

if($_SESSION['role'] != 'admin'){
    die("Access denied");
}

$sid = $_POST['survey_id'];
$user = $_SESSION['user'];

$check = $conn->query("SELECT * FROM surveys WHERE id='$sid' AND created_by='$user'");

if($check->num_rows){

$conn->query("DELETE FROM responses WHERE survey_id=$sid");
$conn->query("DELETE FROM options WHERE question_id IN 
(SELECT id FROM questions WHERE survey_id=$sid)");
$conn->query("DELETE FROM questions WHERE survey_id=$sid");
$conn->query("DELETE FROM surveys WHERE id=$sid");

}

header("Location:index.php");
?>