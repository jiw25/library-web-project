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
   
    $img_path = '';

    // 사용자가 파일을 업로드했는지 확인
    if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] == 0) {
        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        $filename = $_FILES['book_image']['name'];
        $filetype = $_FILES['book_image']['type'];
        $filesize = $_FILES['book_image']['size'];
        
        // 확장자 확인
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!in_array(strtolower($ext), $allowed)) {
            echo "<script>alert('이미지 파일(jpg, png, gif)만 업로드 가능합니다.'); history.back();</script>";
            exit;
        }

        // 파일명 중복 방지를 위해 현재 시간 추가 (예: cover_12345.jpg)
        $new_filename = uniqid("cover_", true) . "." . $ext;
        $upload_dir = "uploads/";
        
        $destination = $upload_dir . $new_filename;

        // 파일을 임시 폴더에서 uploads 폴더로 이동
        if(move_uploaded_file($_FILES['book_image']['tmp_name'], $destination)) {
            $img_path = $destination; // DB에 저장할 경로
        } else {
            echo "<script>alert('파일 업로드 실패.'); history.back();</script>";
            exit;
        }
    }

    // 등록번호 중복 체크
    $check = mysqli_query($conn, "SELECT * FROM books WHERE reg_number = '$reg_num'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('이미 존재하는 등록번호입니다.'); history.back();</script>";
        exit;
    }

    // 도서 저장 (status는 기본값 'available'로 자동 저장됨)
    $sql = "INSERT INTO books (title, author, reg_number, call_number, story, img_path) 
            VALUES ('$title', '$author', '$reg_num', '$call_num', '$story', '$img_path')";

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