<?php
include 'config/db.php'; // connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $err_password = "Passwords do not match";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $err_username = "Username already exists";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user securely
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $success = "Registration Successful. <a href='login.php'>Login</a>";
            } else {
                $fail = "Registration failed: " . $conn->error;
            }
        }
        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/auth.css">
	<title>Register</title>
</head>
<body>
	<div class="container">
        <form method="POST">
                <h2>Register</h2>
                <?php if(isset($err_password)) echo "<p style='color:red'>$err_password</p>"; ?>
                <?php if(isset($err_username)) echo "<p style='color:red'>$err_username</p>"; ?>
                <?php if(isset($success)) echo "<p style='color: green; text-align: center'>$success</p>"; ?>
                <?php if(isset($fail)) echo "<p style='color: red; text-align: center'>$fail</p>"; ?>

                <div class="form-container">
                    <label for="username">Username</label>
                    <input type="text" name="username" placeholder="Username" required>

                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Email" required>

                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Password" required>

                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    
                    <button type="submit">Register</button>
                </div>
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </form>
        <hr>
        <span style="font-size: 12px; opacity: 50%;">By signing up you accept our <a href="#" style="font-size: 12px;">terms and conditions</a> and <a href="#" style="font-size: 12px;">privacy policy</a></span>
    </div>
</body>
</html>
