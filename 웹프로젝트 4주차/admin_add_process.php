<?php
include "db_conn.php";

// 관리자 권한 체크
$role = isset($_SESSION['user_role']) ? trim($_SESSION['user_role']) : '';
if ($role !== 'admin') {
    die("접근 권한이 없습니다.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $reg_num = mysqli_real_escape_string($conn, $_POST['reg_number']);
    $call_num = mysqli_real_escape_string($conn, $_POST['call_number']);
    $story = mysqli_real_escape_string($conn, $_POST['story']);

    // 등록번호 중복 체크
    $check = mysqli_query($conn, "SELECT * FROM books WHERE reg_number = '$reg_num'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('이미 존재하는 등록번호입니다.'); history.back();</script>";
        exit;
    }

    // 도서 저장 (status는 기본값 'available'로 자동 저장됨)
    $sql = "INSERT INTO books (title, author, reg_number, call_number, story) 
            VALUES ('$title', '$author', '$reg_num', '$call_num', '$story')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('도서가 성공적으로 등록되었습니다.');
            location.href='admin_list.php';
        </script>";
    } else {
        echo "<script>alert('오류 발생: " . mysqli_error($conn) . "'); history.back();</script>";
    }
}
?>