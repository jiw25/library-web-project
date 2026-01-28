<?php
include "db_conn.php";

// 관리자 권한 체크
if (session_status() == PHP_SESSION_NONE) { session_start(); }
$role = isset($_SESSION['user_role']) ? trim($_SESSION['user_role']) : '';
if ($role !== 'admin') {
    die("접근 권한이 없습니다.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $reg_num = mysqli_real_escape_string($conn, $_POST['reg_number']);
    $call_num = mysqli_real_escape_string($conn, $_POST['call_number']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $story = mysqli_real_escape_string($conn, $_POST['story']);

    // 수정 쿼리 실행
    $sql = "UPDATE books SET 
            title = '$title', 
            author = '$author', 
            reg_number = '$reg_num', 
            call_number = '$call_num', 
            status = '$status',
            story = '$story' 
            WHERE book_id = '$book_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('도서 정보가 수정되었습니다.');
            location.href='admin_list.php';
        </script>";
    } else {
        echo "<script>alert('수정 실패: " . mysqli_error($conn) . "'); history.back();</script>";
    }
}
?>