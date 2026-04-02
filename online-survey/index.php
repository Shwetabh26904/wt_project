<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f4f6fb; }
        .dashboard {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
        }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .box {
            border: 1px solid #eee;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }
        .survey-item {
            margin-top: 10px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>

<body>

<div class="container mt-3 d-flex justify-content-between">
    <h4>📊 Survey Dashboard</h4>
    <div>
        Welcome, <?php echo $_SESSION['user']; ?> |
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="dashboard">

<div class="grid">

<!-- TAKE SURVEY -->
<div class="box">
    <h5>Take Survey</h5>

    <?php
    $result = $conn->query("SELECT * FROM surveys");

    while($row = $result->fetch_assoc()) {
        echo "
        <div class='survey-item'>
            ".$row['title']."<br>
            <a href='survey.php?id=".$row['id']."' class='btn btn-primary btn-sm'>Start</a>
        </div>";
    }
    ?>
</div>

<!-- RESULTS -->
<div class="box">
    <h5>Results</h5>

    <?php
    $result = $conn->query("SELECT * FROM surveys");

    while($row = $result->fetch_assoc()) {
        echo "
        <div class='survey-item'>
            ".$row['title']."<br>
            <a href='result.php?id=".$row['id']."' class='btn btn-success btn-sm'>View</a>
        </div>";
    }
    ?>
</div>

<!-- CREATE -->
<div class="box">
    <h5>Create Survey</h5>
    <a href="create_survey.php" class="btn btn-warning">Create</a>
</div>

<!-- DELETE -->
<div class="box">
    <h5>Delete Your Surveys</h5>

    <?php
    $user = $_SESSION['user'];
    $result = $conn->query("SELECT * FROM surveys WHERE created_by='$user'");

    while($row = $result->fetch_assoc()) {
        echo "
        <div class='survey-item'>
            ".$row['title']."
            <form method='POST' action='delete_survey.php'>
                <input type='hidden' name='survey_id' value='".$row['id']."'>
                <button class='btn btn-danger btn-sm mt-1'>Delete</button>
            </form>
        </div>";
    }
    ?>
</div>

</div>
</div>

</body>
</html>