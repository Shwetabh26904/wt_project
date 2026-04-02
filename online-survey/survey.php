<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$survey_id = isset($_GET['id']) ? $_GET['id'] : 0;

// fetch questions
$questions = $conn->query("SELECT * FROM questions WHERE survey_id = $survey_id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Survey</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            transition: 0.3s;
        }

        /* 🌈 Gradient Background */
        body.light {
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
        }

        body.dark {
            background: linear-gradient(135deg, #1e1e2f, #2c2c54);
            color: white;
        }

        .survey-box {
            max-width: 800px;
            margin: 40px auto;
            padding: 25px;
            border-radius: 15px;
            background: white;
        }

        body.dark .survey-box {
            background: #2b2b3c;
        }

        .question-card {
            margin-bottom: 20px;
        }

        .option-box {
            display: block;
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
        }

        .option-box:hover {
            background: #eee;
        }

        body.dark .option-box:hover {
            background: #444;
        }

        .question-img {
            max-width: 100%;
            margin: 10px 0;
            border-radius: 10px;
        }

        .toggle-btn {
            position: fixed;
            top: 15px;
            right: 15px;
        }
    </style>
</head>

<body class="light">

<!-- 🌙 Dark Mode Toggle -->
<button class="btn btn-dark toggle-btn" onclick="toggleMode()">🌙</button>

<div class="survey-box shadow">

    <h3 class="mb-3">Fill Survey</h3>

    <form action="submit.php" method="POST">

        <input type="hidden" name="survey_id" value="<?php echo $survey_id; ?>">

        <!-- Roll No -->
        <input type="text" name="roll_no" class="form-control mb-3" placeholder="Enter Roll No" required>

        <?php
        $qno = 1;

        while ($q = $questions->fetch_assoc()) {

            echo "<div class='question-card'>";
            echo "<h5>Q".$qno.". ".$q['question']."</h5>";

            // 🖼 SHOW IMAGE
            if (!empty($q['image'])) {
                echo "<img src='".$q['image']."' class='question-img'>";
            }

            $type = $q['type'];
            $options = $conn->query("SELECT * FROM options WHERE question_id=".$q['id']);

            // RADIO
            if($type == "radio") {
                while ($opt = $options->fetch_assoc()) {
                    echo "<label class='option-box'>
                            <input type='radio' name='q".$q['id']."' value='".$opt['id']."' required>
                            ".$opt['option_text']."
                          </label>";
                }
            }

            // CHECKBOX
            elseif($type == "checkbox") {
                while ($opt = $options->fetch_assoc()) {
                    echo "<label class='option-box'>
                            <input type='checkbox' name='q".$q['id']."[]' value='".$opt['id']."'>
                            ".$opt['option_text']."
                          </label>";
                }
            }

            // TEXT
            elseif($type == "text") {
                echo "<input type='text' name='q".$q['id']."' class='form-control'>";
            }

            // RATING
            elseif($type == "rating") {
                for($i=1; $i<=5; $i++) {
                    echo "<label class='me-2'>
                            <input type='radio' name='q".$q['id']."' value='$i'> ⭐$i
                          </label>";
                }
            }

            // SLIDER
            elseif($type == "slider") {
                echo "<input type='range' name='q".$q['id']."' min='1' max='10' class='form-range'>";
            }

            echo "</div>";

            $qno++;
        }
        ?>

        <button class="btn btn-primary w-100 mt-3">Submit</button>

    </form>

</div>

<script>
function toggleMode() {
    let body = document.body;

    if(body.classList.contains("light")) {
        body.classList.remove("light");
        body.classList.add("dark");
    } else {
        body.classList.remove("dark");
        body.classList.add("light");
    }
}
</script>

</body>
</html>