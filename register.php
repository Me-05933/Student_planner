<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username,email,password) VALUES (?,?,?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $conn->insert_id;
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register - Student Planner</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Register</h2>
<form method="post">
  <label>Username:</label><br>
  <input type="text" name="username" required><br>
  
  <label>Email:</label><br>
  <input type="email" name="email" required><br>
  
  <label>Password:</label><br>
  <input type="password" name="password" required><br>
  
  <button type="submit">Register</button>
</form>
<a href="login.php">Already have an account? Login</a>
</body>
</html>
