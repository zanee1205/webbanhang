<?php
require_once('app/config/database.php');
require_once __DIR__ . '/../models/ProductModel.php';
require_once('app/models/CategoryModel.php');

class ProductController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function list()
    {
        $this->index();
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không tìm thấy sản phẩm.";
        }
    }

    public function add()
    {
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = htmlspecialchars(trim($_POST['name'] ?? ''));
            $description = htmlspecialchars(trim($_POST['description'] ?? ''));
            $price = floatval($_POST['price'] ?? 0);
            $category_id = intval($_POST['category_id'] ?? 0);

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                try {
                    $image = $this->uploadImage($_FILES['image']);
                } catch (Exception $e) {
                    echo "Lỗi upload ảnh: " . $e->getMessage();
                    return;
                }
            } else {
                $image = "";
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /webbanhang/Product');
                exit;
            }
        }
    }

    public function delete($id)
    {
        if ($this->productModel->getProductById($id)) {
            if ($this->productModel->deleteProduct($id)) {
                header('Location: /webbanhang/Product');
                exit;
            } else {
                echo "Đã xảy ra lỗi khi xóa sản phẩm.";
            }
        } else {
            echo "Sản phẩm không tồn tại.";
        }
    }

    public function edit($id)
{
    $product = $this->productModel->getProductById($id);

    if (!$product) {
        echo "Sản phẩm không tồn tại.";
        return;
    }

    $categories = (new CategoryModel($this->db))->getCategories(); // Lấy danh mục cho dropdown

    require_once __DIR__ . '/../views/product/edit.php';
}


    private function uploadImage($file)
    {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra định dạng file
        $allowedTypes = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowedTypes)) {
            throw new Exception("Chỉ chấp nhận JPG, JPEG, PNG, GIF.");
        }

        // Kiểm tra dung lượng file (tối đa 10MB)
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Kích thước file quá lớn.");
        }

        // Kiểm tra file có phải ảnh không
        if (!getimagesize($file["tmp_name"])) {
            throw new Exception("File không hợp lệ.");
        }

        // Di chuyển file
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Lỗi khi tải ảnh.");
        }

        return $target_file;
    }

    public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }

        header('Location: /webbanhang/Product/cart');
        exit;
    }

    public function cart()
    {
        $cart = $_SESSION['cart'] ?? [];
        include 'app/views/product/cart.php';
    }

    public function search()
    {
        $keyword = trim($_GET['keyword'] ?? '');

        if (empty($keyword)) {
            header("Location: /webbanhang/Product/list");
            exit();
        }

        $products = $this->productModel->searchProducts($keyword);
        include 'app/views/product/list.php';
    }

    public function increase($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        }
        header('Location: /webbanhang/Product/cart');
        exit;
    }

    public function checkout() {
        include 'app/views/product/checkout.php'; // Hoặc xử lý logic thanh toán
    }

    public function processcheckout() {
        include 'app/views/product/orderconfirmation.php'; // Hoặc xử lý logic thanh toán
    }

    public function decrease($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            if ($_SESSION['cart'][$id]['quantity'] > 1) {
                $_SESSION['cart'][$id]['quantity']--;
            } else {
                unset($_SESSION['cart'][$id]);
            }
        }
        header('Location: /webbanhang/Product/cart');
        exit;
    }
}
?>
