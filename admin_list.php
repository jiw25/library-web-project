<?php
include "db_conn.php";
$role = isset($_SESSION['user_role']) ? trim($_SESSION['user_role']) : '';

if ($role !== 'admin') {
    echo "<script>
        alert('관리자만 접근 가능한 페이지입니다.\\n(현재 권한: " . $role . ")'); 
        location.href='index.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>관리자 페이지 - 도서 관리 시스템</title>
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




