<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #ffffff, #f7e6c7);
        }
        .navbar {
            background-color: #007bff !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .nav-link {
            color: #fff !important;
            font-weight: 500;
            transition: 0.3s;
        }
        .nav-link:hover {
            color: #ffdd57 !important;
        }
        .product-image {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/webbanhang/product/list">Quản lý sản phẩm</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/list">📦 Danh sách sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/add">➕ Thêm sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/Cart">🛒 Giỏ hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/category/list">📂 Danh mục</a>
                </li>
                <li class="nav-item">
                    <?php
                    require_once __DIR__ . '/../../helpers/SessionHelper.php';

                    if (SessionHelper::isLoggedIn()) {
                        echo "<a class='nav-link'>" . $_SESSION['username'] . "</a>";
                    } else {
                        echo "<a class='nav-link' href='/webbanhang/account/login'>🔑 Đăng nhập</a>";
                    }
                    ?>
                </li>
                <li class="nav-item">
                    <?php
                    if (SessionHelper::isLoggedIn()) {
                        echo "<a class='nav-link' href='/webbanhang/account/logout'>🚪 Đăng xuất</a>";
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-3">
    <!-- Hiển thị banner -->
    <div class="text-center mb-4">
        <?php 
            $banner_path = "/webbanhang/uploads/banner.png"; // Đường dẫn mặc định
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $banner_path)) {
                $banner_path = "/images/default-banner.jpg"; // Ảnh thay thế nếu không có banner
            }
        ?>
        <img src="<?php echo htmlspecialchars($banner_path, ENT_QUOTES, 'UTF-8'); ?>" 
             alt="Banner cửa hàng" class="img-fluid rounded shadow" 
             style="max-width: 100%; height: auto;">
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
