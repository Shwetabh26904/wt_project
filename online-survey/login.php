<?php
include 'db.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card p-4 shadow">

        <h3>Login</h3>

        <form method="POST">
            <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

            <button class="btn btn-success">Login</button>
        </form>

        <br>
        <a href="register.php">Create account</a>

    </div>
</div>

</body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE username='$username'");

    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])) {
            $_SESSION['user'] = $username;
            header("Location: index.php");
        } else {
            echo "<p style='color:red;text-align:center;'>Wrong password</p>";
        }
    } else {
        echo "<p style='color:red;text-align:center;'>User not found</p>";
    }
}
?>