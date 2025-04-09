<?php 
include 'app/views/shares/header.php';

// Kiểm tra nếu chưa đăng nhập hoặc không phải admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Bạn không có quyền truy cập!</div></div>";
    include 'app/views/shares/footer.php';
    exit;
}
?>

<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Thêm sản phẩm mới</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="/webbanhang/Product/save" enctype="multipart/form-data" onsubmit="return validateForm();">
                
                <div class="form-group">
                    <label for="name" class="font-weight-bold">Tên sản phẩm:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="description" class="font-weight-bold">Mô tả:</label>
                    <textarea id="description" name="description" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                    <label for="price" class="font-weight-bold">Giá:</label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="category_id" class="font-weight-bold">Danh mục:</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>">
                                <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image" class="font-weight-bold">Hình ảnh:</label>
                    <div class="custom-file">
                        <input type="file" id="image" name="image" class="custom-file-input" onchange="updateFileName()" required>
                        <label class="custom-file-label" for="image">Chọn tệp...</label>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4">Thêm sản phẩm</button>
                    <a href="/webbanhang/Product/list" class="btn btn-secondary px-4 ml-2">Quay lại danh sách sản phẩm</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateFileName() {
        var input = document.getElementById('image');
        var label = input.nextElementSibling; 
        var fileName = input.files.length > 0 ? input.files[0].name : "Chọn tệp...";
        label.textContent = fileName;
    }
</script>

<?php include 'app/views/shares/footer.php'; ?>
