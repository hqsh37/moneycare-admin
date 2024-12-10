<?php
$sumUser = Auth::countRowAll();
$sumAccount = Account::countRowAll();
$sumSavings = Savings::countRowAll();
$sumTransaction = Transactions::countRowAll();
?>

<div class="container-fluid">
    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>Tổng quan</h2>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- ========== title-wrapper end ========== -->
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon purple">
                    <i class="lni lni-user"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Tổng người dùng</h6>
                    <h3 class="text-bold mb-10"><?php echo $sumUser; ?></h3>
                </div>
            </div>
            <!-- End Icon Cart -->
        </div>
        <!-- End Col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon success">
                    <i class="lni lni-credit-cards"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Tổng số tài khoản</h6>
                    <h3 class="text-bold mb-10"><?php echo $sumAccount; ?></h3>
                </div>
            </div>
            <!-- End Icon Cart -->
        </div>
        <!-- End Col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon orange">
                    <i class="lni lni-coin"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Tổng tài khoản tiết kiệm</h6>
                    <h3 class="text-bold mb-10"><?php echo $sumSavings; ?></h3>
                </div>
            </div>
            <!-- End Icon Cart -->
        </div>
        <!-- End Col -->
        <div class="col-xl-3 col-lg-4 col-sm-6">
            <div class="icon-card mb-30">
                <div class="icon primary">
                    <i class="lni lni-pencil-alt"></i>
                </div>
                <div class="content">
                    <h6 class="mb-10">Tổng số giao dịch</h6>
                    <h3 class="text-bold mb-10"><?php echo $sumTransaction; ?></h3>
                </div>
            </div>
            <!-- End Icon Cart -->
        </div>
        <!-- End Col -->
    </div>
</div>