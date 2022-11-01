<?php
	include_once "../../app/config.php";
    include_once '../../app/UserController.php';

    if(!isset($_SESSION['token'])){
    	header('location: '.BASE_PATH.'login');
	}

    $userControl = new UserController();
    $userData = $userControl -> getEspecificUser($_GET['id']);
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
                                    <img src="<?php if(isset($userData->avatar)) echo $userData->avatar; else echo ""; ?>" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="Avatar not found.">
                                    <?php if(isset($userData->avatar)) { ?>
                                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                            <label data-bs-toggle="modal" data-bs-target="#updateProfileImageModal" class="profile-photo-edit avatar-xs">
                                                <span class="avatar-title rounded-circle bg-light text-body">
                                                    <i class="ri-camera-fill"></i>
                                                </span>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                                <h4 class="fs-18 mb-1 text-primary">
                                    <?php if(isset($userData->name)) echo $userData->name; else echo "Name not found."; ?>
                                    <?php if(isset($userData->lastname)) echo $userData->lastname; else echo "<br>Lastname not found."; ?>
                                </h4>
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
                                    <form>
                                        <div class="row py-3">
                                            <div class="col-lg-4">
                                                <div class="my-3">
                                                    <h6 class="fs-14 mb-1 text-primary">Role</h6>
                                                    <p class="text"><?php if(isset($userData->role)) echo $userData->role; else echo "Role not found."; ?></p>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="my-3">
                                                    <h6 class="fs-14 mb-1 text-primary">Email</h6>
                                                    <p class="text"><?php if(isset($userData->email)) echo $userData->email; else echo "Email not found."; ?></p>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="my-3">
                                                    <h6 class="fs-14 mb-1 text-primary">Phone</h6>
                                                    <p class="text"><?php if(isset($userData->phone_number)) echo $userData->phone_number; else echo "Phone not found."; ?></p>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="my-3">
                                                    <h6 class="fs-14 mb-1 text-primary">Created by</h6>
                                                    <p class="text"><?php if(isset($userData->created_by)) echo $userData->created_by; else echo "Creator not found."; ?></p>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div class="my-3">
                                                    <h6 class="fs-14 mb-1 text-primary">Updated at</h6>
                                                    <p class="text"><?php if(isset($userData->updated_at)) echo $userData->updated_at; else echo "Last update not found."; ?></p>
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

    <div id="updateProfileImageModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" method="post" action="<?= BASE_PATH ?>user">
                        <div class="mt-2 text-center">
                            <div class="my-2 pt-2 fs-15 mx-4 mx-sm-5">
                                <h4>Select an image</h4>
                                <div>
                                    <input class="form-control py-2" type="file" id="avatar" name="avatar" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                            <input type="hidden" id="typeAction" name="action" value="updateImage">
                            <input type="hidden" id="id" name="id" value="<?= $userData->id ?>">
                            <input type="hidden" name="global_token" value="<?= $_SESSION['global_token'] ?>" >
                            <button type="submit" class="btn w-sm btn-primary">Save</button>
                            <button type="button" class="btn w-sm btn-danger" data-bs-dismiss="modal" >Cancel</button>
                        </div>
                    </form>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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

    <?php include "../../layout/scripts.template.php" ?>
</body>


</html>