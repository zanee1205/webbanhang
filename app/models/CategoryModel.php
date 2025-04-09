<?php
class CategoryModel
{
    private $conn;
    private $table_name = "category"; // Thêm dòng này
    
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả danh mục (đổi tên để phù hợp với ProductController)
    public function getCategories()
    {
        return $this->getAllCategories();
    }

    
    // Lấy tất cả danh mục
    public function getAllCategories()
    {
        $stmt = $this->conn->prepare("SELECT * FROM category ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Lấy danh mục theo ID
    public function getCategoryById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM category WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Thêm danh mục mới
    public function addCategory($name) {
        $query = "INSERT INTO " . $this->table_name . " (name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Cập nhật danh mục
    public function updateCategory($id, $name, $description)
    {
        $stmt = $this->conn->prepare("UPDATE category SET name = :name, description = :description WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        return $stmt->execute();
    }

    // Xóa danh mục
    public function deleteCategory($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM category WHERE id = :id");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>