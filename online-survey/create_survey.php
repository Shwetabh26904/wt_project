<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Survey</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card p-4 shadow">

        <h3>Create Survey</h3>

        <form action="save_survey.php" method="POST" enctype="multipart/form-data">

            <!-- Creator -->
            <input type="text" name="created_by" class="form-control mb-3" placeholder="Your Name / Roll No" required>

            <input type="text" name="title" class="form-control mb-3" placeholder="Survey Title" required>

            <div id="questions"></div>

            <button type="button" class="btn btn-secondary mb-3" onclick="addQuestion()">➕ Add Question</button>

            <br>

            <button class="btn btn-primary">Save Survey</button>

        </form>
    </div>
</div>

<script>
let qCount = 0;

function addQuestion() {
    qCount++;

    let html = `
    <div class="card p-3 mb-3" id="qBox${qCount}">

        <div class="d-flex justify-content-between">
            <strong>Question ${qCount}</strong>
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteQuestion(${qCount})">❌</button>
        </div>

        <input type="text" name="questions[${qCount}]" class="form-control mb-2" placeholder="Question" required>

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