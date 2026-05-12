<?php
session_start();
include '../config/db.php';

if(isset($_SESSION['user_id']) && !empty($_POST['msg'])) {
    $user_id = $_SESSION['user_id']; 
    $msg = trim($_POST['msg']);

    $stmt = $conn->prepare("INSERT INTO logs (user_id, msg) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $msg);
    $stmt->execute();
    $stmt->close();
}
header("Location: ../home.php");
exit();
?>
