<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $date = $_POST['due_date'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO tasks (user_id,title,description,due_date) VALUES (?,?,?,?)");
    $stmt->bind_param("isss", $user_id, $title, $desc, $date);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Task - Student Planner</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Add Task</h2>
<form method="post">
  <label>Title:</label><br>
  <input type="text" name="title" required><br>
  
  <label>Description:</label><br>
  <textarea name="description"></textarea><br>
  
  <label>Due Date:</label><br>
  <input type="date" name="due_date" required><br>
  
  <button type="submit">Add Task</button>
</form>
<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
