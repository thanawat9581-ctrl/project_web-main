<?php
// เช็คสถานะ Login และ URI สำหรับ Active Class
$isLoggedIn = isset($_SESSION['user_id']);
$isLoggedInName = isset($_SESSION['username']);
$current_uri = $_SERVER['REQUEST_URI'];
?>
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --primary: #4e73df;
        --dark: #2c3e50;
        --gray-text: #858796;
        --light-bg: #f8f9fc;
        --danger: #e74a3b;
    }

    .navbar {
        background: #ffffff;
        border-bottom: 1px solid #e3e6f0;
        height: 75px;
        display: flex;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 1000;
        font-family: 'Prompt', sans-serif;
    }

    .nav-container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo {
        font-size: 20px;
        font-weight: 700;
        text-decoration: none;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .logo span {
        color: var(--primary);
    }

    .nav-menu {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        align-items: center;
        gap: 4px;
    }

    .nav-menu li a {
        text-decoration: none;
        color: var(--dark);
        padding: 6px 12px;
        font-size: 14px;
        font-weight: 400;
        border-radius: 0px;
    }

    .nav-menu li a:hover {
    background-color: #ffffff; 
    color: var(--primary);     
}

    .nav-menu li a.active {
        color: var(--primary);
        font-weight: 600;
    }

    .user-item-wrapper {
        margin-left: 10px;
        padding-left: 20px;
        border-left: 2px solid #ffffff;
    }

    .user-control {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-greeting {
        font-size: 13.5px;
        color: var(--gray-text);
    }

    .user-name-bold {
        color: var(--dark);
        font-weight: 600;
    }

    .btn-logout-minimal {
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        color: var(--danger);
        padding: 10px 14px;
        background: #fff5f5;
        border-radius: 10px;
        transition: 0.3s;
    }

    .btn-logout-minimal:hover {
        background: var(--danger);
        color: #ffffff;
        border-color: var(--danger);
    }

    .btn-login-main {
        background: var(--primary) !important;
        color: #fff !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 10px rgba(78, 115, 223, 0.2);
    }

    .nav-toggle {
        display: none;
    }

    .nav-toggle-label {
        display: none;
        cursor: pointer;
    }

    .nav-toggle-label span {
        width: 22px;
        height: 2px;
        background: var(--dark);
        display: block;
        margin: 5px 0;
        border-radius: 2px;
    }

    @media (max-width: 992px) {
        .nav-toggle-label {
            display: block;
        }

        .nav-menu {
            position: absolute;
            top: 75px;
            left: 0;
            width: 100%;
            background: #fff;
            flex-direction: column;
            padding: 15px 0;
            border-top: 1px solid #eee;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            display: none;
        }

        .nav-menu li {
            width: 100%;
        }

        .nav-menu li a {
            padding: 18px 25px;
            border-radius: 0;
        }

        .user-item-wrapper {
            margin: 10px 0 0 0;
            padding: 20px 25px;
            border-left: none;
            border-top: 1px solid #f1f3f9;
            width: 100%;
            box-sizing: border-box;
        }

        .user-control {
            justify-content: space-between;
            width: 100%;
        }

        .nav-toggle:checked~.nav-menu {
            display: flex;
        }
    }
</style>
<nav class="navbar">
    <div class="nav-container">
        <a href="/home" class="logo">
            🚀 EVENT<span>SYSTEM</span>
        </a>
        <input type="checkbox" id="nav-toggle" class="nav-toggle">
        <label for="nav-toggle" class="nav-toggle-label">
            <span></span>
            <span></span>
            <span></span>
        </label>
        <ul class="nav-menu">
            <li><a href="/home" class="<?= (strpos($current_uri, 'home') !== false) ? 'active' : '' ?>">ค้นหากิจกรรม</a></li>
            <?php if ($isLoggedIn): ?>
                <li><a href="/create_event" class="<?= (strpos($current_uri, 'create_event') !== false) ? 'active' : '' ?>">สร้างกิจกรรม</a></li>
                <li><a href="/join_event" class="<?= (strpos($current_uri, 'join_event') !== false) ? 'active' : '' ?>">รายการที่สมัคร</a></li>
                <li><a href="/event_list" class="<?= (strpos($current_uri, 'event_list') !== false) ? 'active' : '' ?>">กิจกรรมของฉัน</a></li>
                <li class="user-item-wrapper">
                    <div class="user-control">
                        <span class="user-greeting">สวัสดี, <span class="user-name-bold"><?= htmlspecialchars($isLoggedInName = $data['username'] ?? 'ผู้ใช้งาน') ?></span></span>
                        <a href="/logout" class="btn-logout-minimal">ออกจากระบบ</a>
                    </div>
                </li>
            <?php else: ?>
                <li><a href="/login" class="btn-login-main">เข้าสู่ระบบ</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
