<?php include 'app/views/shares/header.php'; ?>

<style>
    body {
        background: linear-gradient(135deg, #f9f1e7, #fffaeb);
    }

    .register-container {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }

    .form-control {
        border-radius: 8px;
    }

    .btn-primary {
        background: #007bff;
        border-radius: 8px;
    }
</style>

<section class="vh-100 d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="register-container">
                    <h2 class="text-center text-uppercase fw-bold mb-3">Đăng ký tài khoản</h2>
                    <p class="text-center text-muted">Tạo tài khoản để tiếp tục mua sắm</p>

                    <form action="/webbanhang/account/save" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" name="username" class="form-control" id="username" placeholder="Tài khoản" required>
                                    <label for="username">Tài khoản</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" name="fullname" class="form-control" id="fullname" placeholder="Họ và tên" required>
                                    <label for="fullname">Họ và tên</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Mật khẩu" required>
                                    <label for="password">Mật khẩu</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="password" name="confirmpassword" class="form-control" id="confirmpassword" placeholder="Xác nhận mật khẩu" required>
                                    <label for="confirmpassword">Xác nhận mật khẩu</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Chọn vai trò</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="user">Người dùng</option>
                                <option value="admin">Quản trị viên</option>
                            </select>
                        </div>

                        <button class="btn btn-primary w-100 py-2 mt-2" type="submit">Đăng ký</button>

                        <p class="text-center mt-3 mb-0">Đã có tài khoản?
                            <a href="/webbanhang/account/login" class="text-primary fw-bold">Đăng nhập ngay</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'app/views/shares/footer.php'; ?>
