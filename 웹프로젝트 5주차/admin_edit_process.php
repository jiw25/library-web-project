<?php
include "db_conn.php";

// 세션 및 권한 체크
if (session_status() == PHP_SESSION_NONE) { session_start(); }
$role = isset($_SESSION['user_role']) ? trim($_SESSION['user_role']) : '';
if ($role !== 'admin') {
    die("접근 권한이 없습니다.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 입력값 보안 처리
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $reg_num = mysqli_real_escape_string($conn, $_POST['reg_number']);
    $call_num = mysqli_real_escape_string($conn, $_POST['call_number']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $story = mysqli_real_escape_string($conn, $_POST['story']);

    //기본 업데이트 쿼리 선언 (이미지 제외 항목들)
    $sql = "UPDATE books SET 
            title = '$title', 
            author = '$author', 
            reg_number = '$reg_num', 
            call_number = '$call_num', 
            status = '$status',
            story = '$story'";

    // 이미지가 새로 업로드되었는지 확인
    if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] == 0) {
        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        $filename = $_FILES['book_image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if(in_array($ext, $allowed)) {
            $upload_dir = "uploads/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // 새 파일명 생성 및 업로드
            $new_filename = uniqid("cover_", true) . "." . $ext;
            $destination = $upload_dir . $new_filename;

            if(move_uploaded_file($_FILES['book_image']['tmp_name'], $destination)) {
                // 성공 시에만 기존 쿼리에 이미지 경로 업데이트 문구를 이어 붙임 (점 . 필수)
                $sql .= ", img_path = '$destination'";
            }
        } else {
            echo "<script>alert('이미지 파일만 업로드 가능합니다.'); history.back();</script>";
            exit;
        }
    }

    // WHERE 조건 추가
    $sql .= " WHERE book_id = '$book_id'";

    // 쿼리 실행
    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('도서 정보가 성공적으로 수정되었습니다.');
            location.href='admin_list.php';
        </script>";
    } else {
        echo "<script>alert('수정 실패: " . mysqli_error($conn) . "'); history.back();</script>";
    }
}