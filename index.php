<?php
$conn = new mysqli('localhost', 'root', '', 'todo_db');



if (isset($_POST['title'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $conn->query("INSERT INTO tasks (tasks, created_at) VALUES ('$title', NOW())");

}

// Handle task completion toggle
if (isset($_GET['complete'])) {
    $id = (int)$_GET['complete'];
    $conn->query("UPDATE tasks SET completed = NOT completed WHERE id = $id");
}

// Handle task deletion
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM tasks WHERE id = $id");
}

// Fetch tasks
$tasks = $conn->query("SELECT * FROM tasks WHERE Completed = 0 ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>To-Do List</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <h1>To-Do List</h1>
    <form method="POST">
        <input type="text" name="title" required>
        <button type="submit">Add Task</button>
    </form>
    <ul>
      <ul>
    <?php while($row = $tasks->fetch_assoc()): ?>
        <li class="<?php echo $row['Completed'] ? 'completed' : ''; ?>">
    <span class="tasks-text"><?php echo htmlspecialchars($row['tasks']); ?></span>
    <div class="button-group">
        <?php if (!$row['Completed']): ?>
            <a href="?complete=<?php echo $row['id']; ?>" class="btn complete" title="Mark as complete">
                <i class="fas fa-check"></i>
            </a>
        <?php endif; ?>
        <a href="?delete=<?php echo $row['id']; ?>" class="btn delete" onclick="return confirm('Are you sure?')" title="Delete task">
            <i class="fas fa-trash"></i>
        </a>
    </div>
</li>
    <?php endwhile; ?>
</ul>
    </ul>
</body>
</html>


