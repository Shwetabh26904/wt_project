<?php
include 'db.php';

$survey_id = $_POST['survey_id'];
$roll_no = $_POST['roll_no'];

// 🚫 Check duplicate submission
$check = $conn->query("SELECT * FROM responses 
                       WHERE survey_id='$survey_id' 
                       AND roll_no='$roll_no'");

if ($check->num_rows > 0) {
    echo "<h3 style='text-align:center;color:red;'>❌ You already submitted this survey!</h3>";
    exit();
}

// ✅ Save answers
foreach ($_POST as $key => $value) {

    // Only process question inputs (q1, q2, etc.)
    if (strpos($key, 'q') === 0) {

        $question_id = substr($key, 1);

        // For checkbox (multiple answers)
        if (is_array($value)) {

            foreach ($value as $val) {

                $conn->query("INSERT INTO responses 
                (survey_id, question_id, answer, roll_no) 
                VALUES ('$survey_id','$question_id','$val','$roll_no')");
            }

        } else {

            // 🔥 THIS IS YOUR LINE (correct place)
            $conn->query("INSERT INTO responses 
            (survey_id, question_id, answer, roll_no) 
            VALUES ('$survey_id','$question_id','$value','$roll_no')");
        }
    }
}

echo "<h3 style='text-align:center;color:green;'>✅ Survey Submitted Successfully!</h3>";
?>