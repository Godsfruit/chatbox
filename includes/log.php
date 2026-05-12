<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config/db.php';

// Fetch messages with the sender's username[cite: 16]
$sql = "SELECT logs.msg, logs.created_at, users.username 
        FROM logs 
        JOIN users ON logs.user_id = users.id 
        ORDER BY logs.log_id ASC";

$result = $conn->query($sql);
?>

<div class="message-list">
<?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='msg-item'>  
                    <span class='msg-user'>". htmlspecialchars($row['username']) . ":</span>
                    <span class='msg-text'>". htmlspecialchars($row['msg']) . "</span>
                    <span class='msg-time'>(" . $row['created_at'] . ")</span> 
                </div>" ;
        }
    } else {
        echo "<p>No messages yet.</p>";
    }

$conn->close();
?>
</div>

