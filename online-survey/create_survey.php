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
    <title>Create Survey</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(-45deg, #4facfe, #00f2fe, #667eea, #764ba2);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
            font-family: 'Segoe UI', sans-serif;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
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
        }

        .card {
            border-radius: 15px;
        }

        .question-card {
            background: #f9f9ff;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav>
    <div>📊 SurveyPro</div>
    <div>
        Welcome <?php echo $user; ?> |
        <a href="logout.php">Logout</a>
    </div>
</nav>

<div class="container-box">

<div class="card shadow p-4">

<h3 class="mb-3">➕ Create Survey</h3>

<form action="save_survey.php" method="POST" enctype="multipart/form-data">

<input type="text" name="title" class="form-control mb-3" placeholder="Survey Title" required>

<input type="hidden" name="created_by" value="<?php echo $user; ?>">

<div id="questions"></div>

<button type="button" class="btn btn-secondary mb-3" onclick="addQuestion()">➕ Add Question</button>

<br>

<button class="btn btn-primary w-100">Save Survey</button>

</form>

</div>
</div>

<script>
let qCount = 0;

function addQuestion() {
    qCount++;

    let html = `
    <div class="question-card" id="qBox${qCount}">

        <div class="d-flex justify-content-between">
            <strong>Question ${qCount}</strong>
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteQuestion(${qCount})">❌</button>
        </div>

        <input type="text" name="questions[${qCount}]" class="form-control mb-2" placeholder="Enter question" required>

        <select name="types[${qCount}]" class="form-control mb-2" onchange="changeType(${qCount}, this.value)">
            <option value="radio">Radio</option>
            <option value="checkbox">Checkbox</option>
            <option value="text">Text</option>
            <option value="rating">Rating</option>
            <option value="slider">Slider</option>
        </select>

        <input type="file" name="images[${qCount}]" class="form-control mb-2">

        <div id="options${qCount}">
            <div class="d-flex mb-2" id="opt${qCount}_1">
                <input type="text" name="options[${qCount}][]" class="form-control" placeholder="Option">
                <button type="button" class="btn btn-danger btn-sm ms-2" onclick="deleteOption(${qCount},1)">❌</button>
            </div>
        </div>

        <button type="button" class="btn btn-sm btn-info" onclick="addOption(${qCount})">Add Option</button>

    </div>
    `;

    document.getElementById("questions").insertAdjacentHTML('beforeend', html);
}

function deleteQuestion(qId) {
    document.getElementById("qBox"+qId).remove();
}

function addOption(qId) {
    let count = document.querySelectorAll(`#options${qId} div`).length + 1;

    let html = `
    <div class="d-flex mb-2" id="opt${qId}_${count}">
        <input type="text" name="options[${qId}][]" class="form-control" placeholder="Option">
        <button type="button" class="btn btn-danger btn-sm ms-2" onclick="deleteOption(${qId},${count})">❌</button>
    </div>`;

    document.getElementById("options"+qId).insertAdjacentHTML('beforeend', html);
}

function deleteOption(qId, optId) {
    document.getElementById(`opt${qId}_${optId}`).remove();
}

function changeType(qId, type) {
    let box = document.getElementById("options"+qId);

    if(type === "text" || type === "slider" || type === "rating") {
        box.innerHTML = "<small>No options needed</small>";
    }
}
</script>

</body>
</html>
