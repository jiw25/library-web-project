<?php
$conn = mysqli_connect("localhost", "root", "password", "library_db");

if (!$conn) {
    die("연결 실패: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
