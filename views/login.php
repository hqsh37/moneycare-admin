<?php

// Kiểm tra nếu admin đã đăng nhập
if (isset($_SESSION['admin'])) {
    echo '<script>
    alert("Bạn đã đăng nhập rồi!");
    window.location.href = "' . PROJECT_NAME . '/home";
    </script>';
    exit();
}

// Xử lý đăng nhập
$errorMessage = ''; // Biến lưu thông báo lỗi
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Kiểm tra CSRF token
    if (!isset($_POST['_token']) || $_POST['_token'] !== $_SESSION['_token']) {
        $errorMessage = "Yêu cầu không hợp lệ.";
    } else {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $data = [
            "email" => $email
        ];

        $user = Admin::find($data);

        if ($user) {
            if (password_verify(trim($password), $user->password)) {
                $_SESSION["admin"] = $user;
                header("Location: " . PROJECT_NAME . "/home");
                exit();
            } else {
                $errorMessage = "Sai mật khẩu.";
            }
        } else {
            $errorMessage = "Tài khoản không tồn tại.";
        }
    }
}

// Tạo CSRF token mới
$_SESSION['_token'] = bin2hex(random_bytes(32));
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/logo/logo-icon-only.png" type="image/x-icon" />
    <title>Đăng nhập | Moneycare</title>

    <!-- ========== Tất cả các file CSS ========= -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/lineicons.css" />
    <link rel="stylesheet" href="assets/css/main.css" />

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        .main-wrapper {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-row {
            height: 100%;
        }

        .auth-cover-wrapper {
            height: 100%;
        }
    </style>
</head>

<body>
    <div class="container-fluid h-100">
        <div class="row g-0 h-100 auth-row">
            <div class="col-lg-6 d-none d-lg-flex">
                <div class="auth-cover-wrapper bg-primary-100 d-flex align-items-center justify-content-center">
                    <div class="auth-cover text-center">
                        <h1 class="text-primary mb-10">Chào mừng trở lại</h1>
                        <p class="text-medium">
                            Đăng nhập vào tài khoản của bạn để tiếp tục
                        </p>
                        <div class="cover-image">
                            <img src="assets/images/auth/signin-image.svg" alt="Minh họa đăng nhập" class="img-fluid">
                        </div>
                        <div class="shape-image">
                            <img src="assets/images/auth/shape.svg" alt="Hình trang trí" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <div class="signin-wrapper w-100 px-4" style="max-width: 400px;">
                    <div class="form-wrapper">
                        <h6 class="mb-15">Đăng nhập</h6>
                        <?php if (!empty($errorMessage)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?= htmlspecialchars($errorMessage) ?>
                            </div>
                        <?php endif; ?>
                        <form action="" method="POST">
                            <input type="hidden" name="_token" value="<?= $_SESSION['_token'] ?>" />
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required />
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <a href="reset-password" class="text-decoration-none">Quên mật khẩu?</a>
                            </div>
                            <button class="btn btn-primary w-100 mb-3">Đăng nhập</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
    </div>

    <!-- ========= Tất cả các file Javascript ========= -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>