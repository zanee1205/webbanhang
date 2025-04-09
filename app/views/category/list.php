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

<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Danh sách danh mục</h2>
        </div>
        <div class="card-body">
            <a href="add" class="btn btn-success mb-3">➕ Thêm danh mục</a>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">#️⃣ ID</th>
                        <th class="text-center">📌 Tên danh mục</th>
                        <th class="text-center">🛠️ Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td class="text-center"><?php echo htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="text-center">
                                <a href="/webbanhang/category/edit/<?php echo $category->id; ?>" class="btn btn-warning btn-sm">✏️ Sửa</a>
                                <a href="/webbanhang/category/delete/<?php echo $category->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa danh mục này?');">❌ Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>