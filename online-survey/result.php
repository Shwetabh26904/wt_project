<?php
session_start();
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
include 'db.php';
$survey_id = $_GET['id'];

$questions = $conn->query("SELECT * FROM questions WHERE survey_id=$survey_id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Survey Results</title>

    <!-- CSS & JS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<h2>Survey Results</h2>

<?php
while ($q = $questions->fetch_assoc()) {
    echo "<h3>".$q['question']."</h3>";

    $options = $conn->query("SELECT o.option_text,
        COUNT(r.id) as votes
        FROM options o
        LEFT JOIN responses r ON o.id = r.selected_option
        WHERE o.question_id=".$q['id']."
        GROUP BY o.id");

    while ($opt = $options->fetch_assoc()) {
        echo $opt['option_text']." - ".$opt['votes']." votes<br>";
    }

    echo "<br>";
}
?>

</body>
</html>