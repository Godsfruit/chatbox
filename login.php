<?php
session_start();
include 'config/db.php'; // Path to config folder

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: home.php");
            exit();
        }
    }
    $error = "Invalid credentials";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/auth.css">
    <title>Chat Login</title>
</head>
<body>
    <div class="container">
        <form method="POST">
            <h2>Login</h2>
            <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Username" required>

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Login</button>
            <p>New? <a href="register.php">Register here</a></p>
        </form>
    </div>
</body>
</html>
