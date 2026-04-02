<?php
include 'db.php';

$error = "";

if($_POST){

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// check if user exists
$check = $conn->query("SELECT * FROM users WHERE username='$username'");

if($check->num_rows > 0){
    $error = "Username already exists";
}else{
    $conn->query("INSERT INTO users(username,password) VALUES('$username','$password')");
    header("Location: login.php");
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(-45deg, #4facfe, #00f2fe, #667eea, #764ba2);
    background-size: 400% 400%;
    animation: gradientBG 10s ease infinite;
    font-family: 'Segoe UI', sans-serif;
}

@keyframes gradientBG {
    0% {background-position:0% 50%;}
    50% {background-position:100% 50%;}
    100% {background-position:0% 50%;}
}

.register-box {
    max-width: 400px;
    margin: 100px auto;
}

.card {
    border-radius: 15px;
}

.btn-custom {
    background: #4facfe;
    border: none;
}

.btn-custom:hover {
    background: #3b8be0;
}
</style>
</head>

<body>

<div class="register-box">

<div class="card shadow p-4">

<h3 class="text-center mb-3">📝 Register</h3>

<?php if($error){ ?>
<div class="alert alert-danger"><?php echo $error; ?></div>
<?php } ?>

<form method="POST">

<input type="text" name="username" class="form-control mb-3" placeholder="Username" required>

<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

<button class="btn btn-custom w-100">Register</button>

</form>

<p class="text-center mt-3">
Already have an account? <a href="login.php">Login</a>
</p>

</div>

</div>

</body>
</html>