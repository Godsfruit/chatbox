<?php 
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'config/db.php'; 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/home.css">
    <title>Chat Home</title>
</head>
<body>
    <div class="chat-header">
        <h2>GF_ChAtBoX</h2>
        <span>Welcome, <strong><?php echo $_SESSION['username']; ?></strong> | </span>
        <a href="includes/logout.php">Logout</a> 
    </div>

    <div class="message-list">
        <?php include 'includes/logs.php'; ?> 
    </div>

    <form action="includes/insert.php" method="POST" class="chat-form"> 
        <input type="text" name="msg" placeholder="Type a message..." required autocomplete="off">
        <button type="submit">Send</button>
    </form>
</body>
</html>
