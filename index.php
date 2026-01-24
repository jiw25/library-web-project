<?php
// DB 연결 및 세션 시작 파일 포함
include "db_conn.php";

// 로그인 세션(user_id)이 없으면 로그인 페이지로 강제 이동
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
    <style>
        body {
            font-family: 'Malgun Gothic', sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f4f8;
        }
        .success-box {
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
        }
        h1 { color: #1e40af; margin-bottom: 10px; }
        p { font-size: 18px; color: #334155; }
        .user-name { font-weight: bold; color: #e11d48; }
        .logout-btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #64748b;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="success-box">
        <h1>🎉 로그인 성공!</h1>
        <p><span class="user-name"><?php echo $_SESSION['user_name']; ?></span> 님, 환영합니다.</p>
        <p>로그인 처리가 정상적으로 완료되어 <strong>index.php</strong>로 이동했습니다.</p>
        <a href="logout.php" class="logout-btn">로그아웃</a>
    </div>
</body>
</html>