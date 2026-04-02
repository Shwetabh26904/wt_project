<?php
include 'db.php';

if($_POST){

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];
$org_name = $_POST['org_name'];

// check org
$check = $conn->query("SELECT * FROM organizations WHERE name='$org_name'");

if($check->num_rows > 0){
    $org = $check->fetch_assoc();
    $org_id = $org['id'];
}else{
    $conn->query("INSERT INTO organizations(name) VALUES('$org_name')");
    $org_id = $conn->insert_id;
}

// insert user
$conn->query("INSERT INTO users(username,password,role,org_id)
VALUES('$username','$password','$role','$org_id')");

header("Location: login.php");
}
?>

<form method="POST">
<input name="username" placeholder="Username" required>
<input name="password" type="password" placeholder="Password" required>

<select name="role">
<option value="student">Student</option>
<option value="admin">Teacher/Admin</option>
</select>

<input name="org_name" placeholder="Organization Name" required>

<button>Register</button>
</form>