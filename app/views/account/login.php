<?php 
include 'app/views/shares/header.php'; 
require_once 'app/config/database.php';

// Khởi tạo kết nối
$database = new Database();
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Vui lòng nhập đầy đủ thông tin!";
    } else {
        // Sử dụng PDO Prepared Statement để tránh SQL Injection
        $stmt = $conn->prepare("SELECT * FROM account WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['password'])) {
            // Gán thông tin vào SESSION
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role']; // Gán quyền từ database

            // Điều hướng người dùng sau khi đăng nhập
            if ($_SESSION['role'] === 'admin') {
                header("Location: /webbanhang/product/list");
            } else {
                header("Location: /webbanhang/Product/list");
            }
            exit();
        } else {
            $error = "Sai tên đăng nhập hoặc mật khẩu!";
        }
    }
}
?>

<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <form action="" method="post">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">Please enter your login and password!</p>

                                <?php if (!empty($error)) { ?>
                                    <div class="alert alert-danger"><?= $error ?></div>
                                <?php } ?>

                                <div class="form-outline form-white mb-4">
                                    <input type="text" name="username" class="form-control form-control-lg" required />
                                    <label class="form-label">UserName</label>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="password" name="password" class="form-control form-control-lg" required />
                                    <label class="form-label">Password</label>
                                </div>

                                <p class="small mb-5 pb-lg-2">
                                    <a class="text-white-50" href="#!">Forgot password?</a>
                                </p>

                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>

                                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                    <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                                </div>
                            </div>

                            <div>
                                <p class="mb-0">
                                    Don't have an account? 
                                    <a href="/webbanhang/account/register" class="text-white-50 fw-bold">Sign Up</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'app/views/shares/footer.php'; ?>
