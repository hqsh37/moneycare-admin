<?php
include "../config.php";
// destroy session
unset($_SESSION['admin']);

echo '<script>
alert("Đăng xuất thành công!");
window.location.href = "' . PROJECT_NAME . '/login";
</script>';
