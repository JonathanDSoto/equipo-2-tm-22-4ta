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
                                <div class="tab-pane" id="changePassword" role="tabpanel">
                                    <form action="javascript:void(0);">
                                        <div class="row g-2">
                                            <div class="card">

                                                <x-table>
                                                    <x-slot name="tools">

                                                    </x-slot>
                                                    <x-slot name="thead">
                                                        <th class="sort" data-sort="customer_name">Clave</th>
                                                        <th class="sort" data-sort="email">Nombre</th>
                                                        <th class="sort" data-sort="customer_name">Tipo</th>
                                                        <th class="sort" data-sort="email">Modalidad</th>
                                                        <th class="sort" data-sort="phone">Constancia</th>
                                                        <th class="sort" data-sort="phone">Duración en horas</th>
                                                        <th class="sort" data-sort="action">Acciones</th>
                                                    </x-slot>
                                                    <x-slot name="tbody">
                                                    <tr v-for="student in students">

                                                        <td class="no_control">@{{ student.no_control }}</td>
                                                        <td class="center">@{{ student.center_id }}</td>
                                                        <td class="student_name">@{{ student.name }}</td>
                                                        <td class="no_control">@{{ student.no_control }}</td>
                                                        <td class="center">@{{ student.center_id }}</td>
                                                        <td class="student_name">@{{ student.name }}</td>
                                                        <td>
                                                            <div class="d-flex gap-2">

                                                                <div class="remove">
                                                                    <button class="btn btn-sm btn-danger remove-item-btn">Eliminar</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </x-slot>
                                                </x-table>
                                            </div>
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

    <div class="customizer-setting d-none d-md-block">
        <div class="btn-info btn-rounded shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
            <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
        </div>
    </div>

    <?php include "../../layout/scripts.template.php" ?>
</body>


</html>