<?php
include 'db.php';
session_start();

if($_SESSION['role'] != 'admin'){
    die("Access denied");
}

$title = $_POST['title'];
$user = $_SESSION['user'];
$org_id = $_SESSION['org_id'];

$conn->query("INSERT INTO surveys(title,created_by,org_id)
VALUES('$title','$user','$org_id')");

$sid = $conn->insert_id;

foreach($_POST['questions'] as $i=>$q){

$type = $_POST['types'][$i];

$imagePath = "";

if(!empty($_FILES['images']['name'][$i])){
    $name = time().$_FILES['images']['name'][$i];
    move_uploaded_file($_FILES['images']['tmp_name'][$i],"uploads/".$name);
    $imagePath = "uploads/".$name;
}

$conn->query("INSERT INTO questions(survey_id,question,type,image)
VALUES($sid,'$q','$type','$imagePath')");

$qid = $conn->insert_id;

if(isset($_POST['options'][$i])){
foreach($_POST['options'][$i] as $o){
if($o){
$conn->query("INSERT INTO options(question_id,option_text)
VALUES($qid,'$o')");
}
}
}
}

header("Location:index.php");
?>