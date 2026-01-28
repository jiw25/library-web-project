<?php
include "db_conn.php";

// 관리자 권한 체크
if (session_status() == PHP_SESSION_NONE) { session_start(); }
$role = isset($_SESSION['user_role']) ? trim($_SESSION['user_role']) : '';
if ($role !== 'admin') {
    echo "<script>alert('관리자만 접근 가능합니다.'); location.href='index.php';</script>";
    exit;
}

// 수정할 도서 ID 받기
if (!isset($_GET['id'])) {
    echo "<script>alert('잘못된 접근입니다.'); location.href='admin_list.php';</script>";
    exit;
}

$book_id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM books WHERE book_id = '$book_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('존재하지 않는 도서입니다.'); location.href='admin_list.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>도서 수정 - 관리자</title>
    <style>
        body { font-family: 'Malgun Gothic', sans-serif; background-color: #f8fafc; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 20px; }
        .container { width: 600px; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #1e293b; margin-bottom: 30px; }
        
        .input-group { margin-bottom: 15px; }
        .input-group label { display: block; font-weight: bold; margin-bottom: 8px; color: #333; }
        
        .input-group input, .input-group textarea, .input-group select { 
            width: 100%; padding: 12px; border: 4px solid #b1b1b1; box-sizing: border-box; 
            font-size: 15px; outline: none; border-radius: 5px; font-family: 'Malgun Gothic', sans-serif;
        }
        .input-group input:focus, .input-group textarea:focus, .input-group select:focus { border-color: #64748b; }
        .input-group textarea { height: 120px; resize: vertical; }
        
        .btn-group { display: flex; gap: 10px; margin-top: 20px; }
        .btn { flex: 1; padding: 15px; font-weight: bold; cursor: pointer; border: none; font-size: 16px; }
        .btn-save { background: #fbbf24; color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,0.2); }
        .btn-cancel { background: #cbd5e1; color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <h2>도서 정보 수정</h2>
        <form action="admin_edit_process.php" method="POST">
            <!-- 어떤 책을 수정하는지 알기 위해 숨겨진 ID 값 전송 -->
            <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">

            <div class="input-group">
                <label>책 제목</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required>
            </div>
            <div class="input-group">
                <label>저자</label>
                <input type="text" name="author" value="<?php echo htmlspecialchars($row['author']); ?>" required>
            </div>
            <div class="input-group">
                <label>등록 번호</label>
                <input type="text" name="reg_number" value="<?php echo htmlspecialchars($row['reg_number']); ?>" required>
            </div>
            <div class="input-group">
                <label>청구 기호</label>
                <input type="text" name="call_number" value="<?php echo htmlspecialchars($row['call_number']); ?>" required>
            </div>
            
            <!-- 관리자가 직접 대출 상태를 변경할 수 있도록 셀렉트 박스 추가 -->
            <div class="input-group">
                <label>대출 상태 (강제 변경 가능)</label>
                <select name="status">
                    <option value="available" <?php if($row['status'] == 'available') echo 'selected'; ?>>대출 가능</option>
                    <option value="rented" <?php if($row['status'] == 'rented') echo 'selected'; ?>>대출 중 (불가)</option>
                </select>
            </div>

            <div class="input-group">
                <label>줄거리</label>
                <textarea name="story"><?php echo htmlspecialchars($row['story']); ?></textarea>
            </div>
            
            <div class="btn-group">
                <button type="button" class="btn btn-cancel" onclick="location.href='admin_list.php'">취소</button>
                <button type="submit" class="btn btn-save">수정 완료</button>
            </div>
        </form>
    </div>
</body>
</html>