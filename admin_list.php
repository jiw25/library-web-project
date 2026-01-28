<?php
include "db_conn.php";

// 1. 세션 시작 확인
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 2. 관리자 권한 체크
$role = isset($_SESSION['user_role']) ? trim($_SESSION['user_role']) : '';
if ($role !== 'admin') {
    echo "<script>alert('관리자만 접근 가능합니다.'); location.href='index.php';</script>";
    exit;
}

// 3. 도서 목록 조회 (최신 등록순)
$sql = "SELECT * FROM books ORDER BY book_id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>관리자 모드 - 도서 관리</title>
    <style>
        body { font-family: 'Malgun Gothic', sans-serif; background-color: #fff; margin: 0; padding: 40px; }
        .container { max-width: 1200px; margin: 0 auto; }
        
        /* 상단 헤더 */
        .logo { display: flex; align-items: center; gap: 10px; color: #1e3a8a; font-size: 18px; font-weight: bold; margin-bottom: 20px; }
        h1 { color: #1e3a8a; font-size: 24px; margin-bottom: 30px; }
        
        /* 버튼 영역 */
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-add { 
            padding: 10px 20px; 
            border: 2px solid #000; 
            border-radius: 30px; 
            background: #fff; 
            color: #b91c1c; /* 붉은 텍스트 */
            font-weight: bold; 
            text-decoration: none; 
            transition: 0.2s;
        }
        .btn-add:hover { background: #fff1f2; }


        /* 테이블 디자인 */
        table { width: 100%; border-collapse: collapse; border: 1px solid #ccc; }
        th { border: 1px solid #ccc; padding: 12px; text-align: center; color: #1e3a8a; background-color: #fff; font-weight: normal; }
        td { border: 1px solid #ccc; padding: 12px; text-align: center; color: #333; }
        
        /* 관리 버튼 */
        .action-link { color: #333; text-decoration: none; font-size: 14px; margin: 0 5px; }
        .action-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
            도서 관리 시스템 Library Management System
        </div>
        
        <h1>도서 DB 관리</h1>
        
        <div class="top-bar">
            <!-- 검색창 (디자인만) -->
            <div style="flex-grow: 1; margin-right: 20px;"></div> 
            <a href="admin_add_book.php" class="btn-add">신규 도서 추가</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 25%;">책 제목 / 저자</th>
                    <th style="width: 15%;">등록 번호</th>
                    <th style="width: 20%;">청구기호</th>
                    <th style="width: 15%;">상태</th>
                    <th style="width: 15%;">관리</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="text-align: left; padding-left: 20px;">
                        <div style="font-weight: bold; font-size: 16px;"><?php echo $row['title']; ?></div>
                        <div style="font-size: 13px; color: #666;">/ <?php echo $row['author']; ?></div>
                    </td>
                    <td><?php echo $row['reg_number']; ?></td>
                    <td><?php echo $row['call_number']; ?></td>
                    <td>
                        <!-- 대출 상태 표시 -->
                        <?php echo ($row['status'] == 'available') ? '대출 가능' : '<span style="color:red">대출 중</span>'; ?>
                    </td>
                    <td>
                         <a href="admin_edit_book.php?id=<?php echo $row['book_id']; ?>" class="btn btn-edit">수정</a>
                         <a href="admin_delete_process.php?id=<?php echo $row['book_id']; ?>" class="btn btn-delete" onclick="return confirm('정말 이 도서를 삭제하시겠습니까?');">삭제</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                
                <?php if(mysqli_num_rows($result) == 0): ?>
                <tr>
                    <td colspan="5" style="padding: 50px; color: #999;">등록된 도서가 없습니다.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>




