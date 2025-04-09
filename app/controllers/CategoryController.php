<?php
// Require các file cần thiết
require_once 'app/config/database.php';
require_once 'app/models/CategoryModel.php';

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        // Kết nối database
        $db = (new Database())->getConnection();
        
        if ($db) {
            $this->categoryModel = new CategoryModel($db);
        } else {
            die("Lỗi kết nối cơ sở dữ liệu.");
        }
    }

    // Hiển thị danh sách danh mục
    public function list()
    {
        $categories = $this->categoryModel->getAllCategories() ?? [];
        include 'app/views/category/list.php';
    }

    // Thêm danh mục
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            if (!empty($name)) {
                if ($this->categoryModel->addCategory($name)) {
                    header('Location: /webbanhang/category/list');
                    exit;
                } else {
                    $error = "Lỗi khi thêm danh mục!";
                }
            } else {
                $error = "Tên danh mục không được để trống!";
            }
        }
        include 'app/views/category/add.php';
    }

    // Chỉnh sửa danh mục
    public function edit($id = null)
{
    if (!$id) {
        die("Thiếu ID danh mục.");
    }

    $category = $this->categoryModel->getCategoryById($id);
    if (!$category) {
        die("Danh mục không tồn tại.");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);

        if (!empty($name) && !empty($description)) {
            if ($this->categoryModel->updateCategory($id, $name, $description)) {
                header("Location: /webbanhang/category/list");
                exit();
            } else {
                $error = "Cập nhật thất bại!";
            }
        } else {
            $error = "Tên và mô tả không được để trống!";
        }
    }
    include 'app/views/category/edit.php';
}


    // Xóa danh mục
    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->categoryModel->deleteCategory($id)) {
                header("Location: /webbanhang/category/list");
                exit();
            } else {
                die("Xóa danh mục thất bại!");
            }
        }
    }
}
