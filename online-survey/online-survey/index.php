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
    <title>Survey Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
            font-family: 'Segoe UI', sans-serif;
        }

        /* NAVBAR */
        nav {
            display: flex;
            justify-content: space-between;
            padding: 15px 40px;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        nav a {
            text-decoration: none;
        }

        /* MAIN CONTAINER */
        .dashboard {
            max-width: 900px;
            margin: 60px auto;
            padding: 10px;
        }

        /* GRID */
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        /* CARD */
        .box {
            background: white;
            padding: 40px 20px;
            border-radius: 18px;
            text-align: center;
            text-decoration: none;
            color: #333;

            box-shadow: 0 8px 25px rgba(0,0,0,0.05);
            transition: 0.3s ease;
        }

        /* HOVER */
        .box:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 30px rgba(0,0,0,0.1);
        }

        /* ICON */
        .icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        /* TITLE */
        .box h5 {
            font-weight: 600;
            margin-top: 10px;
        }

        /* COLORS */
        .take { color: #4facfe; }
        .result { color: #28a745; }
        .create { color: #ff9800; }
        .delete { color: #dc3545; }

        @media(max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav>
    <div><strong>📊 SurveyPro</strong></div>

    <div>
        Welcome, <strong><?php echo $user; ?></strong> |
        <a href="logout.php" class="text-danger">Logout</a>
    </div>
</nav>

<!-- DASHBOARD -->
<div class="dashboard">

    <div class="grid">

        <a href="take_survey.php" class="box">
            <div class="icon take">📋</div>
            <h5>Take Survey</h5>
        </a>

        <a href="view_results.php" class="box">
            <div class="icon result">📊</div>
            <h5>View Results</h5>
        </a>

        <a href="create_survey.php" class="box">
            <div class="icon create">➕</div>
            <h5>Create Survey</h5>
        </a>

        <a href="delete_page.php" class="box">
            <div class="icon delete">🗑</div>
            <h5>Delete Survey</h5>
        </a>

    </div>

</div>

</body>
</html>