<?php
// DB 연결 및 세션 시작
include "db_conn.php";

// 관리자 권한
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    echo "<script>alert('관리자만 접근 가능한 페이지입니다.'); location.href='login.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>관리자 페이지 - 도서 관리 시스템</title>
    <style>
        body { font-family: 'Malgun Gothic', sans-serif; background-color: #fff1f2; margin: 0; padding: 20px; }
        .admin-container { max-width: 1000px; margin: 0 auto; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e11d48; padding-bottom: 15px; margin-bottom: 20px; }
        h1 { color: #9f1239; margin: 0; font-size: 24px; }
        .user-info { font-size: 14px; }
        .logout-btn { color: #ef4444; text-decoration: none; font-weight: bold; margin-left: 10px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f8fafc; padding: 12px; border-bottom: 2px solid #e2e8f0; text-align: left; font-size: 14px; color: #64748b; }
        td { padding: 15px; border-bottom: 1px solid #f1f5f9; font-size: 15px; }
        .status-badge { background: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="header">
            <h1>관리자 전용 : 도서 DB 관리</h1>
            <div class="user-info">
                <strong><?php echo $_SESSION['user_name']; ?></strong> 관리자님 접속 중
                <a href="logout.php" class="logout-btn">로그아웃</a>
            </div>
        </div>

        <p>현재 시스템에 등록된 도서 목록을 관리할 수 있습니다.</p>

        <table>
            <thead>
                <tr>
                    <th>도서 ID</th>
                    <th>제목</th>
                    <th>저자</th>
                    <th>상태</th>
                    <th>관리</th>
                </tr>
            </thead>
            <tbody>
                <!-- 예시 데이터 (나중에 DB에서 불러올 부분) -->
                <tr>
                    <td>#BK-001</td>
                    <td><b>불편한 편의점</b></td>
                    <td>김호연</td>
                    <td><span class="status-badge">대출가능</span></td>
                    <td><button>수정</button> <button style="color:red">삭제</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>

