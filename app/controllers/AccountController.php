<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
require_once('app/helpers/SessionHelper.php');

class AccountController {
    private $accountModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    public function register() {
        include_once 'app/views/account/register.php';
    }

    public function login() {
        include_once 'app/views/account/login.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $fullName = trim($_POST['fullname'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $confirmPassword = trim($_POST['confirmpassword'] ?? '');
            $errors = [];

            // Kiểm tra đầu vào
            if (empty($username)) $errors['username'] = "Vui lòng nhập Username!";
            if (empty($fullName)) $errors['fullname'] = "Vui lòng nhập Họ và Tên!";
            if (empty($password)) $errors['password'] = "Vui lòng nhập mật khẩu!";
            if ($password !== $confirmPassword) {
                $errors['confirmPass'] = "Mật khẩu xác nhận không khớp!";
            }

            // Kiểm tra username đã tồn tại chưa
            if ($this->accountModel->getAccountByUsername($username)) {
                $errors['account'] = "Tài khoản đã tồn tại!";
            }

            if (!empty($errors)) {
                include_once 'app/views/account/register.php';
                return;
            }

            // Mã hóa mật khẩu an toàn
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Lưu vào DB
            if ($this->accountModel->save($username, $fullName, $hashedPassword, $role)) {

                header('Location: /webbanhang/account/login');
                exit;
            } else {
                die("Lỗi hệ thống khi tạo tài khoản!");
            }
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /webbanhang/product');
        exit;
    }

    public function checkLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $account = $this->accountModel->getAccountByUsername($username);
            if ($account && password_verify($password, $account->password)) {
                session_start();
                $_SESSION['username'] = $account->username;
                header('Location: /webbanhang/product');
                exit;
            } else {
                $error = "Sai tên đăng nhập hoặc mật khẩu!";
                include_once 'app/views/account/login.php';
            }
        }
    }
}