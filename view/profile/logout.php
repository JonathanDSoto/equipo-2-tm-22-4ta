<?php
	include_once "../../app/config.php";

    if(isset($_SESSION['token'])){
    	header('location: '.BASE_PATH.'products');
	}
?> 

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <title>Sign In</title>
    <?php include "../../layout/head.template.php" ?>

</head>

<body>
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
    <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row justify-content-center" id="auth-particles">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-body p-4 text-center">
                                <lord-icon src="https://cdn.lordicon.com/hzomhqxz.json" trigger="loop" colors="primary:#4b38b3,secondary:#08a88a" style="width:180px;height:180px">
                                </lord-icon>

                                <div class="mt-4 pt-2">
                                    <h5>You are Logged Out</h5>
                                    <p class="text-muted">:)</p>
                                    <div class="mt-4">
                                        <a href="<?= BASE_PATH ?>login" class="btn btn-primary w-100">Sign In</a>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->
    </div>
    <!-- end auth-page-wrapper -->

    <?php include "../../layout/scripts.template.php" ?>
</body>
</html>