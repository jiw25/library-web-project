<?php
include "db_conn.php";

// 로그인 세션 체크
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 랜덤 도서 3권 가져오기 (추천 도서)
$random_sql = "SELECT * FROM books ORDER BY RAND() LIMIT 3";
$random_result = mysqli_query($conn, $random_sql);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>홈 - 도서 관리 시스템</title>
    <!-- 공통 스타일 시트 연결 -->
    <link rel="stylesheet" href="style1.css">
</head>
<body>

<div class="layout-wrapper">
    
    
    <nav class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="index.php" class="active">
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

    <!-- 메인 영역 (오른쪽 스크롤 영역) -->
    <div class="main-content">
        <!-- 상단 헤더  -->
        <header class="header-logo">
            <svg width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#1e3a8a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h9z"></path></svg>
            <div>
                도서 관리 시스템
                <span>Library Management System</span>
            </div>
        </header>

        <!-- 배너 -->
        <section class="hero-section">
            <h1>도서관에 오신 것을 환영합니다.</h1>
            <p>원하는 도서를 검색하고 간편하게 대출하세요</p>
            
            <!-- 검색바 -->
            <form action="search_result.php" method="GET" class="search-container">
                <input type="text" name="keyword" placeholder="도서명 또는 저자를 입력하세요" required>
                <div class="search-icon" onclick="this.parentElement.submit();">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                </div>
            </form>
        </section>

        <!-- 추천 도서  -->
        <section class="content-section">
            <div class="section-title">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f87171" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                추천 도서 
            </div>

            <div class="book-grid">
                <?php while($book = mysqli_fetch_assoc($random_result)): ?>
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

                <?php if(mysqli_num_rows($random_result) == 0): ?>
                    <p style="color:#999; grid-column: span 3; text-align: center; padding: 50px;">현재 등록된 도서가 없습니다.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div> 

</body>
</html>