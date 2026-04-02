<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$title = $_POST['title'];
$created_by = $_SESSION['user'];

$conn->query("INSERT INTO surveys (title, created_by) 
VALUES ('$title', '$created_by')");

$survey_id = $conn->insert_id;

foreach ($_POST['questions'] as $qIndex => $question) {

    $type = $_POST['types'][$qIndex];

    $conn->query("INSERT INTO questions (survey_id, question, type) 
    VALUES ($survey_id, '$question', '$type')");

    $question_id = $conn->insert_id;

    if(isset($_POST['options'][$qIndex])) {
        foreach ($_POST['options'][$qIndex] as $option) {
            if(!empty($option)) {
                $conn->query("INSERT INTO options (question_id, option_text) 
                VALUES ($question_id, '$option')");
            }
        }
    }
}

header("Location: index.php");
exit();
?>