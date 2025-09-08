<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if task ID is provided
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$task_id = $_GET['id'];

// Fetch existing task data
$stmt = $conn->prepare("SELECT * FROM tasks WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Task not found.";
    exit();
}

$task = $result->fetch_assoc();

// Handle update submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $date = $_POST['due_date'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE tasks SET title=?, description=?, due_date=?, status=? WHERE id=? AND user_id=?");
    $stmt->bind_param("ssssii", $title, $desc, $date, $status, $task_id, $user_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Task - Student Planner</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Edit Task</h2>
<form method="post">
  <label>Title:</label><br>
  <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required><br>

  <label>Description:</label><br>
  <textarea name="description"><?= htmlspecialchars($task['description']) ?></textarea><br>

  <label>Due Date:</label><br>
  <input type="date" name="due_date" value="<?= $task['due_date'] ?>" required><br>

  <label>Status:</label><br>
  <select name="status">
    <option value="pending" <?= $task['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
    <option value="completed" <?= $task['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
  </select><br><br>

  <button type="submit">Update Task</button>
</form>
<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
