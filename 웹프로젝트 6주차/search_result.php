<?php
include "db_conn.php";

// 로그인 세션 체크
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 검색어 가져오기 및 보안 처리
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';

// 검색 실행 (제목 또는 저자 필터링)
$sql = "SELECT * FROM books WHERE title LIKE '%$keyword%' OR author LIKE '%$keyword%' ORDER BY title ASC";
$result = mysqli_query($conn, $sql);
$total_rows = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>'<?php echo htmlspecialchars($keyword); ?>' 검색 결과</title>
    <!-- 공통 스타일 시트 연결 -->
    <link rel="stylesheet" href="style.css">
    <style>
        .highlight { color: #e11d48; font-weight: bold; }
        .no-result { text-align: center; padding: 100px 0; color: #94a3b8; grid-column: span 3; }
    </style>
</head>
<body>

<div class="layout-wrapper">
    <!-- 사이드바 -->
    <nav class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="index.php">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    홈
                </a>
            </li>
            <li>
                <a href="mypage.php">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    마이페이지
                </a>
            </li>
            <li style="margin-top: 50px;">
                <a href="logout.php" style="font-size: 14px; color: #94a3b8;">로그아웃</a>
            </li>
        </ul>

        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a href="admin_list.php" class="admin-link">관리자 페이지</a>
        <?php endif; ?>
    </nav>

    <!-- 메인 컨텐츠 -->
    <div class="main-content">
        <!-- 상단 헤더  -->
        <header class="header-logo">
            <svg width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#1e3a8a" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h9z"></path></svg>
            <div>
                도서 관리 시스템
                <span>Library Management System</span>
            </div>
        </header>

        <!-- 재검색 가능-->
        <section class="hero-section">
            <h1>검색 결과 확인하기</h1>
            <form action="search_result.php" method="GET" class="search-container">
                <input type="text" name="keyword" placeholder="도서명 또는 저자를 입력하세요" value="<?php echo htmlspecialchars($keyword); ?>" required>
                <div class="search-icon" onclick="this.parentElement.submit();">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
            </form>
        </section>

        <!-- 결과 목록 -->
        <section class="content-section">
            <div class="section-title">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1e3a8a" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                검색 결과 <span>'<span class="highlight"><?php echo htmlspecialchars($keyword); ?></span>' 키워드로 총 <?php echo $total_rows; ?>권이 검색되었습니다.</span>
            </div>

            <div class="book-grid">
                <?php if($total_rows > 0): ?>
                    <?php while($book = mysqli_fetch_assoc($result)): ?>
                    <div class="book-card" onclick="location.href='book_detail.php?id=<?php echo $book['book_id']; ?>'">
                        <div class="book-img-box">
                            <?php if(!empty($book['img_path'])): ?>
                                <img src="<?php echo $book['img_path']; ?>" alt="표지">
                            <?php else: ?>
                                <div class="no-img">
                                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="1"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h9z"></path></svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="book-title"><?php echo htmlspecialchars($book['title']); ?></div>
                        <div class="book-author"><?php echo htmlspecialchars($book['author']); ?></div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-result">
                        <p>검색 결과가 없습니다. 다른 검색어를 입력해 보세요.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

</body>
</html>