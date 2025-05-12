<?php
session_start();
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST["email"]);
    $password = $_POST["password"];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        header("Location: todo.php"); // Redirect to to-do list
        exit();
    } else {
        echo "Invalid login credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Log In</title>
</head>
<body>
    <h2>Log In</h2>
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Log In">
    </form>
    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
</body>
</html>