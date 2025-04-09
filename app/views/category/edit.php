<?php include 'app/views/shares/header.php'; 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra nếu người dùng chưa đăng nhập hoặc không có quyền admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Bạn không có quyền truy cập!</div></div>";
    include 'app/views/shares/footer.php';
    exit;
}?>

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">✏️ Chỉnh Sửa Danh Mục</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <form action="/webbanhang/category/update/<?= $category['id'] ?>" method="post">
                <div class="form-group">
                    <label for="name" class="font-weight-bold">📌 Tên danh mục:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="description" class="font-weight-bold">📝 Mô tả danh mục:</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($category['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4">✅ Cập Nhật</button>
                    <a href="/webbanhang/category/list" class="btn btn-secondary px-4 ml-2">🔙 Quay Lại</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
