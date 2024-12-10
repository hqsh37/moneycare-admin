<?php
function validatePasswordChange($currentPassword, $newPassword, $confirmPassword)
{
    // Kiểm tra mật khẩu mới khác mật khẩu hiện tại
    if ($currentPassword === $newPassword) {
        return "Mật khẩu mới không được trùng với mật khẩu hiện tại.";
    }

    // Kiểm tra mật khẩu mới và xác nhận mật khẩu khớp nhau
    if ($newPassword !== $confirmPassword) {
        return "Mật khẩu mới và xác nhận mật khẩu không khớp.";
    }

    // Kiểm tra tiêu chí bảo mật của mật khẩu mới
    if (strlen($newPassword) < 8) {
        return "Mật khẩu mới phải có ít nhất 8 ký tự.";
    }

    if (!preg_match('/[A-Z]/', $newPassword)) {
        return "Mật khẩu mới phải chứa ít nhất một chữ cái viết hoa.";
    }

    if (!preg_match('/[a-z]/', $newPassword)) {
        return "Mật khẩu mới phải chứa ít nhất một chữ cái viết thường.";
    }

    if (!preg_match('/[0-9]/', $newPassword)) {
        return "Mật khẩu mới phải chứa ít nhất một chữ số.";
    }

    if (!preg_match('/[\W_]/', $newPassword)) {
        return "Mật khẩu mới phải chứa ít nhất một ký tự đặc biệt.";
    }

    // Nếu tất cả điều kiện được đáp ứng
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $email = $_SESSION['admin']->email;

    // Gọi hàm kiểm tra
    $validationResult = validatePasswordChange($currentPassword, $newPassword, $confirmPassword);

    if ($validationResult === true) {
        // Lưu thông báo thành công vào session
        $user = Admin::find(["email" => $email]);

        if (password_verify(trim($currentPassword), $user->password)) {

            Admin::update(["id" => $user->id], ["password" => password_hash($newPassword, PASSWORD_DEFAULT)]);

            $_SESSION['toast_message'] = "Đổi mật khẩu thành công!";
            $_SESSION['toast_type'] = "success"; // Thành công

            echo '<script>
            alert("Đổi mật khẩu thành công!");
            window.location.href = "' . PROJECT_NAME . '/change-password";
            </script>';
            exit();
        } else {
            $_SESSION['toast_message'] = "Sai mật khẩu.";
            $_SESSION['toast_type'] = "danger";
        }
    } else {
        // Lưu thông báo lỗi vào session
        $_SESSION['toast_message'] = $validationResult;
        $_SESSION['toast_type'] = "danger"; // Lỗi
    }

    // Chuyển hướng lại để làm mới form
    // header('Location: ' . $_SERVER['PHP_SELF']);
    // exit();
}

?>

<div class="container-fluid">
    <!-- Toast Thông Báo -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <?php if (!empty($_SESSION['toast_message'])) : ?>
            <div class="toast align-items-center text-bg-<?php echo $_SESSION['toast_type']; ?> border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $_SESSION['toast_message']; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <?php
            // Xóa thông báo sau khi hiển thị
            unset($_SESSION['toast_message']);
            unset($_SESSION['toast_type']);
            ?>
        <?php endif; ?>
    </div>

    <!-- Form Đổi Mật Khẩu -->
    <div class="row justify-content-center align-items-center mt-4">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title text-center mb-4">Đổi Mật Khẩu</h5>
                    <form action="" method="POST">
                        <!-- Mật khẩu hiện tại -->
                        <div class="mb-3 position-relative">
                            <label for="currentPassword" class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control" id="currentPassword" name="current_password" placeholder="Nhập mật khẩu hiện tại" required>
                            <button type="button" class="btn toggle-password position-absolute end-0 top-50 translate-middle-y" data-target="currentPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <!-- Mật khẩu mới -->
                        <div class="mb-3 position-relative">
                            <label for="newPassword" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="newPassword" name="new_password" placeholder="Nhập mật khẩu mới" required>
                            <button type="button" class="btn toggle-password position-absolute end-0 top-50 translate-middle-y" data-target="newPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <!-- Xác nhận mật khẩu mới -->
                        <div class="mb-3 position-relative">
                            <label for="confirmPassword" class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="Xác nhận mật khẩu mới" required>
                            <button type="button" class="btn toggle-password position-absolute end-0 top-50 translate-middle-y" data-target="confirmPassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <!-- Nút đổi mật khẩu -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Đổi Mật Khẩu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS -->
<style>
    .toggle-password {
        border: none;
        background: none;
        padding: 0;
        font-size: 1.25rem;
        color: #6c757d;
        cursor: pointer;
        margin-right: 10px;
        margin-top: 17px;
    }

    .toggle-password:focus {
        outline: none;
        box-shadow: none;
    }
</style>

<!-- JavaScript -->
<script>
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function() {
            const inputId = this.getAttribute('data-target');
            const input = document.getElementById(inputId);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    });
</script>