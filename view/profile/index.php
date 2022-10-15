<?php
	include_once "../../app/config.php";

    if(!isset($_SESSION['token'])){
    	header('location: '.BASE_PATH.'login');
	}
?> 

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <title>Profile</title>
    <?php include "../../layout/head.template.php" ?>
</head>
<body>
    <!-- Begin page -->
    <div id="layout-wrapper">

    <?php include "../../layout/navbar.template.php" ?>
    <?php include "../../layout/sidebar.template.php" ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                
            <div class="row">
                <div class="col-xxl-3">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                    <img src="<?= $_SESSION['avatar'] ?>" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                        <input id="profile-img-file-input" type="file" class="profile-img-file-input">
                                        <label data-bs-toggle="modal" data-bs-target="#removeItemModal" class="profile-photo-edit avatar-xs">
                                            <span class="avatar-title rounded-circle bg-light text-body">
                                                <i class="ri-camera-fill"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <h4 class="fs-18 mb-1 text-primary"><?= $_SESSION['name']." ".$_SESSION['lastname'] ?></h4>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                    
                </div>
                <!--end col-->
                <div class="col-xxl-9">
                    <div class="card">
                        <div class="card-header mt-2">
                            <h6 class="card-title text-primary">Personal details</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                    <form action="javascript:void(0);">
                                        <div class="row py-3">
                                            <div class="col-lg-3">
                                                <div class="my-3">
                                                    <h6 class="fs-14 mb-1 text-primary">Role</h6>
                                                    <p class="text"><?php if(isset($_SESSION['role'])) echo $_SESSION['role']; else echo "Role not found."; ?></p>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-3">
                                                <div class="my-3">
                                                    <h6 class="fs-14 mb-1 text-primary">Created by</h6>
                                                    <p class="text"><?php if(isset($_SESSION['created_by'])) echo $_SESSION['created_by']; else echo "Creator not found"; ?></p>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-3">
                                                <div class="my-3">
                                                    <h6 class="fs-14 mb-1 text-primary">Email</h6>
                                                    <p class="text"><?php if(isset($_SESSION['email'])) echo $_SESSION['email']; else echo "Email not found"; ?></p>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-3">
                                                <div class="my-3">
                                                    <h6 class="fs-14 mb-1 text-primary">Phone</h6>
                                                    <p class="text"><?php if(isset($_SESSION['phone_number'])) echo $_SESSION['phone_number']; else echo "Phone not found"; ?></p>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                                <!--end tab-pane-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page-content -->


            </div><!-- End Page-content -->

            <?php include "../../layout/footer.template.php" ?>
        </div><!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <div id="removeItemModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="">
                        <div class="mt-2 text-center">
                            <div class="my-2 pt-2 fs-15 mx-4 mx-sm-5">
                                <h4>Select an image</h4>
                                <div>
                                    <input class="form-control py-2" type="file" id="formFile">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                            <input type="hidden" name="" value="">
                            <button type="submit" class="btn w-sm btn-primary" data-bs-dismiss="modal">Submit</button>
                            <button type="button" class="btn w-sm btn-danger " id="delete-product">Cancel</button>
                        </div>
                    </form>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <?php include "../../layout/scripts.template.php" ?>
</body>


</html>