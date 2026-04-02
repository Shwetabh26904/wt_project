<?php
include 'db.php';
session_start();

if($_POST){

$res = $conn->query("SELECT * FROM users WHERE username='".$_POST['username']."'");
$user = $res->fetch_assoc();

if($user && password_verify($_POST['password'],$user['password'])){

    $_SESSION['user'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['org_id'] = $user['org_id'];

    header("Location: index.php");
}
}
?>

<form method="POST">
<input name="username" required>
<input name="password" type="password" required>
<button>Login</button>
</form>