<?php 
include 'app/views/shares/header.php';

// Kiểm tra nếu chưa đăng nhập hoặc không phải admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Bạn không có quyền truy cập!</div></div>";
    include 'app/views/shares/footer.php';
    exit;
}
?>
<div class="container mt-4">
    <h1 class="text-center mb-4">🛒 Giỏ hàng của bạn</h1>

    <?php if (!empty($cart)): ?>
        <div class="row">
            <div class="col-md-8">
                <ul class="list-group">
                    <?php $total = 0; ?>
                    <?php foreach ($cart as $id => $item): ?>
                        <?php $subtotal = $item['price'] * $item['quantity']; ?>
                        <?php $total += $subtotal; ?>

                        <li class="list-group-item d-flex align-items-center">
                            <?php if ($item['image']): ?>
                                <img src="/webbanhang/<?php echo $item['image']; ?>" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                            <?php endif; ?>

                            <div class="flex-grow-1">
                                <h5><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h5>
                                <p>📦 Số lượng: 
                                    <button onclick="updateCart('<?php echo $id; ?>', 'decrease', <?php echo $item['price']; ?>)" class="btn btn-sm btn-light">➖</button>
                                    
                                    <input type="number" id="quantity-<?php echo $id; ?>" 
                                        value="<?php echo $item['quantity']; ?>" 
                                        min="1" 
                                        class="form-control d-inline-block text-center" 
                                        style="width: 100px;" 
                                        onchange="updateCartQuantity('<?php echo $id; ?>', this.value, <?php echo $item['price']; ?>)">
                                    
                                    <button onclick="updateCart('<?php echo $id; ?>', 'increase', <?php echo $item['price']; ?>)" class="btn btn-sm btn-light">➕</button>
                                </p>
                            </div>

                            <div>
                                <p class="fw-bold">🧾 Tổng: <span id="total-<?php echo $id; ?>"><?php echo number_format($subtotal, 0, ',', '.'); ?></span> VND</p>
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm" 
                                    onclick="removeFromCart('<?php echo $id; ?>')">
                                    ❌ Xóa
                                </a>

                                </a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                <h4 class="fw-bold">💵 Tổng tiền: <span id="grand-total"><?php echo number_format($total, 0, ',', '.'); ?></span> VND</h4>
                    <a href="/webbanhang/Product" class="btn btn-secondary mt-2 w-100">🔄 Tiếp tục mua sắm</a>
                    <a href="/webbanhang/Product/Checkout" class="btn btn-primary mt-2 w-100">💳 Thanh Toán</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p class="text-center fw-bold text-muted fs-4">🛍️ Giỏ hàng của bạn đang trống.</p>
        <div class="text-center">
            <a href="/webbanhang/Product" class="btn btn-success">🛒 Tiếp tục mua sắm</a>
        </div>
    <?php endif; ?>
</div>
<?php include 'app/views/shares/footer.php'; ?>

<script>
function updateCart(productId, action, price) {
    fetch('/webbanhang/cart_action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=${action}&id=${productId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cập nhật số lượng
            document.getElementById(`quantity-${productId}`).innerText = data.quantity;

            // Cập nhật tổng tiền của sản phẩm
            document.getElementById(`total-${productId}`).innerText = (data.quantity * price).toLocaleString();

            // Cập nhật tổng tiền giỏ hàng
            updateTotalPrice();
        } else {
            alert('Cập nhật thất bại!');
        }
    })
    .catch(error => console.error('Error:', error));
}

// Cập nhật tổng tiền giỏ hàng
function updateTotalPrice() {
    let total = 0;
    document.querySelectorAll('[id^="total-"]').forEach(el => {
        total += parseInt(el.innerText.replace(/,/g, '')); // Loại bỏ dấu phẩy trước khi cộng
    });
    document.getElementById('grand-total').innerText = total.toLocaleString();
}

function removeFromCart(productId) {
    fetch('/webbanhang/cart_action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=remove&id=${productId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Xóa phần tử sản phẩm khỏi giao diện
            document.getElementById(`cart-item-${productId}`).remove();

            // Cập nhật tổng tiền giỏ hàng
            updateTotalPrice();
        } else {
            alert('Xóa sản phẩm thất bại!');
        }
    })
    .catch(error => console.error('Lỗi:', error));
}
function updateCartQuantity(productId, newQuantity, price) {
    newQuantity = parseInt(newQuantity);
    if (isNaN(newQuantity) || newQuantity < 1) {
        alert("Số lượng không hợp lệ!");
        return;
    }

    fetch('/webbanhang/cart_action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=update&id=${productId}&quantity=${newQuantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cập nhật tổng tiền của sản phẩm
            document.getElementById(`total-${productId}`).innerText = (newQuantity * price).toLocaleString();

            // Cập nhật tổng tiền giỏ hàng
            updateTotalPrice();
        } else {
            alert('Cập nhật số lượng thất bại!');
        }
    })
    .catch(error => console.error('Lỗi:', error));
}

</script>