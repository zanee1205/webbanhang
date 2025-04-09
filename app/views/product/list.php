<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-4">
    <h1 class="text-center mb-4">Tìm kiếm sản phẩm</h1>

    <!-- Thanh tìm kiếm -->
    <form method="GET" action="/webbanhang/Product/search" class="d-flex mb-4">
        <input type="text" name="keyword" class="form-control me-2" placeholder="Nhập tên sản phẩm..." required>
        <button type="submit" class="btn btn-primary">🔍 Tìm kiếm</button>
    </form>

    <div class="d-flex justify-content-between mb-3">
        <a href="/webbanhang/Product/add" class="btn btn-success">➕ Thêm sản phẩm mới</a>
        <a href="/webbanhang/cart" class="btn btn-warning">🛒 Giỏ hàng</a>
    </div>

    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card shadow-sm h-100">
                    <?php if ($product->image): ?>
                        <img src="/webbanhang/<?php echo $product->image; ?>" alt="Product Image" class="card-img-top img-fluid" style="height: 220px; object-fit: contain;">
                    <?php endif; ?>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-center">
                            <a href="/webbanhang/Product/show/<?php echo $product->id; ?>" class="text-decoration-none">
                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </h5>
                        <p class="card-text text-muted text-truncate" style="max-height: 50px; overflow: hidden;">
                            <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                        <p class="fw-bold text-center">💰 <?php echo number_format($product->price, 0, ',', '.'); ?> VND</p>
                        <p class="text-primary text-center">📂 <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                    
                    <div class="card-footer d-flex justify-content-between">
                        <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-sm btn-warning">✏️ Sửa</a>
                        <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">❌ Xóa</a>
                        <a href="/webbanhang/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-sm btn-primary">🛒 Giỏ</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>
