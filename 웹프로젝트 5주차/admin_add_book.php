<?php
include "db_conn.php";

// 관리자 권한 체크
$role = isset($_SESSION['user_role']) ? trim($_SESSION['user_role']) : '';
if ($role !== 'admin') {
    echo "<script>alert('관리자만 접근 가능합니다.'); location.href='index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>도서 등록 - 관리자</title>
    <style>
        body { font-family: 'Malgun Gothic', sans-serif; background-color: #f8fafc; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { width: 500px; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #1e293b; margin-bottom: 30px; }
        
        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; font-weight: bold; margin-bottom: 8px; color: #333; }
        .input-group input, .input-group textarea { width: 100%; padding: 12px; border: 4px solid #b1b1b1; box-sizing: border-box; font-size: 15px; outline: none; }
        .input-group input:focus { border-color: #64748b; }
        .input-group input[type="file"] { padding: 10px; background: #f1f5f9; border: 2px dashed #b1b1b1; }
        
        .btn-group { display: flex; gap: 10px; margin-top: 20px; }
        .btn { flex: 1; padding: 15px; font-weight: bold; cursor: pointer; border: none; font-size: 16px; }
        .btn-save { background: #1e293b; color: white; }
        .btn-cancel { background: #cbd5e1; color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <h2>신규 도서 등록</h2>
        <form action="admin_add_process.php" method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <label>책 제목 (Title)</label>
                <input type="text" name="title" required>
            </div>
            <div class="input-group">
                <label>저자 (Author)</label>
                <input type="text" name="author" required>
            </div>
            <div class="input-group">
                <label>등록 번호 (Reg No.)</label>
                <input type="text" name="reg_number" placeholder="예: 00001" required>
            </div>
            <div class="input-group">
                <label>청구 기호 (Call No.)</label>
                <input type="text" name="call_number" placeholder="예: 800 문 123" required>
            </div>
            <div class="input-group">
                <label>도서 표지 이미지 (Cover Image)</label>
                <input type="file" name="book_image" accept="image/*">
            </div>
            <div class="input-group full-width">
                    <label>줄거리 (Story)</label>
                    <textarea name="story" placeholder="도서의 상세 줄거리를 입력하세요..."></textarea>
            </div>
            
            <div class="btn-group">
                <button type="button" class="btn btn-cancel" onclick="location.href='admin_list.php'">취소</button>
                <button type="submit" class="btn btn-save">도서 저장</button>
            </div>
        </form>
    </div>
</body>
</html>