<?php
// DB 연결 및 세션 시작 파일 포함
include "db_conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 보안을 위한 입력값 필터링
    $uid = mysqli_real_escape_string($conn, $_POST['user_id']);
    $upw = $_POST['user_pw'];

    // 1. 아이디로 사용자 조회
    $sql = "SELECT * FROM users WHERE user_id = '$uid'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // 2. 비밀번호 검증 (DB의 암호화된 값과 사용자가 입력한 1234 비교)
        if (password_verify($upw, $row['user_pw'])) {
            // 세션에 유저 정보 저장
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_role'] = $row['user_role'];

            // 3. 권한에 따른 이동 경로 분기 (가장 중요한 부분)
            if ($row['user_role'] === 'admin') {
                // 관리자 계정이면 바로 관리자 리스트로 이동
                echo "<script>
                    alert('관리자 계정으로 로그인되었습니다.');
                    location.href = 'admin_list.php';
                </script>";
            } else {
                // 일반 계정이면 메인 페이지(index.php)로 이동
                echo "<script>
                    alert('" . $row['user_name'] . "님 환영합니다.');
                    location.href = 'index.php';
                </script>";
            }
            exit;
        } else {
            echo "<script>alert('비밀번호가 일치하지 않습니다.'); history.back();</script>";
        }
    } else {
        echo "<script>alert('존재하지 않는 아이디입니다.'); history.back();</script>";
    }
}
?>