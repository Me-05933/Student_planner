<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id,password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        header("Location: dashboard.php");
    } else {
        echo "Invalid login.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login - Student Planner</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Login</h2>
<form method="post">
  <label>Username:</label><br>
  <input type="text" name="username" required><br>
  
  <label>Password:</label><br>
  <input type="password" name="password" required><br>
  
  <button type="submit">Login</button>
</form>
<a href="register.php">Don’t have an account? Register</a>
</body>
</html>
