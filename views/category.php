<?php
// Số lượng dòng trên mỗi trang
$rowsPerPage = 9;

// Lấy trang hiện tại từ URL, nếu không có thì mặc định là 1
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Tính toán offset
$offset = ($currentPage - 1) * $rowsPerPage;

// Lấy tổng số dòng
$totalRows = count(Categories::finds(["id_user" => 0]));

// Tính tổng số trang
$totalPages = ceil($totalRows / $rowsPerPage);

// Lấy dữ liệu cho trang hiện tại
$categories = Categories::finds(["id_user" => 0], $offset, $rowsPerPage);
?>


<div class="container-fluid">
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>Quản lý Hạng Mục<code></code></h2>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <div class="tables-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="table-wrapper table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tên</th>
                                    <th>Icon</th>
                                    <th>Thư viện icon</th>
                                    <th>Loại hạng mục</th>
                                    <th>Id mục cha</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $item) : ?>
                                    <tr>
                                        <td><?php echo $item->id; ?></td>
                                        <td><?php echo $item->tenhangmuc; ?></td>
                                        <td><?php echo $item->icon; ?></td>
                                        <td><?php echo $item->iconlib; ?></td>
                                        <td><?php echo $item->loaihangmuc; ?></td>
                                        <td><?php echo $item->hanmuccha; ?></td>
                                        <td>
                                            <div class="d-flex">
                                                <button class="btn text-warning">
                                                    <i class="lni lni-pencil"></i>
                                                </button>
                                                <button class="btn text-danger">
                                                    <i class="lni lni-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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