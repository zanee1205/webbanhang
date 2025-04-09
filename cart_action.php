<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['action'])) {
    $productId = $_POST['id'];
    $action = $_POST['action'];

    if (isset($_SESSION['cart'][$productId])) {
        if ($action === 'increase') {
            $_SESSION['cart'][$productId]['quantity']++;
        } elseif ($action === 'decrease') {
            $_SESSION['cart'][$productId]['quantity']--;
            if ($_SESSION['cart'][$productId]['quantity'] <= 0) {
                unset($_SESSION['cart'][$productId]);
                $response['quantity'] = 0;
            }
        }

        if (isset($_SESSION['cart'][$productId])) {
            $response['quantity'] = $_SESSION['cart'][$productId]['quantity'];
        }
        
        $response['success'] = true;
    }
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_POST['action'] ?? '';
$id = $_POST['id'] ?? '';
$quantity = $_POST['quantity'] ?? 1;

if ($action === 'update' && isset($_SESSION['cart'][$id])) {
    $quantity = max(1, intval($quantity)); // Đảm bảo số lượng tối thiểu là 1
    $_SESSION['cart'][$id]['quantity'] = $quantity;
    
    echo json_encode(['success' => true, 'quantity' => $quantity]);
    exit;
}

echo json_encode($response);

if ($_POST['action'] === 'remove' && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Xóa sản phẩm khỏi session giỏ hàng
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }

    // Trả về JSON để cập nhật giao diện
    echo json_encode(["success" => true]);
    exit;
}

exit;
