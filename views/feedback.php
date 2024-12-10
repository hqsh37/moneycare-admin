<?php
$tt = 1;
// Số lượng dòng trên mỗi trang
$rowsPerPage = 9;

// Lấy trang hiện tại từ URL, nếu không có thì mặc định là 1
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Tính toán offset
$offset = ($currentPage - 1) * $rowsPerPage;

// Lấy tổng số dòng
$totalRows = Feedback::countRowAll();

// Tính tổng số trang
$totalPages = ceil($totalRows / $rowsPerPage);

// Lấy dữ liệu cho trang hiện tại
$feedback = Feedback::finds(null, $offset, $rowsPerPage);
?>

<div class="container-fluid">
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>Quản lý Feedback</h2>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <div class="tables-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <h6 class="mb-10">Feedback</h6>
                    <p class="text-sm mb-20">
                        Đánh giá người dùng.
                    </p>
                    <div class="table-wrapper table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="lead-info">
                                        <h6>STT</h6>
                                    </th>
                                    <th class="lead-email">
                                        <h6>Tiêu đề</h6>
                                    </th>
                                    <th class="lead-phone">
                                        <h6>Nội dung</h6>
                                    </th>
                                    <th class="lead-company">
                                        <h6>Email</h6>
                                    </th>
                                </tr>
                                <!-- end table row-->
                            </thead>
                            <tbody>
                                <?php foreach ($feedback as $item) : ?>
                                    <tr>
                                        <td>
                                            <p><?php echo $tt++; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $item->tieude; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $item->noidung; ?></p>
                                        </td>
                                        <td>
                                            <p><?php echo $item->email; ?></p>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                                <!-- end table row -->
                            </tbody>
                        </table>
                        <!-- end table -->
                    </div>
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container-fluid">
        <ul class="pagination justify-content-center">
            <!-- Nút về trang trước -->
            <?php if ($currentPage > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>">Trước</a>
                </li>
            <?php else : ?>
                <li class="page-item disabled">
                    <span class="page-link">Trước</span>
                </li>
            <?php endif; ?>

            <!-- Các số trang -->
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <!-- Nút tới trang sau -->
            <?php if ($currentPage < $totalPages) : ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Sau</a>
                </li>
            <?php else : ?>
                <li class="page-item disabled">
                    <span class="page-link">Sau</span>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <!-- end container -->
</footer>