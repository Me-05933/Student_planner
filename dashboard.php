<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM tasks WHERE user_id=$user_id ORDER BY due_date");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard - Student Planner</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Your Planner</h2>
<a href="add_task.php">+ Add Task</a> | 
<a href="logout.php">Logout</a>
</div>
<hr>

<ul>
<?php while ($row = $result->fetch_assoc()): ?>
  <li>
    <strong><?= htmlspecialchars($row['title']) ?></strong> 
    (<?= $row['due_date'] ?>) - <?= $row['status'] ?><br>
    <?= htmlspecialchars($row['description']) ?><br>
    <a href="edit_task.php?id=<?= $row['id'] ?>">Edit</a> | 
    <a href="delete_task.php?id=<?= $row['id'] ?>">Delete</a>
  </li>
  <hr>
<?php endwhile; ?>
</ul>
</body>
</html>
