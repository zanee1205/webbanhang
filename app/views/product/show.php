<?php include 'app/views/shares/header.php'; ?>


<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h2>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Cột hiển thị hình ảnh -->
                <div class="col-md-5 text-center">
                    <?php if (!empty($product->image)): ?>
                        <img src="/webbanhang/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" 
                             alt="Ảnh sản phẩm" class="img-fluid rounded shadow-sm" 
                             style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <img src="/images/no-image.png" alt="Không có ảnh" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-width: 100%; height: auto;">
                    <?php endif; ?>
                </div>

                <!-- Cột hiển thị thông tin sản phẩm -->
                <div class="col-md-7">
                    <h4 class="font-weight-bold">Thông tin sản phẩm</h4>
                    <p><strong>Mô tả:</strong> 
                        <?php echo nl2br(htmlspecialchars($product->description ?? 'Không có mô tả', ENT_QUOTES, 'UTF-8')); ?>
                    </p>
                    <p><strong>Giá:</strong> 
                        <span class="text-danger font-weight-bold">
                            <?php echo number_format($product->price ?? 0, 0, ',', '.'); ?> VNĐ
                        </span>
                    </p>
                    <p><strong>Danh mục:</strong> 
                            <span class="badge bg-info text-white">
                                <?php echo !empty($product->category_name) ? htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') : 'Chưa có danh mục'; ?>
                            </span>
                        </p>

                    <div class="mt-4">
                        <a href="/webbanhang/Product/list" class="btn btn-secondary px-4">← Quay lại danh sách</a>
                        <a href="/webbanhang/Product/edit?id=<?php echo $product->id; ?>" 
                           class="btn btn-warning px-4">✏️ Chỉnh sửa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
