<?php
// 1. DB 연결 설정 포함 (파일명이 db_conn.php인지 확인하세요)
include "db_conn.php";

// 2. 폼 데이터가 제출되었을 때(POST 방식) 실행되는 처리 로직
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup_submit'])) {
    
    // 입력값 보안 처리
    $uname = mysqli_real_escape_string($conn, $_POST['user_name']);
    $uid = mysqli_real_escape_string($conn, $_POST['user_id']);
    $uemail = mysqli_real_escape_string($conn, $_POST['user_email']);
    
    // 비밀번호 해시 암호화
    $upw = password_hash($_POST['user_pw'], PASSWORD_DEFAULT);

    // [로직 A] 아이디 중복 체크
    $check_query = "SELECT * FROM users WHERE user_id = '$uid'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('이미 사용 중인 아이디입니다.'); history.back();</script>";
        exit;
    }

    // [로직 B] 데이터베이스에 사용자 정보 저장
    // user_role은 기본적으로 'user'로 설정됩니다.
    $sql = "INSERT INTO users (user_id, user_pw, user_name, user_email, user_role) 
            VALUES ('$uid', '$upw', '$uname', '$uemail', 'user')";

    if (mysqli_query($conn, $sql)) {
        // 성공 시 알림창을 띄우고 로그인 페이지(login.php)로 이동
        echo "<script>
                alert('회원가입이 완료되었습니다! 로그인 해주세요.');
                location.href = 'login.php';
              </script>";
        exit;
    } else {
        // DB 저장 실패 시 에러 메시지 출력
        echo "<script>alert('저장 중 오류 발생: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입 - 도서 관리 시스템</title>
    <style>
        body {
            font-family: 'Malgun Gothic', sans-serif;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 500px;
            text-align: center;
        }
        /* 상단 로고 디자인 */
        .logo-section {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 30px;
        }
        .logo-section h1 {
            font-size: 20px;
            margin: 0;
            text-align: left;
            color: #334155;
            line-height: 1.2;
        }
        .logo-section span {
            display: block;
            font-size: 11px;
            font-weight: normal;
            color: #64748b;
        }
        .title {
            font-size: 36px;
            margin-bottom: 40px;
            font-weight: normal;
            color: #1e293b;
        }
        /* 설계서 2페이지의 2열 그리드 레이아웃 */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 30px;
            row-gap: 20px;
            text-align: left;
        }
        .input-group label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #1e293b;
        }
        /* 설계서의 굵은 회색 테두리 (4px) 디자인 */
        .input-group input {
            width: 100%;
            padding: 12px;
            border: 4px solid #b1b1b1;
            box-sizing: border-box;
            outline: none;
            font-size: 15px;
        }
        .input-group input:focus {
            border-color: #64748b;
        }
        /* 가입 버튼 */
        .signup-btn {
            grid-column: span 2;
            width: 100%;
            padding: 15px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            transition: background 0.2s;
        }
        .signup-btn:hover {
            background-color: #f8fafc;
        }
        .login-link {
            display: block;
            margin-top: 25px;
            font-size: 14px;
            color: #64748b;
            text-decoration: none;
        }
        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- 도서관 로고 섹션 -->
        <div class="logo-section">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#1e40af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
            </svg>
            <div>
                <h1>도서 관리 시스템<span>Library Management System</span></h1>
            </div>
        </div>

        <div class="title">Sign up</div>

        <!-- 폼 데이터를 자기 자신(signup.php)에게 보냄 -->
        <form action="signup.php" method="POST">
            <div class="form-grid">
                <div class="input-group">
                    <label>NAME</label>
                    <input type="text" name="user_name" required>
                </div>
                <div class="input-group">
                    <label>ID</label>
                    <input type="text" name="user_id" required>
                </div>
                <div class="input-group">
                    <label>EMAIL</label>
                    <input type="email" name="user_email" required>
                </div>
                <div class="input-group">
                    <label>PASSWORD</label>
                    <input type="password" name="user_pw" required>
                </div>
                <!-- signup_submit 버튼을 눌러야 상단의 PHP 로직이 작동함 -->
                <button type="submit" name="signup_submit" class="signup-btn">Sign up</button>
            </div>
        </form>

        <a href="login.php" class="login-link">이미 계정이 있나요? 로그인 페이지로 이동</a>
    </div>
</body>
</html>