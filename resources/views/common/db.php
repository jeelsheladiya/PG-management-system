<?php
$conn = new mysqli("127.0.0.1", "rathod", "root_123", "pg_project");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>