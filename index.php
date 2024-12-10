<?php
include 'config.php';

$is404 = $app->check404Page();

$auth = false;
if (isset($_SESSION['admin'])) {
    $admin = $_SESSION['admin'];
    $auth = true;

    $name = $admin->name;
    $email = $admin->email;
    $gender = $admin->gender;
    $phone = $admin->phone;
    $birth = $admin->birth;
}

?>


<?php if (!$is404) : ?>

    <?php if ($auth) : ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link rel="shortcut icon" href="./assets/images/logo/logo-icon-only.png" type="image/x-icon" />
            <title>Money Care | admin</title>

            <!-- ========== All CSS files linkup ========= -->
            <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
            <link rel="stylesheet" href="assets/css/lineicons.css" rel="stylesheet" type="text/css" />
            <link rel="stylesheet" href="assets/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
            <link rel="stylesheet" href="assets/css/fullcalendar.css" />
            <link rel="stylesheet" href="assets/css/fullcalendar.css" />
            <link rel="stylesheet" href="assets/css/main.css" />
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

        </head>

        <body>
            <!-- ======== Preloader =========== -->
            <div id="preloader">
                <div class="spinner"></div>
            </div>
            <!-- ======== Preloader =========== -->
            <!-- ======== sidebar-nav start =========== -->
            <?php $is404 || include "./views/sidebar.php" ?>

            <div class="overlay"></div>
            <!-- ======== sidebar-nav end =========== -->

            <!-- ======== main-wrapper start =========== -->
            <main class="main-wrapper">
                <!-- ========== header start ========== -->
                <?php include "./views/header.php" ?>
                <!-- ========== header end ========== -->

                <!-- ========== section start ========== -->
                <section class="section">
                    <?php $app->run(); ?>
                    <!-- end container -->
                </section>
                <!-- ========== section end ========== -->

                <!-- ========== footer start =========== -->
                <?php include "./views/footer.php" ?>
                <!-- ========== footer end =========== -->
            </main>
            <!-- ======== main-wrapper end =========== -->

            <!-- ========= All Javascript files linkup ======== -->
            <script src="assets/js/bootstrap.bundle.min.js"></script>
            <script src="assets/js/Chart.min.js"></script>
            <script src="assets/js/dynamic-pie-chart.js"></script>
            <script src="assets/js/moment.min.js"></script>
            <script src="assets/js/fullcalendar.js"></script>
            <script src="assets/js/jvectormap.min.js"></script>
            <script src="assets/js/world-merc.js"></script>
            <script src="assets/js/polyfill.js"></script>
            <script src="assets/js/main.js"></script>
        </body>

        </html>


    <?php else : include './views/login.php'; ?>

    <?php endif; ?>
<?php else : include './views/404.php'; ?>

<?php endif; ?>