<?php include "db_conn.php"; ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>로그인 - 도서 관리 시스템</title>
    <style>
        body { font-family: 'Malgun Gothic', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #fff; }
        .login-box { width: 350px; text-align: center; }
        .logo { display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 40px; }
        .logo h1 { font-size: 20px; text-align: left; margin: 0; line-height: 1.2; color: #334155; }
        .logo h1 span { display: block; font-size: 11px; font-weight: normal; color: #64748b; }
        .page-title { font-size: 40px; margin-bottom: 30px; font-weight: normal; color: #1e293b; }
        .input-group { text-align: left; margin-bottom: 20px; }
        .input-group label { display: block; font-weight: bold; font-size: 14px; margin-bottom: 8px; color: #1e293b; }
        .input-group input { 
            width: 100%; 
            padding: 12px; 
            border: 4px solid #b1b1b1; 
            box-sizing: border-box; 
            outline: none; 
            font-size: 16px;
        }
        .login-btn { 
            width: 100%; 
            padding: 14px; 
            background: #fff; 
            border: 1px solid #ccc; 
            font-size: 16px; 
            font-weight: bold;
            cursor: pointer; 
            margin-top: 10px;
        }
        .login-btn:hover { background: #f8fafc; }
        .signup-msg { margin-top: 30px; font-size: 14px; color: #475569; }
        .signup-msg a { color: #e11d48; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo">
            <svg width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#1e40af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
            <h1>도서 관리 시스템<span>Library Management System</span></h1>
        </div>
        <div class="page-title">Login</div>
        <form action="login_process.php" method="POST">
            <div class="input-group">
                <label>ID</label>
                <input type="text" name="user_id" required>
            </div>
            <div class="input-group">
                <label>PASSWORD</label>
                <input type="password" name="user_pw" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
        <div class="signup-msg">
            계정이 없다면? <a href="signup.php">회원가입</a>
        </div>
    </div>
</body>
</html>