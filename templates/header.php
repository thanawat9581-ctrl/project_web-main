<?php
// เช็คสถานะ Login และ URI สำหรับ Active Class
$isLoggedIn = isset($_SESSION['user_id']);
$current_uri = $_SERVER['REQUEST_URI'];
?>

<nav class="main-navbar">
    <div class="nav-container">
        <a href="/home" class="nav-logo">
            <div class="logo-wrapper">
                <span class="logo-icon">🚀</span>
                <span class="logo-text">EVENT<span class="highlight">SYSTEM</span></span>
            </div>
        </a>
        <label for="menu-toggle" class="hamburger-label">
            <span></span>
            <span></span>
            <span></span>
        </label>

        <div class="nav-links">
            <a href="/home" class="<?= (strpos($current_uri, 'home') !== false) ? 'active' : '' ?>">ค้นหากิจกรรม</a>
            
            <?php if ($isLoggedIn): ?>
                <a href="/create_event" class="<?= (strpos($current_uri, 'create_event') !== false) ? 'active' : '' ?>">สร้างกิจกรรม</a>
                <a href="/join_event" class="<?= (strpos($current_uri, 'join_event') !== false) ? 'active' : '' ?>">รายการที่สมัคร</a>
                <a href="/event_list" class="<?= (strpos($current_uri, 'event_list') !== false) ? 'active' : '' ?>">กิจกรรมของฉัน</a>
                
            <?php else: ?>
                <a href="/login" class="mobile-only login-link">เข้าสู่ระบบ</a>
            <?php endif; ?>
        </div>

        <div class="nav-auth desktop-only">
            <?php if ($isLoggedIn): ?>
                <div class="user-profile">
                    <div class="user-info">
                        <span class="welcome-text">ยินดีต้อนรับ,</span>
                        <span class="user-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'ผู้ใช้งาน') ?></span>
                    </div>
                    <a class="mobile-only logout-link"href="/logout">ออกจากระบบ</a>
                </div>
            <?php else: ?>
                <a href="/login" class="btn-login-nav">เข้าสู่ระบบ</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<style>
    :root {
        --primary: #4e73df;
        --primary-dark: #2e59d9;
        --text-main: #2c3e50;
        --text-light: #858796;
        --white: #ffffff;
        --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --glass: rgba(255, 255, 255, 0.95);
    }

    /* Navbar Container */
    .main-navbar {
    background: var(--glass);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-bottom: 1px solid rgba(227, 230, 240, 0.6);
    position: sticky;
    top: 0;
    z-index: 1000;
    height: 80px;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;

    /* --- สิ่งที่ต้องเพิ่ม --- */
    width: 100%;       /* มั่นใจว่ากว้างเต็มจอ */
    overflow: visible; /* สำคัญมาก! เพื่อให้เมนูที่ drop down ลงมาไม่โดนตัดขาด */
}

    .nav-container {
        max-width: 1200px;
        width: 100%;
        margin: 0 auto;
        padding: 0 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Logo Styling */
    .nav-logo {
        text-decoration: none;
        transition: transform 0.3s ease;
    }
    .nav-logo:hover { transform: scale(1.05); }
    
    .logo-wrapper { display: flex; align-items: center; gap: 10px; }
    .logo-icon { font-size: 26px; }
    .logo-text {
        font-size: 20px;
        font-weight: 800;
        color: var(--text-main);
        letter-spacing: -0.5px;
    }
    .logo-text .highlight { color: var(--primary); }

    /* Nav Links & Animations */
    .nav-links { display: flex; gap: 8px; }
    .nav-links a {
        text-decoration: none;
        color: var(--text-main);
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 500;
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .nav-links a:hover {
        background: rgba(78, 115, 223, 0.08);
        color: var(--primary);
    }

    .nav-links a.active {
        background: var(--primary);
        color: var(--white);
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
    }

    /* Auth Section */
    .nav-auth { display: flex; align-items: center; }

    .user-profile { display: flex; align-items: center; gap: 20px; }
    .user-info { display: flex; flex-direction: column; text-align: right; }
    .welcome-text { font-size: 11px; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; }
    .user-name { font-size: 14px; font-weight: 600; color: var(--text-main); }

    /* Buttons */
    .btn-login {
        background: transparent;
        color: var(--primary);
        border: 2px solid var(--primary);
    }
    .btn-login:hover {
        background: var(--primary);
        color: var(--white);
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.2);
    }

    .btn-logout {
        background: rgba(231, 74, 59, 0.1);
        color: #e74a3b;
        border: 1px solid rgba(231, 74, 59, 0.2);
    }
    .btn-logout:hover {
        background: #e74a3b;
        color: var(--white);
        box-shadow: 0 5px 15px rgba(231, 74, 59, 0.2);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .nav-links { display: none; } /* แนะนำให้ทำ Hamburger Menu เพิ่มเติมสำหรับ Mobile */
        .user-info { display: none; }
    }
</style>