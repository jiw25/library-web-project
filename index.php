<?php
include "db_conn.php";

// 로그인 세션(user_id)이 없으면 로그인 페이지로 이동
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>홈 - 도서 관리 시스템</title>
</head>
<body>
    <div class="success-box">
        <h1>로그인 성공</h1>
        <p><span class="user-name"><?php echo $_SESSION['user_name']; ?></span> 님, 환영합니다.</p>
        <p>로그인 처리가 정상적으로 완료되어 <strong>index.php</strong>로 이동했습니다.</p>
        <a href="logout.php" class="logout-btn">로그아웃</a>
    </div>
</body>

</html>


