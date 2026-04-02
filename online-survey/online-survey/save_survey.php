<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$title = $_POST['title'];
$user = $_SESSION['user'];

// ✅ Insert survey
$conn->query("INSERT INTO surveys (title, created_by) VALUES ('$title', '$user')");
$survey_id = $conn->insert_id;


// ✅ Loop through questions
foreach ($_POST['questions'] as $qIndex => $question) {

    $type = $_POST['types'][$qIndex];

    // 🖼 IMAGE UPLOAD
    $imagePath = "";

    if(isset($_FILES['images']['name'][$qIndex]) && $_FILES['images']['name'][$qIndex] != "") {

        $imageName = time() . "_" . basename($_FILES['images']['name'][$qIndex]);

        $targetPath = "uploads/" . $imageName;

        if(move_uploaded_file($_FILES['images']['tmp_name'][$qIndex], $targetPath)) {
            $imagePath = $targetPath;
        }
    }

    // ✅ Insert question
    $conn->query("INSERT INTO questions (survey_id, question, type, image) 
                  VALUES ('$survey_id', '$question', '$type', '$imagePath')");

    $question_id = $conn->insert_id;

    // ✅ Insert options
    if(isset($_POST['options'][$qIndex])) {

        foreach ($_POST['options'][$qIndex] as $option) {

            if(!empty(trim($option))) {

                $conn->query("INSERT INTO options (question_id, option_text) 
                              VALUES ('$question_id', '$option')");
            }
        }
    }
}

header("Location: index.php");
exit();
?>