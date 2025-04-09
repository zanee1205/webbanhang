<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Thêm Danh Mục</h2>

    <?php if (isset($error)): ?>
        <p class="text-danger"><?= $error ?></p>
    <?php endif; ?>

    <form action="/webbanhang/category/add" method="post">
        <div class="form-group">
            <label for="name">Tên danh mục:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="description">Mô tả danh mục:</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Thêm</button>
    </form>
</div>

<?php include 'app/views/shares/footer.php'; ?>
