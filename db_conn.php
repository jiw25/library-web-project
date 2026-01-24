<?php
$conn = mysqli_connect("localhost", "root", "341205", "library_db");
if (!$conn) {
    die("연결 실패: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
?>
