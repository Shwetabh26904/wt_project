<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Surveys</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
            font-family: 'Segoe UI', sans-serif;
        }

        nav {
            display: flex;
            justify-content: space-between;
            padding: 15px 40px;
            background: white;
        }

        .container-box {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
        }

        .survey-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>

<body>

<nav>
    <div>📊 SurveyPro</div>
    <div>
        Welcome <?php echo $user; ?> |
        <a href="logout.php">Logout</a>
    </div>
</nav>

<div class="container-box">

<h3>🗑 Your Surveys</h3>

<?php
$res = $conn->query("SELECT * FROM surveys WHERE created_by='$user'");

while($row = $res->fetch_assoc()){
    echo "
    <div class='survey-item'>
        <strong>".$row['title']."</strong>

        <form method='POST' action='delete_survey.php'>
            <input type='hidden' name='survey_id' value='".$row['id']."'>
            <button class='btn btn-danger btn-sm mt-2'>Delete</button>
        </form>
    </div>";
}
?>

</div>

</body>
</html>
