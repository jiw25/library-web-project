<?php
include "db_conn.php";

// 관리자 권한 체크
if (session_status() == PHP_SESSION_NONE) { session_start(); }
$role = isset($_SESSION['user_role']) ? trim($_SESSION['user_role']) : '';
if ($role !== 'admin') {
    die("접근 권한이 없습니다.");
}

// GET 파라미터로 넘어온 도서 ID 확인
if (isset($_GET['id'])) {
    $book_id = mysqli_real_escape_string($conn, $_GET['id']);

    // 삭제 쿼리 실행
    $sql = "DELETE FROM books WHERE book_id = '$book_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('도서가 삭제되었습니다.');
            location.href='admin_list.php';
        </script>";
    } else {
        echo "<script>alert('삭제 실패: " . mysqli_error($conn) . "'); history.back();</script>";
    }
} else {
    echo "<script>alert('잘못된 접근입니다.'); location.href='admin_list.php';</script>";
}
?>